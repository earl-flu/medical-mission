<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Request as FacadesRequest;

class GuestPageController extends Controller
{
    public function viewItems()
    {
        $items = Item::query()
            ->when(FacadesRequest::input('search'), function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->orderBy('name', 'asc')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('ViewItems', [
            'items' => $items,
            'filters' => FacadesRequest::only(['search'])
        ]);
    }
}
