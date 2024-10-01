<?php

namespace App\Http\Controllers;

use App\Models\Encounter;
use App\Models\Event;
use App\Models\Item;
use App\Models\MedicalRecord;
use App\Models\OrderItem;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request  $request)
    {
        $events = Event::all()->sortBy('name')->values()->toArray();

        return Inertia::render('Dashboard', ['events' => $events]);
    }

    public function getStatistics($eventid)
    {
        // dd($request->eventId);
        $statistics = Event::findOrFail($eventid)->encounters()
            ->select(
                DB::raw('COUNT(*) as total_patients'),
                DB::raw('SUM(CASE WHEN age < 18 THEN 1 ELSE 0 END) as total_pedia'),
                DB::raw('SUM(CASE WHEN age >= 60 THEN 1 ELSE 0 END) as total_senior_citizen'),
                DB::raw('SUM(CASE WHEN is_pregnant = 1 THEN 1 ELSE 0 END) as total_pregnant')
            )
            ->first();

        return response()->json([
            'total_patients' => $statistics->total_patients,
            'total_pedia' => $statistics->total_pedia,
            'total_senior_citizen' => $statistics->total_senior_citizen,
            'total_pregnant' => $statistics->total_pregnant,
        ]);
    }

    public function getDispensedMedsData($eventId)
    {
        $dispensedMeds = DB::table('encounters')
            ->where('event_id', $eventId)
            ->join('order_items', 'encounters.id', '=', 'order_items.encounter_id')
            ->join('items', 'order_items.item_id', '=', 'items.id')
            ->select('items.id as item_id', 'items.name as item_name', DB::raw('SUM(order_items.quantity) as total_quantity'))
            ->groupBy('items.id', 'items.name')
            ->get();

        return response()->json($dispensedMeds);
    }

    public function getEncounterServiceData($eventId)
    {
        $services = Encounter::where('event_id', $eventId)
            ->with('services')
            ->get()
            ->pluck('services')
            ->flatten();

        // Group by service id, sum the count, and transform the structure
        $groupedServices = $services->groupBy('id')->map(function ($serviceGroup) {
            $firstService = $serviceGroup->first();
            return [
                'id' => $firstService->id,
                'name' => $firstService->name,
                'total' => $serviceGroup->count(),
            ];
        })->values();

        // Return as JSON response
        return response()->json($groupedServices);
    }

    public function getMunicipalityData($eventId)
    {
        $encountersByCity = Encounter::where('event_id', $eventId)
            ->join('patients', 'encounters.patient_id', '=', 'patients.id')
            ->join('cities', 'patients.city_id', '=', 'cities.id')
            ->select('cities.name as city_name', DB::raw('COUNT(encounters.id) as total_encounters'))
            ->groupBy('cities.name')
            ->get();

        return response()->json($encountersByCity);
    }

    public function getBarangayData($eventId, $municipalityName)
    {
        $encountersByBarangay = Encounter::where('event_id', $eventId)
            ->join('patients', 'encounters.patient_id', '=', 'patients.id')
            ->join('cities', 'patients.city_id', '=', 'cities.id')
            ->join('barangays', 'patients.barangay_id', '=', 'barangays.id')
            ->select('barangays.name as barangay_name', DB::raw('COUNT(encounters.id) as total_encounters'))
            ->where('cities.name', $municipalityName)
            ->groupBy('barangays.name')
            ->get();

        return response()->json($encountersByBarangay);
    }

    public function getAvailableStocks()
    {
        $items = Item::where('quantity', '>', 0)
            ->orderBy('quantity', 'desc')
            ->get()->toArray();
        // dd($items);
        return response()->json($items);
    }

    public function getEncountersByProgram($eventId)
    {
        $encountersByProgram = Encounter::where('encounters.event_id', $eventId)
            ->join('order_items', 'encounters.id', '=', 'order_items.encounter_id')
            ->join('items', 'order_items.item_id', '=', 'items.id')
            ->join('programs', 'items.program_id', '=', 'programs.id')
            ->select('programs.code as program_code', DB::raw('COUNT(DISTINCT encounters.id) as total_encounters'))
            ->groupBy('programs.id', 'programs.code')
            ->orderBy('total_encounters', 'desc')
            ->get();

        $result = $encountersByProgram->mapWithKeys(function ($item) {
            return [$item['program_code'] => $item['total_encounters']];
        });

        return response()->json($result);
    }
}
