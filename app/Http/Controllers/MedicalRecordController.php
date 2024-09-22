<?php

namespace App\Http\Controllers;

use App\Models\Diagnosis;
use App\Models\MedicalRecord;
use App\Models\Patient;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MedicalRecordController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MedicalRecord $medicalRecord)
    {
        $full_name = $medicalRecord->patient->full_name;

        return Inertia::render('MedicalRecords/Edit', [
            'medical_record' => $medicalRecord->load('patient'),
            'full_name' => $full_name,
            'diagnoses' => Diagnosis::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MedicalRecord $medicalRecord)
    {
        //validation
        $validated = $request->validate([
            'is_opto' => 'required|boolean',
            'is_pregnant' => 'required|boolean',
            'diagnosis_id' => 'nullable|exists:diagnoses,id',
            'bp_systolic' => 'required|integer|min:0|max:800',
            'bp_diastolic' => 'required|integer|min:0|max:800',
            'temperature' => 'required|numeric|min:0',
            'pulse_rate' => 'nullable|integer|min:0',
            'respiratory_rate' => 'nullable|integer|min:0',
            'oxygen_saturation' => 'nullable|integer|min:0',
        ]);

        $medicalRecord->update($validated);

        return redirect()->route('patients.show', $medicalRecord->patient);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
