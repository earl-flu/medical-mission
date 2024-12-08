<?php

namespace App\Http\Controllers;

use App\Models\Encounter;
use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DrugDashboardController extends Controller
{
    public function index(Request  $request)
    {
        return Inertia::render('DrugDashboard', []);
    }

    public function getTotals()
    {
        $totalPatients = $this->getTotalPatients();
        $totalPerOffice = $this->getTotalPerOffice();
        $positivePerOffice = $this->getPositivePerOffice();
        $totalPositiveNegative = $this->getTotalPositiveNegative();
        // dd($totalPositiveNegative);
        return Inertia::render('DrugDashboard', [
            'totalPatients' => $totalPatients,
            'totalPerOffice' => $totalPerOffice,
            'positivePerOffice' => $positivePerOffice,
            'totalPositiveNegative' => $totalPositiveNegative
        ]);
    }

    private function getTotalPatients()
    {
        return Encounter::where('event_id', Encounter::DRUG_EVENT_CODE)->count();
    }

    public function getTotalPerOffice()
    {
        $totalPerOffice = Encounter::where('event_id', Encounter::DRUG_EVENT_CODE)
            ->get()
            ->groupBy('office_id')
            ->map(function ($encounters, $officeId) {
                $officeName = Office::find($officeId)->name ?? 'Unknown Office';
                return ['officeName' => $officeName, 'total' => $encounters->count()]; // Updated format
            })
            ->values() // Ensure we get a sequential array
            ->sortByDesc('total') // Sort by total in descending order
            ->toArray(); // Convert to array

        return response()->json($totalPerOffice);
    }

    public function getPositivePerOffice()
    {
        $totalPositivePerOffice = Encounter::where('event_id', Encounter::DRUG_EVENT_CODE)
            ->where('is_positive', 1)
            ->get()
            ->groupBy('office_id')
            ->map(function ($encounters, $officeId) {
                $officeName = Office::find($officeId)->name ?? 'Unknown Office';
                return ['officeName' => $officeName, 'total' => $encounters->count()]; // Updated format
            })
            ->values() // Ensure we get a sequential array
            ->sortByDesc('total') // Sort by total in descending order
            ->toArray(); // Convert to array

        return response()->json($totalPositivePerOffice);
    }

    public function getTotalPositiveNegative()
    {
        return Encounter::where('event_id', Encounter::DRUG_EVENT_CODE)
            ->get()
            ->groupBy(function ($encounter) {
                return $encounter->is_positive ? 'positive' : 'negative';
            })
            ->mapWithKeys(function ($encounters, $type) {
                return [$type => $encounters->count()];
            });
    }


    public function positivePatients()
    {
        $positivePatients = Encounter::where('is_positive', 1)->with(['patient', 'office'])->get();
        return $positivePatients;
    }
}
