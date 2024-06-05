<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;

class OrderController extends Controller
{
    // Method to display new orders with pending status
    public function newOrders()
    {
        // Fetch orders with status 'pending'
        $orders = Order::where('status', 'pending')->get();
        return view('admin.newOrders', compact('orders'));
    }

    // Method to update the order status
    public function updateStatus(Request $request)
    {
        // Retrieve the order ID and new status from the request
        $orderId = $request->input('orderId');
        $status = $request->input('status');

        // Find the order
        $order = Order::find($orderId);
        
        if ($order) {
            // Update the status
            $order->status = $status;
            $order->save();
            \Log::info('Order status updated to: ' . $order->status);
        } else {
            \Log::warning('Order not found: ' . $orderId);
        }

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }

    public function activeOrders(){
        $orders = Order::where('status', 'accept')->get();
        return view('admin.activeOrders', compact('orders'));

    }

    // Method to mark an order as completed
    public function completeOrder(Request $request)
    {
        $orderId = $request->input('orderId');

        // Find the order
        $order = Order::find($orderId);
        
        if ($order) {
            // Update the status to 'completed'
            $order->status = 'completed';
            $order->save();
            // Redirect back to active orders page
            return redirect()->route('active.orders')->with('success', 'Order marked as completed.');
        } else {
            return redirect()->back()->with('error', 'Order not found.');
        }
    }
    

    // Method to display completed sales grouped by pickup dates
    public function reports()
    {
        // Fetch completed orders grouped by pickup date
        $salesData = DB::table('prototype.placeorder')
            ->select(DB::raw('DATE(pickup) as pickup_date'), DB::raw('COUNT(*) as total_sales'))
            ->where('status', 'completed')
            ->groupBy('pickup_date')
            ->orderBy('pickup_date')
            ->get();

        // Extract pickup dates and sales counts
        $dates = $salesData->pluck('pickup_date')->toArray();
        $sales = $salesData->pluck('total_sales')->toArray();

        return view('admin.reports', compact('dates', 'sales'));
    }



}
