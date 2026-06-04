<?php

namespace App\Policies;

use App\Models\Report;
use App\Models\User;

class ReportPolicy
{
    /**
     * Determine if the user can view patient reports
     */
    public function viewPatientReports(User $user): bool
    {
        return $user->hasPermission('view-patient-reports') || $user->isAdmin();
    }

    /**
     * Determine if the user can view financial reports
     */
    public function viewFinancialReports(User $user): bool
    {
        return $user->hasPermission('view-financial-reports') || $user->isAdmin();
    }

    /**
     * Determine if the user can view daily reports
     */
    public function viewDailyReports(User $user): bool
    {
        return $user->hasPermission('view-daily-reports') || $user->isAdmin();
    }

    /**
     * Determine if the user can view lab reports
     */
    public function viewLabReports(User $user): bool
    {
        return $user->hasPermission('view-lab-reports') || $user->isAdmin();
    }

    /**
     * Determine if the user can view pharmacy reports
     */
    public function viewPharmacyReports(User $user): bool
    {
        return $user->hasPermission('view-pharmacy-reports') || $user->isAdmin();
    }

    /**
     * Determine if the user can delete reports
     */
    public function deleteReports(User $user): bool
    {
        return $user->hasPermission('delete-reports') || $user->isAdmin();
    }

    /**
     * Determine if the user can export reports
     */
    public function exportReports(User $user): bool
    {
        return $user->hasPermission('export-reports') || $user->isAdmin();
    }

    /**
     * Determine if the user can view any report
     */
    public function view(User $user, Report $report): bool
    {
        return $user->isAdmin() || $user->id === $report->created_by;
    }

    /**
     * Determine if the user can delete a specific report
     */
    public function delete(User $user, Report $report): bool
    {
        return $user->isAdmin() || $user->id === $report->created_by;
    }
}
