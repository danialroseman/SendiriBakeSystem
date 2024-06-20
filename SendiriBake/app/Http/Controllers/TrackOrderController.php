<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order; // Assuming you have an Order model

class TrackOrderController extends Controller
{
    public function showOrder()
    {
        $pageTitle = "Track Orders";
        return view('customer.order', compact('pageTitle'));
    }

    public function trackOrder(Request $request)
    {
        $pageTitle = "Track Orders";
        $phoneNum = $request->input('phoneNum');
        
        // Fetch orders associated with the phone number
        $orders = Order::where('phoneNum', $phoneNum)->get();
        
        return view('customer.order', compact('pageTitle', 'orders'));
    }
}
