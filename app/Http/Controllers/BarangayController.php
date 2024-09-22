<?php

namespace App\Http\Controllers;

use App\Models\Barangay;
use Illuminate\Http\Request;

class BarangayController extends Controller
{
    public function getBarangays(Request $request, $municipalityId){
        // dd($municipalityId);
        $barangays = Barangay::where('city_id', $municipalityId)->get();
 
        return response()->json($barangays);
    }
}
