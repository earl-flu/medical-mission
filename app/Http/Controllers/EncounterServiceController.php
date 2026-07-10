<?php

namespace App\Http\Controllers;

use App\Models\Encounter;
use App\Models\EncounterService;
use App\Models\Service;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EncounterServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}

    /**
     * Show the form for creating a new resource.
     */
    public function create(Encounter $encounter)
    {
        $encounter->load('patient');
        $encounter->load('event');
        $encounter->load('encounter_service.service');
        return Inertia::render('EncounterService/Create', [
            'services' => Service::where('status', 1)->orderBy('name', 'asc')->get(),
            'encounter' => $encounter
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'services' => 'required|array',
            'services.*' => 'exists:services,id',
        ]);

        $encounterId = $request->route('encounter');
        $encounter = Encounter::findOrFail($encounterId);

        foreach ($validated['services'] as $serviceId) {
            $encounterService = EncounterService::where('encounter_id', $encounter->id)
                ->where('service_id', $serviceId)
                ->first();

            if ($encounterService) {
                // If already exists, update is_serve to true
                if (!$encounterService->is_serve) {
                    $encounterService->is_serve = true;
                    $encounterService->save();
                }
            } else {
                // Otherwise, create and set is_serve to true
                EncounterService::create([
                    'encounter_id' => $encounter->id,
                    'service_id' => $serviceId,
                    'is_serve' => true,
                ]);
            }
        }

        return redirect()->route('encounter-service.create', $encounter->id)
            ->with('success', 'Selected services have been set to served.');
    }

    /**
     * Display the specified resource.
     */
    public function show(EncounterService $encounterService)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EncounterService $encounterService)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EncounterService $encounterService)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EncounterService $encounterService)
    {
        //
    }
}
