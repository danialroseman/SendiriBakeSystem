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
            $labels[] = $quota->date;
            $availableQuotas[] = $quota->quota - $quota->filled;
            $filledQuotas[] = $quota->filled;
            $customQuotas[] = $quota->custom;
        }

        return view('admin.manageQuota', compact('labels', 'availableQuotas', 'filledQuotas', 'customQuotas'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'start' => 'required|date',
            'quota' => 'required|integer|min:1'
        ]);

        $date = $request->input('start');
        $quota = $request->input('quota');

        // Find or create a quota record for the specified date
        $quotaRecord = Quota::updateOrCreate(
            ['date' => $date],
            ['quota' => $quota]
        );

        return redirect()->back()->with('status', 'Order quota updated successfully!');
    }

    public function editQuota()
    {
        return view('admin.editQuota');
    }

}
