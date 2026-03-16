<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Ward;
use App\Models\Room;
use App\Models\Bed;
use App\Models\Admission;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Service;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPatients = Patient::count();
        $totalWards = Ward::count();
        $totalRooms = Room::count();
        $totalBeds = Bed::count();
        $availableBeds = Bed::where('status', 'Available')->count();
        $occupiedBeds = Bed::where('status', 'Occupied')->count();
        $activeAdmissions = Admission::where('status', 'Admitted')->count();
        
        // Billing Statistics
        $totalInvoices = Invoice::count();
        $unpaidInvoices = Invoice::where('status', 'Unpaid')->count();
        $paidInvoices = Invoice::where('status', 'Paid')->count();
        $totalServices = Service::where('is_active', true)->count();
        $totalPayments = Payment::count();
        $totalPaidAmount = Payment::sum('amount');

        return view('dashboard', [
            'totalPatients' => $totalPatients,
            'totalWards' => $totalWards,
            'totalRooms' => $totalRooms,
            'totalBeds' => $totalBeds,
            'availableBeds' => $availableBeds,
            'occupiedBeds' => $occupiedBeds,
            'activeAdmissions' => $activeAdmissions,
            'totalInvoices' => $totalInvoices,
            'unpaidInvoices' => $unpaidInvoices,
            'paidInvoices' => $paidInvoices,
            'totalServices' => $totalServices,
            'totalPayments' => $totalPayments,
            'totalPaidAmount' => $totalPaidAmount,
        ]); 
    }
}