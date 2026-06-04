# HospitEx Professional Reports Module - Implementation Guide

## Overview

The HospitEx Reports Module is a comprehensive, professional hospital reporting and analytics system. It provides real-time dashboards, detailed analytics, and multiple export options for hospital administrators and staff.

## System Architecture

### 1. Service Layer (`app/Services/`)

**BaseReportService.php** - Abstract base class for all report services
- Provides common functionality for all report types
- Date range filtering (quick filters and custom ranges)
- Pagination and formatting utilities
- Base methods for generating summaries, data, and charts

**PatientReportService.php** - Patient statistics and analytics
- Total patients, new patients, returning patients
- Admission and discharge tracking
- Gender and age group distribution
- ICU and emergency case monitoring
- Department-wise patient distribution
- Multiple filters: doctor, department, ward

**FinancialReportService.php** - Revenue and billing analytics
- Total revenue, expenses, net profit tracking
- Outstanding and paid bills
- Invoice and payment status breakdown
- Department revenue comparison
- Average invoice calculation
- Payment rate metrics

**DailyReportService.php** - Real-time daily operations dashboard
- Today's admissions, discharges, appointments
- Daily revenue tracking
- Hourly patient activity analysis
- Staff attendance monitoring
- Emergency case tracking
- Active patient census

**LabReportService.php** - Laboratory test analytics (Framework ready)
- Test volume tracking
- Pending and completed tests
- Critical result monitoring
- Lab revenue analysis
- Processing time metrics

**PharmacyReportService.php** - Inventory and sales analytics
- Medicine sales tracking
- Stock level management
- Expiry date monitoring
- Low stock alerts
- Inventory value calculation
- Top-selling medicines analysis

### 2. Controller (`app/Http/Controllers/ReportController.php`)

**Key Methods:**
- `index()` - Centralized report center with search and filtering
- `patientReports()` - Patient analytics dashboard
- `financialReports()` - Financial analytics dashboard
- `dailyReports()` - Daily summary dashboard
- `labReports()` - Lab analytics dashboard
- `pharmacyReports()` - Pharmacy analytics dashboard
- `exportPatientPdf()` - Export patient report as PDF
- `exportFinancialPdf()` - Export financial report as PDF
- `exportDailyPdf()` - Export daily report as PDF
- `toggleFavorite()` - Mark reports as favorites
- `destroy()` - Delete reports with authorization

### 3. Views (`resources/views/reports/`)

**Main Pages:**
- `index.blade.php` - Centralized reports center with all report types
- `patient-report.blade.php` - Comprehensive patient analytics page
- `financial-report.blade.php` - Financial analytics dashboard
- `daily-report.blade.php` - Real-time daily operations summary
- `lab-report.blade.php` - Lab test analytics (extensible)
- `pharmacy-report.blade.php` - Pharmacy management dashboard

**Export Templates (`exports/`):**
- `patient-pdf.blade.php` - Patient report PDF export
- `financial-pdf.blade.php` - Financial report PDF export
- `daily-pdf.blade.php` - Daily report PDF export

### 4. Reusable Components (`resources/views/components/report/`)

**Summary Card Component**
```blade
<x-report.summary-card 
    label="Total Patients"
    value="1,234"
    icon="👥"
    description="All registered patients"
    change="5.2"
    previous="1,174"
/>
```

**Filters Component**
```blade
<x-report.filters additionalFilters="[...]" />
```

**Export Buttons Component**
```blade
@include('components.report.export-buttons', [
    'pdfExportUrl' => route(...),
    'excelExportUrl' => route(...)
])
```

**Chart Component**
```blade
<x-report.chart 
    chartId="registration-trend"
    title="Patient Registration Trend"
    type="line"
    data="$report['charts']['registration_trend']"
/>
```

**Table Component**
```blade
<x-report.table 
    columns="[...]"
    rows="$rows"
    pagination="$paginator"
/>
```

### 5. Database

**Report Model & Migration:**
```php
Schema::create('reports', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('type');
    $table->json('parameters')->nullable();
    $table->json('data')->nullable();
    $table->unsignedBigInteger('created_by');
    $table->boolean('is_favorite')->default(false);
    $table->timestamps();
    $table->foreign('created_by')->references('id')->on('users');
});
```

## Features

### 1. Summary Cards
- Display key metrics at a glance
- Show trend indicators with percentage change
- Custom icons and descriptions
- Professional styling with shadows and borders

### 2. Date Range Filtering
- Quick filters: Today, Yesterday, Last 7 Days, Last 30 Days, This Month, Last Month, This Year
- Custom date range selection
- Department filters where applicable
- Doctor and Ward filters for patient reports

### 3. Charts & Analytics
- Line charts for trends
- Bar charts for comparisons
- Doughnut/Pie charts for distributions
- Chart.js integration for interactive visualizations
- Responsive design

### 4. Data Tables
- Pagination support with page navigation
- Sortable columns
- Status badges with color coding
- Action buttons (View, Edit, Delete)
- Empty state messages

