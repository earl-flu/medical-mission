<?php

namespace App\Http\Controllers;

use App\Models\Diagnosis;
use App\Models\Employment;
use App\Models\Encounter;
use App\Models\Event;
use App\Models\Office;
use App\Models\Patient;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Spatie\LaravelPdf\Facades\Pdf;

class EncounterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Patient $patient)
    {
        return Inertia::render('Encounters/Create', [
            'diagnoses' => Diagnosis::all(),
            'events' => Event::where('status', 1)->orderBy('name', 'asc')->get(),
            'services' => Service::where('status', 1)->orderBy('name', 'asc')->get(),
            'offices' => Office::where('is_active', 1)->orderBy('name', 'asc')->get(),
            'employments' => Employment::where('is_active', 1)->orderBy('name', 'asc')->get(),
            'patient' => $patient,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $encounter = DB::transaction(function () use ($request) {
            $validated = $request->validate([
                'is_opto' => 'nullable|boolean',
                'is_pregnant' => 'nullable|boolean',
                'bp_systolic' => 'nullable|integer|min:0|max:800',
                'bp_diastolic' => 'nullable|integer|min:0|max:800',
                'temperature' => 'nullable|numeric|min:0',
                'pulse_rate' => 'nullable|integer|min:0',
                'respiratory_rate' => 'nullable|integer|min:0',
                'oxygen_saturation' => 'nullable|integer|min:0',
                'event_id' => 'required|exists:events,id',
                'diagnosis_id' => 'nullable|exists:diagnoses,id',
                'patient_id' => 'required|exists:patients,id',
                'patient_birthdate' => 'required|date',
                'encounter_date' => 'required|date',
                'services' => 'nullable|array',
                'services.*' => 'exists:services,id',
                'remarks' => 'nullable|string',
                'is_positive' => 'sometimes|boolean',
                'office_id' => 'nullable|exists:offices,id',
                'employment_id' => 'nullable|exists:employments,id',
            ]);

            $validated['age'] = Carbon::parse($validated['patient_birthdate'])
                ->diffInYears(Carbon::parse($validated['encounter_date']));

            $validated['encoded_by'] = Auth::id();

            $encounter = Encounter::create($validated);
            $encounter->services()->sync($validated['services'] ?? []);

            return $encounter;
        });

        return redirect()->route('patients.show', $encounter->patient);
    }

    /**
     * Display the specified resource.
     */
    public function show(Encounter $encounter)
    {
        $encounter->load('patient');
        // $encounter->load('employment');
        if ($encounter->office) {
            $office = $encounter->office;
            $officeName = "{$office->abbreviation} - {$office->name}";
        } else {
            $officeName = 'N/A';
        }
        return Inertia::render('Encounters/Show', [
            'officeName' => $officeName,
            'encounter' => $encounter,
            'ordered_items' => $encounter->orderItems->load('item')
        ]);
    }

    public function generateOrderedItemsPdf(Encounter $encounter)
    {
        // Load related models
        $encounter->load(['patient', 'orderItems.item', 'event']);

        $orderedItems = $encounter->orderItems->load('item');

        return Pdf::view('pdf.dispensed-meds', [
            'encounter' => $encounter,
            'orderedItems' => $orderedItems,
        ])
            ->withBrowsershot(function ($browsershot) {
                $browsershot->setNodeBinary(env('NODE_DIR'));
            })
            ->name(
                strtoupper($encounter->patient->full_name)

                    . ' - '
                    . $encounter->id
                    . ' - '
                    . now()->format('mdY')
                    . '.pdf'
            )

            ->download();
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Encounter $encounter)
    {
        $encounter->load('patient');
        $encounter->load('services');

        return Inertia::render('Encounters/Edit', [
            'encounter' => $encounter,
            'diagnoses' => Diagnosis::all(),
            'events' => Event::where('status', 1)->get(),
            'services' => Service::where('status', 1)->orderBy('name', 'asc')->get(),
            'offices' => Office::orderBy('name', 'asc')->get(),
            'employments' => Employment::where('is_active', 1)->orderBy('name', 'asc')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Encounter $encounter)
    {
        DB::transaction(function () use ($request, &$encounter) {
            $validated = $request->validate([
                'is_opto' => 'nullable|boolean',
                'is_pregnant' => 'nullable|boolean',
                'bp_systolic' => 'nullable|integer|min:0|max:800',
                'bp_diastolic' => 'nullable|integer|min:0|max:800',
                'temperature' => 'nullable|numeric|min:0',
                'pulse_rate' => 'nullable|integer|min:0',
                'respiratory_rate' => 'nullable|integer|min:0',
                'oxygen_saturation' => 'nullable|integer|min:0',
                'event_id' => 'required|exists:events,id',
                'diagnosis_id' => 'nullable|exists:diagnoses,id',
                'patient_id' => 'required|exists:patients,id',
                'encounter_date' => 'required|date',
                'services' => 'array|exists:services,id',
                'remarks' => 'nullable|string',
                'is_positive' => 'nullable|boolean',
                'office_id' => 'nullable|exists:offices,id',
                'employment_id' => 'nullable|exists:employments,id',
            ]);

            $encounter->update($validated);
            $encounter->services()->sync($request->services);
        });

        return redirect()->route('patients.show', $encounter->patient);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Encounter $encounter)
    {
        $patient = $encounter->patient;
        $encounter->delete();
        return redirect()->route('patients.show', $patient);
    }
}
