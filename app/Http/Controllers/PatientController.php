<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Models\City;
use App\Models\Diagnosis;
use App\Models\MedicalRecord;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $searchFirst = FacadesRequest::input('search_first_name');
        $searchLast = FacadesRequest::input('search_last_name');
        $searchMiddle = FacadesRequest::input('search_middle_name');

        $patients = Patient::query()
            ->when($searchFirst || $searchLast || $searchMiddle, function ($query) use ($searchFirst, $searchLast, $searchMiddle) {
                $query->when($searchFirst, function ($q, $value) {
                    $q->where('first_name', 'like', "%{$value}%");
                })
                    ->when($searchMiddle, function ($q, $value) {
                        $q->where('middle_name', 'like', "%{$value}%");
                    })
                    ->when($searchLast, function ($q, $value) {
                        $q->where('last_name', 'like', "%{$value}%");
                    });
            }, function ($query) {
                // Force empty result
                $query->whereRaw('1 = 0');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString()
            ->through(fn($patient) => [
                'id' => $patient->id,
                'full_name' => $patient->full_name,
                'full_address' => $patient->full_address,
                'age_years' => $patient->age_years,
                'sex' => $patient->sex,
                'birthdate' => $patient->birthdate,
            ]);

        return Inertia::render('Patients/Index', [
            'patients' => $patients,
            'filters' => FacadesRequest::only([
                'search_first_name',
                'search_middle_name',
                'search_last_name'
            ])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cities = City::where('province_id', City::CATANDUANES)->get();
        return Inertia::render('Patients/Create', [
            'cities' => $cities,
            'diagnoses' => Diagnosis::all(),
            'prefill' => FacadesRequest::only([
                'search_first_name',
                'search_middle_name',
                'search_last_name',
            ]),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $patient = null; // Define $patient outside the closure

        DB::transaction(function () use ($request, &$patient) {
            $validated = $request->validate([
                'first_name' => 'required|string',
                'middle_name' => 'nullable|string',
                'birthdate' => 'required|date',
                'last_name' => 'required|string',
                'suffix' => 'nullable|string|in:Jr.,Sr.,II,III,IV,V',
                'barangay_id' => 'required|exists:barangays,id',
                'city_id' => 'required|exists:cities,id',
                'sex' => 'required|boolean',
            ]);

            $validated['encoded_by'] = Auth::id();
            $patient = Patient::create($validated);
        });

        if (!$patient) {
            // Handle the case where patient creation failed
            return redirect()->route('patients.index')->with('error', 'Failed to create patient.');
        }

        return redirect()->route('patients.show', $patient->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        return Inertia::render('Patients/Show', [
            'patient' => $patient,
            'encounters' => $patient->encounters->sortBy('encounter_date')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {

        $cities = City::where('province_id', City::CATANDUANES)->get();
        // $patient = Patient::findOrFail($id);

        return Inertia::render('Patients/Edit', [
            'patient' => $patient,
            'full_name' => $patient->full_name,
            'cities' => $cities,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'first_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'birthdate' => 'required|date',
            'last_name' => 'required|string',
            'suffix' => 'nullable|string|in:Jr.,Sr.,II,III,IV,V',
            'barangay_id' => 'required|exists:barangays,id',
            'city_id' => 'required|exists:cities,id',
            'sex' => 'required|boolean',
        ]);

        $patient->update($validated);


        return redirect()->route('patients.show', $patient);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        //
    }
}