### 5. Export Options
- **PDF Export** - Professional formatted PDFs
- **Print** - Browser print functionality
- **Excel/CSV** - Coming soon (requires Maatwebsite Excel)

### 6. Role-Based Access Control
- Permission checks for each report type
- Admin bypass for all reports
- User can only delete their own reports
- Extensible permission system

### 7. Favorite Reports
- Mark reports as favorites
- Quick access to frequently used reports
- AJAX toggle functionality

## Routes

```php
// Report Pages
Route::get('reports/patient', [ReportController::class, 'patientReports'])->name('reports.patient');
Route::get('reports/financial', [ReportController::class, 'financialReports'])->name('reports.financial');
Route::get('reports/daily', [ReportController::class, 'dailyReports'])->name('reports.daily');
Route::get('reports/lab', [ReportController::class, 'labReports'])->name('reports.lab');
Route::get('reports/pharmacy', [ReportController::class, 'pharmacyReports'])->name('reports.pharmacy');

// Export Routes
Route::get('reports/export/patient-pdf', [ReportController::class, 'exportPatientPdf'])->name('reports.export-patient-pdf');
Route::get('reports/export/financial-pdf', [ReportController::class, 'exportFinancialPdf'])->name('reports.export-financial-pdf');
Route::get('reports/export/daily-pdf', [ReportController::class, 'exportDailyPdf'])->name('reports.export-daily-pdf');

// Resource Routes
Route::resource('reports', ReportController::class);
Route::post('reports/{report}/toggle-favorite', [ReportController::class, 'toggleFavorite'])->name('reports.toggle-favorite');
```

## Permissions Required

Add these permissions to your permissions table:
- `view-patient-reports`
- `view-financial-reports`
- `view-daily-reports`
- `view-lab-reports`
- `view-pharmacy-reports`
- `export-reports`
- `delete-reports`

## Using the Reports

### Accessing Patient Reports
```
/reports/patient
Query params:
- date_range: today|yesterday|last7days|last30days|thismonth|lastmonth|thisyear
- start_date: YYYY-MM-DD
- end_date: YYYY-MM-DD
- doctor_id: ID
- department_id: ID
- ward_id: ID
```

### Accessing Financial Reports
```
/reports/financial
Query params:
- date_range: (same as above)
- start_date: YYYY-MM-DD
- end_date: YYYY-MM-DD
- department_id: ID
```

### Accessing Daily Reports
```
/reports/daily
Shows real-time metrics for current day
```

## Extending the Reports

### Adding a New Report Type

1. Create a new service class extending `BaseReportService`:
```php
class NewReportService extends BaseReportService
{
    public function generateSummary(): array { }
    public function generateData(): array { }
    public function generateCharts(): array { }
}
```

2. Add a method to the controller:
```php
public function newReports(Request $request)
{
    $service = new NewReportService();
    // ... apply filters
    $report = $service->generate();
    return view('reports.new-report', compact('report'));
}
```

3. Create the view file:
```blade
@extends('includePage')
@section('content')
    <!-- Report content -->
@endsection
```

4. Add routes:
```php
Route::get('reports/new', [ReportController::class, 'newReports'])->name('reports.new');
```

## Customization

### Styling
- All components use Tailwind CSS
- Color scheme can be customized in component files
- Responsive design adapts to all screen sizes
- Dark mode support (can be added)

### Date Ranges
Modify `BaseReportService::applyQuickFilter()` to add new date range options

### Chart Colors
Modify the color values in each service's chart generation methods

### Table Columns
Define columns in the view when calling the table component

## Performance Optimization

### Database Queries
- Use eager loading with `with()` relationships
- Index frequently filtered columns
- Use `selectRaw()` for aggregations
- Implement caching for report data

### Frontend
- Charts are generated on the fly (cached if needed)
- Pagination limits data displayed
- Lazy loading for large datasets
- CDN for Chart.js library

## Troubleshooting

### Charts Not Displaying
- Ensure Chart.js is loaded: Check if `chart.min.js` script is in layout
- Check browser console for JavaScript errors
- Verify data structure matches Chart.js format

### Reports Not Accessible
- Check user permissions in database
- Verify user has appropriate role assigned
- Check if user is admin (bypasses permission checks)

### Export Not Working
- Ensure DomPDF is installed: `composer require barryvdh/laravel-dompdf`
- Check if view files exist in `exports/` directory
- Verify file permissions for PDF generation

## Future Enhancements

- [ ] Email report scheduling
- [ ] Excel export with multiple sheets
- [ ] Advanced filtering with saved filter profiles
- [ ] Report sharing with team members
- [ ] Historical report comparison
- [ ] Automated alerts based on thresholds
- [ ] Mobile app compatibility
- [ ] Real-time data refresh
- [ ] Custom report builder
- [ ] Report templates

## API Integration

All report endpoints can be accessed via API:

```
GET /api/reports/patient?start_date=2024-01-01&end_date=2024-01-31
GET /api/reports/financial?doctor_id=1
GET /api/reports/daily
```

## Support

For issues or feature requests, refer to the main HospitEx documentation or contact the development team.
