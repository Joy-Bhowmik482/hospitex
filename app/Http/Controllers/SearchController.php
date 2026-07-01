<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\InventoryItem;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = trim($request->query('q', ''));
        $results = [];

        if ($query !== '') {
            $results['patients'] = Patient::where('first_name', 'like', "%{$query}%")
                ->orWhere('last_name', 'like', "%{$query}%")
                ->orWhere('email', 'like', "%{$query}%")
                ->take(10)
                ->get();

            $results['appointments'] = Appointment::where('appointment_date', 'like', "%{$query}%")
                ->orWhere('appointment_time', 'like', "%{$query}%")
                ->orWhere('status', 'like', "%{$query}%")
                ->take(10)
                ->get();

            $results['inventory_items'] = InventoryItem::where('name', 'like', "%{$query}%")
                ->orWhere('category', 'like', "%{$query}%")
                ->take(10)
                ->get();
        }

        return view('search.results', [
            'query' => $query,
            'results' => $results,
        ]);
    }
}
