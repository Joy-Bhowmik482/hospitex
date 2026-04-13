<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::where('group', '!=', 'hospital')
            ->orderBy('group')
            ->orderBy('key')
            ->get()
            ->groupBy('group');

        $totalSettings = Setting::count();
        $groupCount = Setting::select('group')
            ->distinct()
            ->whereNotNull('group')
            ->pluck('group')
            ->filter()
            ->count();

        $groupMeta = $this->groupMeta();
        $settingMeta = $this->settingMeta();

        return view('settings.index', compact('settings', 'totalSettings', 'groupCount', 'groupMeta', 'settingMeta'));
    }

    public function create()
    {
        $groupMeta = $this->groupMeta();
        return view('settings.create', compact('groupMeta'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'group' => 'required|string|max:100',
            'key' => 'required|string|max:191|unique:settings,key',
            'value' => 'required|string|max:2000',
        ]);

        Setting::create([
            'group' => $request->input('group'),
            'key' => $request->input('key'),
            'value' => ['value' => $request->input('value')],
        ]);

        return redirect()->route('settings.index')->with('success', 'New setting added successfully.');
    }

    public function edit(Setting $setting)
    {
        $groupMeta = $this->groupMeta();
        $settingMeta = $this->settingMeta();

        return view('settings.edit', compact('setting', 'groupMeta', 'settingMeta'));
    }

    public function update(Request $request, Setting $setting)
    {
        $request->validate([
            'value' => 'required|string|max:2000',
        ]);

        $setting->update([
            'value' => ['value' => $request->input('value')],
        ]);

        return redirect()->route('settings.index')->with('success', 'Setting updated successfully.');
    }

    public function hospitalProfile()
    {
        $settings = Setting::where('group', 'hospital')->orderBy('key')->get();
        $groupMeta = $this->groupMeta();
        $settingMeta = $this->settingMeta();

        return view('settings.hospital-profile', compact('settings', 'groupMeta', 'settingMeta'));
    }

    protected function groupMeta(): array
    {
        return [
            'app' => [
                'title' => 'Application',
                'description' => 'Core application information such as site name, contact email, and branding identity.',
            ],
            'hospital' => [
                'title' => 'Hospital Profile',
                'description' => 'Hospital-specific details including address, timezone, visiting hours, emergency contacts, mission statement, and website information.',
            ],
            'billing' => [
                'title' => 'Billing & Finance',
                'description' => 'Pricing, tax, currency, and invoice configuration for billing operations.',
            ],
            'communication' => [
                'title' => 'Communication',
                'description' => 'Email, SMS, and notification settings that keep staff and patients informed.',
            ],
            'branding' => [
                'title' => 'Branding',
                'description' => 'Visual identity settings such as logo location and theme colors.',
            ],
        ];
    }

    protected function settingMeta(): array
    {
        return [
            'site.name' => [
                'label' => 'Hospital Name',
                'description' => 'Visible site name for the dashboard and patient-facing pages.',
                'type' => 'text',
            ],
            'site.email' => [
                'label' => 'Contact Email',
                'description' => 'Primary email address used for hospital communications.',
                'type' => 'email',
            ],
            'site.phone' => [
                'label' => 'Contact Phone',
                'description' => 'Main hospital phone number shown in the header and contact pages.',
                'type' => 'tel',
            ],
            'site.address' => [
                'label' => 'Hospital Address',
                'description' => 'Physical address displayed on reports and contact sections.',
                'type' => 'textarea',
            ],
            'site.timezone' => [
                'label' => 'Timezone',
                'description' => 'System timezone used for appointment scheduling and timestamps.',
                'type' => 'text',
            ],
            'site.emergency_contact' => [
                'label' => 'Emergency Contact',
                'description' => 'Primary emergency phone number displayed for urgent hospital inquiries.',
                'type' => 'tel',
            ],
            'site.visiting_hours' => [
                'label' => 'Visiting Hours',
                'description' => 'Default visitor hours shown across the patient portal and admin notifications.',
                'type' => 'text',
            ],
            'site.mission_statement' => [
                'label' => 'Mission Statement',
                'description' => 'A short hospital mission statement displayed in the profile section.',
                'type' => 'textarea',
            ],
            'site.website_url' => [
                'label' => 'Website URL',
                'description' => 'The official hospital website address used in communication and branding materials.',
                'type' => 'url',
            ],
            'site.currency' => [
                'label' => 'Currency Code',
                'description' => 'Accounting currency used for invoices and patient payments.',
                'type' => 'text',
            ],
            'billing.tax_rate' => [
                'label' => 'Tax Rate',
                'description' => 'Percentage value applied to invoices during billing.',
                'type' => 'number',
            ],
            'billing.currency_symbol' => [
                'label' => 'Currency Symbol',
                'description' => 'Symbol shown alongside prices and invoice totals.',
                'type' => 'text',
            ],
            'communication.email_host' => [
                'label' => 'Email Host',
                'description' => 'SMTP host used to send transactional emails.',
                'type' => 'text',
            ],
            'communication.email_port' => [
                'label' => 'Email Port',
                'description' => 'SMTP port used for the outgoing mail server.',
                'type' => 'number',
            ],
            'communication.sms_gateway' => [
                'label' => 'SMS Gateway',
                'description' => 'Provider used to send SMS notifications to patients and staff.',
                'type' => 'text',
            ],
            'branding.logo_url' => [
                'label' => 'Logo URL',
                'description' => 'Full URL or path used for the hospital dashboard logo.',
                'type' => 'url',
            ],
            'branding.theme_color' => [
                'label' => 'Theme Color',
                'description' => 'Primary brand color used for the dashboard accent styling.',
                'type' => 'text',
            ],
            'branding.clinic_tagline' => [
                'label' => 'Clinic Tagline',
                'description' => 'Short marketing phrase displayed across the admin interface.',
                'type' => 'textarea',
            ],
        ];
    }
}
