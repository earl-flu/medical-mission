<?php

namespace App\Http\Controllers;

use App\Models\Diagnosis;
use App\Models\Encounter;
use App\Models\Event;
use App\Models\Patient;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

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
            'patient' => $patient,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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
                'patient_birthdate' => 'required|date',
                'encounter_date' => 'required|date',
                'services' => 'array|exists:services,id',
                'remarks' => 'nullable|string',
            ]);
            $validated['age'] = Carbon::parse($validated['patient_birthdate'])->age;
            $validated['encoded_by'] = Auth::id();

            $encounter = Encounter::create($validated);
            $encounter->services()->sync($request->services);
        });

        return redirect()->route('patients.show', $encounter->patient);
    }

    /**
     * Display the specified resource.
     */
    public function show(Encounter $encounter)
    {
        $encounter->load('patient');
        return Inertia::render('Encounters/Show', [
            'encounter' => $encounter,
            'ordered_items' => $encounter->orderItems->load('item')
        ]);
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
