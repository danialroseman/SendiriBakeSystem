<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quota; // Assuming Quota model exists

class QuotaController extends Controller
{
    public function manageQuota()
    {
        // Fetch quota information from the database
        $quotas = Quota::all();

        $labels = [];
        $availableQuotas = [];
        $filledQuotas = [];
        $customQuotas = [];

        foreach ($quotas as $quota) {
            $labels[] = "{$quota->WeekStart} - {$quota->WeekEnd}";
            $availableQuotas[] = $quota->quota - $quota->filled;
            $filledQuotas[] = $quota->filled;
            $customQuotas[] = $quota->custom;
        }

        return view('admin.manageQuota', compact('labels', 'availableQuotas', 'filledQuotas', 'customQuotas'));
    }

    public function editQuota()
    {
        return view('admin.editQuota');
    }

}
