<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\MedicalRecord;
use App\Models\OrderItem;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
    // ADD DIAGNOSES CHART OR TABLE
    public function index(Request $request)
    {
        $dateFilter = $request->input('dateFilter', now()->format('Y-m-d'));
        // $date = '2024-01-19';
        $totalPatients = Patient::whereDate('created_at', $dateFilter)
            ->count();

        $totalPregnant = MedicalRecord::where('is_pregnant', '1')
            ->whereDate('created_at', $dateFilter)
            ->count();

        $totals = MedicalRecord::select(
            DB::raw('SUM(CASE WHEN age <= 17 THEN 1 ELSE 0 END) as totalPedia'),
            DB::raw('SUM(CASE WHEN age >= 60 THEN 1 ELSE 0 END) as totalSenior'),
            DB::raw('SUM(CASE WHEN is_pregnant = 1 THEN 1 ELSE 0 END) as totalPregnant')
        )
            ->whereDate('created_at', $dateFilter)
            ->first();

        $genderCounts = Patient::select('sex', DB::raw('count(*) as total'))
            ->whereDate('created_at', $dateFilter)
            ->groupBy('sex')
            ->get();

        $totalDiagnoses = MedicalRecord::with('diagnosis')
            ->select('diagnosis_id', DB::raw('COUNT(*) as total'))
            ->whereDate('created_at', $dateFilter)
            ->groupBy('diagnosis_id')
            ->get();

        $formattedTotalDiagnoses = $totalDiagnoses->map(function ($record) {
            return [
                'diagnosisName' => $record->diagnosis->name ?? 'Not set',
                'total' => $record->total
            ];
        })->toArray();

        // Ayos ini
        $disposedItems = OrderItem::select('item_id', 'items.name', DB::raw('SUM(order_items.quantity) as total_quantity'))
            ->join('items', 'items.id', '=', 'order_items.item_id')
            ->whereDate('order_items.created_at', $dateFilter)
            ->groupBy('item_id', 'items.name')
            ->get();

        $stocks = Item::select('name','quantity','restock_threshold')->get();

        return Inertia::render('Dashboard', [
            'totalPatients' => $totalPatients,
            'genderCounts' => $genderCounts,
            'disposedItems' => $disposedItems,
            'totals' => $totals,
            'dateFilter' => $dateFilter,
            'totalDiagnoses' => $formattedTotalDiagnoses,
            'totalPregnant' => $totalPregnant,
            'stocks' => $stocks,
        ]);
    }
}
