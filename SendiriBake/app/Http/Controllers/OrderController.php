<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order; // Assuming Order model exists

class OrderController extends Controller
{
    
    public function newOrders()
    {
      // Fetch new orders with 'pending' status from the database
        $orders = Order::where('status', 'pending')->get();

        return view('admin.new-orders', compact('orders'));
        
    }

    public function activeOrders(Request $request)
    {
        $orderId = $request->input('orderId');

        if ($request->has('accept')) {
            $status = 'accept';
        } elseif ($request->has('reject')) {
            $status = 'reject';
        } else {
            // Handle invalid request
            return redirect()->back()->withErrors('Invalid action');
        }

        // Update order status in the database
        Order::where('Id', $orderId)->update(['status' => $status]);

        // Redirect back to the new orders page
        return redirect()->route('new.orders');
    }
    
}
