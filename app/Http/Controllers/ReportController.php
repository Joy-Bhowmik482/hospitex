<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Patient;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Appointment;
use App\Models\Admission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reports = Report::with('creator')->latest()->paginate(10);
        $reportStats = Report::selectRaw('type, count(*) as total')
            ->groupBy('type')
            ->pluck('total', 'type');

        return view('reports.index', compact('reports', 'reportStats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('reports.create');
    }

    /**
     * Show the form for creating a patient report.
     */
    public function createPatient()
    {
        return view('reports.create-patient');
    }

    /**
     * Show the form for creating a financial report.
     */
    public function createFinancial()
    {
        return view('reports.create-financial');
    }

    /**
     * Show the form for creating a daily report.
     */
    public function createDaily()
    {
        return view('reports.create-daily');
    }

    /**
     * Show the form for creating a lab report.
     */
    public function createLab()
    {
        return view('reports.create-lab');
    }

    /**
     * Show the form for creating a pharmacy report.
     */
    public function createPharmacy()
    {
        return view('reports.create-pharmacy');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        $data = $this->generateReportData($request->type, $request->start_date, $request->end_date);

        Report::create([
            'name' => $request->name,
            'type' => $request->type,
            'parameters' => [
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ],
            'data' => $data,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('reports.index')->with('success', 'Report generated successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        return view('reports.show', compact('report'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        $report->delete();
        return redirect()->route('reports.index')->with('success', 'Report deleted successfully.');
    }

    private function generateReportData($type, $startDate, $endDate)
    {
        $query = null;

        switch ($type) {
            case 'patient':
                $query = Patient::query();
                if ($startDate) $query->where('created_at', '>=', $startDate);
                if ($endDate) $query->where('created_at', '<=', $endDate);
                return $query->get()->toArray();
            case 'financial':
                $invoices = Invoice::with('patient')->whereBetween('created_at', [$startDate ?? '1900-01-01', $endDate ?? now()])->get();
                $payments = Payment::with('invoice.patient')->whereBetween('created_at', [$startDate ?? '1900-01-01', $endDate ?? now()])->get();
                return [
                    'invoices' => $invoices->toArray(),
                    'payments' => $payments->toArray(),
                    'total_invoiced' => $invoices->sum('total_amount'),
                    'total_paid' => $payments->sum('amount'),
                ];
            case 'daily':
                $date = $startDate ?? now()->toDateString();
                $appointments = Appointment::whereDate('appointment_date', $date)->count();
                $admissions = Admission::whereDate('admission_date', $date)->count();
                $discharges = Admission::whereDate('discharge_date', $date)->count();
                return [
                    'date' => $date,
                    'appointments' => $appointments,
                    'admissions' => $admissions,
                    'discharges' => $discharges,
                ];
            case 'lab':
                // Assuming no lab model, return empty or placeholder
                return ['message' => 'Lab reports not implemented yet.'];
            case 'pharmacy':
                // Assuming no pharmacy, return empty
                return ['message' => 'Pharmacy reports not implemented yet.'];
            default:
                return [];
        }
    }

    public function export(Report $report)
    {
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.pdf', compact('report'));
        return $pdf->download($report->name . '.pdf');
    }
}
