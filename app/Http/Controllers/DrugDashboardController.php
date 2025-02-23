<?php

namespace App\Http\Controllers;

use App\Models\Employment;
use App\Models\Encounter;
use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request as FacadesRequest;
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
        $results = ($this->getTotalPositiveNegative());

        return response()->json([
            'totalPatients' => $totalPatients ?? 0,
            'positive' => $results['positive'] ?? 0,
            'negative' => $results['negative'] ?? 0,
        ]);
    }

    private function getTotalPatients()
    {
        return Encounter::where('event_id', Encounter::DRUG_EVENT_CODE)->count();
    }

    public function getTotalPerOffice()
    {
        $totalPerOffice = DB::table('encounters as enc')
            ->leftJoin('offices as o', 'enc.office_id', '=', 'o.id')
            ->select(
                'o.name as office_name',
                DB::raw('COUNT(*) AS total'),
                DB::raw('SUM(CASE WHEN enc.is_positive = 1 THEN 1 ELSE 0 END) AS total_positive'),
                DB::raw('SUM(CASE WHEN enc.is_positive = 0 THEN 1 ELSE 0 END) AS total_negative'),
                DB::raw('SUM(CASE WHEN enc.employment_id = 1 THEN 1 ELSE 0 END) AS total_job_order'),
                DB::raw('SUM(CASE WHEN enc.employment_id = 2 THEN 1 ELSE 0 END) AS total_permanent')
            )
            ->where('enc.event_id', Encounter::DRUG_EVENT_CODE)
            ->groupBy('enc.office_id')
            ->get();
        // $totalPerOffice = DB::table('encounters as enc')
        //     ->leftJoin('offices as o', 'enc.office_id', '=', 'o.id')
        //     ->select('o.name as office_name', DB::raw('COUNT(*) as total'))
        //     ->where('enc.event_id', Encounter::DRUG_EVENT_CODE)
        //     ->groupBy('enc.office_id')
        //     ->get();
        // dd($totalPerOffice);
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

    public function getTotalPerEmployment()
    {
        $totalPerEmployment = Encounter::where('event_id', Encounter::DRUG_EVENT_CODE)
            ->get()
            ->groupBy('employment_id')
            ->map(function ($encounters, $employmentId) {
                $officeName = Employment::find($employmentId)->name ?? 'Unknown Employment';
                return ['employmentName' => $officeName, 'total' => $encounters->count()]; // Updated format
            })
            ->values() // Ensure we get a sequential array
            ->sortByDesc('total') // Sort by total in descending order
            ->toArray(); // Convert to array

        return response()->json($totalPerEmployment);
    }

    public function getPositiveByEmployment()
    {
        $totalByEmployment = Encounter::where('event_id', Encounter::DRUG_EVENT_CODE)
            ->where('is_positive', 1)
            ->get()
            ->groupBy('employment_id')
            ->map(function ($encounters, $employmentId) {
                $officeName = Employment::find($employmentId)->name ?? 'Unknown Employment';
                return ['employmentName' => $officeName, 'total' => $encounters->count()]; // Updated format
            })
            ->values() // Ensure we get a sequential array
            ->sortByDesc('total') // Sort by total in descending order
            ->toArray(); // Convert to array

        return response()->json($totalByEmployment);
    }


    public function positiveList()
    {
        $totalPositive =  Encounter::where('event_id', Encounter::DRUG_EVENT_CODE)
            ->where('is_positive', 1)
            ->count();

        $positiveEncounters = Encounter::where('event_id', Encounter::DRUG_EVENT_CODE)
            ->where('is_positive', 1)
            ->with(['patient', 'office'])
            ->when(FacadesRequest::input('search'), function ($query, $search) {
                $query->whereHas('patient', function ($subQuery) use ($search) {
                    $subQuery->where('first_name', 'like', "%{$search}%");
                });
            })
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Drugs/PositiveIndex', [
            'positiveEncounters' => $positiveEncounters,
            'filters' => FacadesRequest::only(['search']),
            'totalPositive' => $totalPositive
        ]);
    }
}
