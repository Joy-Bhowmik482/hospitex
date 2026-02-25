<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;   

class DashboardController extends Controller
{
    public function index()
    {
        $totalPatients = Patient::count();  

        return view('dashboard', [
       'totalPatients' => $totalPatients
     ]); 
    }
}