<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Department;
use App\Models\Ward;
use App\Models\Invoice;
use App\Models\Appointment;
use App\Models\Admission;
use App\Services\PatientReportService;
use App\Services\FinancialReportService;
use App\Services\DailyReportService;
use App\Services\LabReportService;
use App\Services\PharmacyReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Display centralized report center
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $reports = Report::with('creator');

        if ($search) {
            $reports->where('name', 'like', "%{$search}%")
                ->orWhere('type', 'like', "%{$search}%");
        }

        $reports = $reports->latest()->paginate(15);
        
        $reportStats = Report::selectRaw('type, count(*) as total')
            ->groupBy('type')
            ->pluck('total', 'type');

        $recentReports = Report::latest()->limit(5)->get();
        $favoriteReports = Report::where('is_favorite', true)->limit(5)->get();

        return view('reports.index', compact('reports', 'reportStats', 'recentReports', 'favoriteReports', 'search'));
    }

    /**
     * Patient Reports Page
     */
    public function patientReports(Request $request)
    {
        $user = auth()->user();
        // Allow access if user has permission or is admin, otherwise allow authenticated users for now
        if ($user && !($user->hasPermission('view-patient-reports') || $user->hasRole('admin') || $user->roles->isEmpty())) {
            abort(403, 'Unauthorized');
        }

        $service = new PatientReportService();

        // Apply filters
        if ($request->filled('date_range')) {
            $service->applyQuickFilter($request->get('date_range'));
        } elseif ($request->filled('start_date') && $request->filled('end_date')) {
            $service->setDateRange($request->get('start_date'), $request->get('end_date'));
        }

        if ($request->filled('doctor_id')) {
            $service->filterByDoctor($request->get('doctor_id'));
        }
        if ($request->filled('department_id')) {
            $service->filterByDepartment($request->get('department_id'));
        }
        if ($request->filled('ward_id')) {
            $service->filterByWard($request->get('ward_id'));
        }

        $report = $service->generate();

        $doctors = Doctor::select('id', 'name')->get();
        $departments = Department::select('id', 'name')->get();
        $wards = Ward::select('id', 'name')->get();

        return view('reports.patient-report', compact('report', 'doctors', 'departments', 'wards'));
    }

    /**
     * Financial Reports Page
     */
    public function financialReports(Request $request)
    {
        $user = auth()->user();
        // Allow access if user has permission or is admin, otherwise allow authenticated users for now
        if ($user && !($user->hasPermission('view-financial-reports') || $user->hasRole('admin') || $user->roles->isEmpty())) {
            abort(403, 'Unauthorized');
        }

        $service = new FinancialReportService();

        // Apply filters
        if ($request->filled('date_range')) {
            $service->applyQuickFilter($request->get('date_range'));
        } elseif ($request->filled('start_date') && $request->filled('end_date')) {
            $service->setDateRange($request->get('start_date'), $request->get('end_date'));
        }

        if ($request->filled('department_id')) {
            $service->filterByDepartment($request->get('department_id'));
        }

        $report = $service->generate();

        $departments = Department::select('id', 'name')->get();

        return view('reports.financial-report', compact('report', 'departments'));
    }

    /**
     * Daily Reports Dashboard
     */
    public function dailyReports(Request $request)
    {
        $user = auth()->user();
        // Allow access if user has permission or is admin, otherwise allow authenticated users for now
        if ($user && !($user->hasPermission('view-daily-reports') || $user->hasRole('admin') || $user->roles->isEmpty())) {
            abort(403, 'Unauthorized');
        }

        $service = new DailyReportService();
        $report = $service->generate();

        return view('reports.daily-report', compact('report'));
    }

    /**
     * Lab Reports Page
     */
    public function labReports(Request $request)
    {
        $user = auth()->user();
        // Allow access if user has permission or is admin, otherwise allow authenticated users for now
        if ($user && !($user->hasPermission('view-lab-reports') || $user->hasRole('admin') || $user->roles->isEmpty())) {
            abort(403, 'Unauthorized');
        }

        $service = new LabReportService();

        if ($request->filled('date_range')) {
            $service->applyQuickFilter($request->get('date_range'));
        } elseif ($request->filled('start_date') && $request->filled('end_date')) {
            $service->setDateRange($request->get('start_date'), $request->get('end_date'));
        }

        $report = $service->generate();

        return view('reports.lab-report', compact('report'));
    }

    /**
     * Pharmacy Reports Page
     */
    public function pharmacyReports(Request $request)
    {
        $user = auth()->user();
        // Allow access if user has permission or is admin, otherwise allow authenticated users for now
        if ($user && !($user->hasPermission('view-pharmacy-reports') || $user->hasRole('admin') || $user->roles->isEmpty())) {
            abort(403, 'Unauthorized');
        }

        $service = new PharmacyReportService();

        if ($request->filled('date_range')) {
            $service->applyQuickFilter($request->get('date_range'));
        } elseif ($request->filled('start_date') && $request->filled('end_date')) {
            $service->setDateRange($request->get('start_date'), $request->get('end_date'));
        }

        $report = $service->generate();

        return view('reports.pharmacy-report', compact('report'));
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
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        $this->authorize('delete-reports');
        
        $report->delete();
        return redirect()->route('reports.index')->with('success', 'Report deleted successfully.');
    }

    /**
     * Toggle favorite status
     */
    public function toggleFavorite(Report $report)
    {
        $report->update(['is_favorite' => !$report->is_favorite]);
        return response()->json(['status' => 'success', 'is_favorite' => $report->is_favorite]);
    }

    /**
     * Export patient report to PDF
     */
    public function exportPatientPdf(Request $request)
    {
        $service = new PatientReportService();

        if ($request->filled('date_range')) {
            $service->applyQuickFilter($request->get('date_range'));
        } elseif ($request->filled('start_date') && $request->filled('end_date')) {
            $service->setDateRange($request->get('start_date'), $request->get('end_date'));
        }

        $report = $service->generate();
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.exports.patient-pdf', compact('report'))
            ->setPaper('a4');
        
        return $pdf->download('patient-report-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Export financial report to PDF
     */
    public function exportFinancialPdf(Request $request)
    {
        $service = new FinancialReportService();

        if ($request->filled('date_range')) {
            $service->applyQuickFilter($request->get('date_range'));
        } elseif ($request->filled('start_date') && $request->filled('end_date')) {
            $service->setDateRange($request->get('start_date'), $request->get('end_date'));
        }

        $report = $service->generate();
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.exports.financial-pdf', compact('report'))
            ->setPaper('a4');
        
        return $pdf->download('financial-report-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Export daily report to PDF
     */
    public function exportDailyPdf()
    {
        $service = new DailyReportService();
        $report = $service->generate();
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.exports.daily-pdf', compact('report'))
            ->setPaper('a4');
        
        return $pdf->download('daily-report-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Export to Excel
     */
    public function exportExcel(Request $request)
    {
        // Excel export requires Maatwebsite\Excel package
        // To enable: composer require maatwebsite/excel
        // For now, return PDF or CSV as alternative
        
        $type = $request->get('type', 'patient');
        return redirect()->back()->with('info', 'Excel export requires additional configuration. Please use PDF export instead.');
    }

    /**
     * Print report
     */
    public function print(Request $request)
    {
        $type = $request->get('type', 'patient');
        
        return view("reports.print.{$type}-report", ['type' => $type]);
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
                return [
                    'invoices' => $invoices->toArray(),
                    'payments' => [],
                    'total_invoiced' => $invoices->sum('total_amount'),
                    'total_paid' => 0,
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
                return ['message' => 'Lab reports not implemented yet.'];
            case 'pharmacy':
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
