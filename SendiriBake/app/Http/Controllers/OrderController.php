<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Order;

class OrderController extends Controller
{
    // Method to display new orders with pending status
    public function newOrders()
    {
        $orders = Order::where('status', 'pending')->get();
        return view('admin.newOrders', compact('orders'));
    }

    // Method to update the order status
    public function updateStatus(Request $request)
    {
        $orderId = $request->input('orderId');
        $status = $request->input('status');

        $order = Order::find($orderId);
        if ($order) {
            $order->status = $status;
            $order->save();
            \Log::info('Order status updated to: ' . $order->status);
        } else {
            \Log::warning('Order not found: ' . $orderId);
        }

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }

    public function activeOrders()
    {
        $orders = Order::where('status', 'accept')->get();
        return view('admin.activeOrders', compact('orders'));
    }

    // Method to mark an order as completed
    public function completeOrder(Request $request)
    {
        $orderId = $request->input('orderId');
        $order = Order::find($orderId);

        if ($order) {
            $order->status = 'completed';
            $order->save();
            return redirect()->route('active.orders')->with('success', 'Order marked as completed.');
        } else {
            return redirect()->back()->with('error', 'Order not found.');
        }
    }

    // Method to display completed sales grouped by pickup dates
    public function reports()
    {
        $salesData = DB::table('prototype.placeorder')
            ->select(DB::raw('DATE(pickup) as pickup_date'), DB::raw('COUNT(*) as total_sales'))
            ->where('status', 'completed')
            ->groupBy('pickup_date')
            ->orderBy('pickup_date')
            ->get();

        $dates = $salesData->pluck('pickup_date')->toArray();
        $sales = $salesData->pluck('total_sales')->toArray();

        return view('admin.reports', compact('dates', 'sales'));
    }

    public function placeOrder(Request $request)
    {
        $cart = Session::get('cart', []);
        if (empty($cart)) {
            return response()->json(['success' => false, 'message' => 'Cart is empty.']);
        }

        $custName = $request->input('custName');
        $phoneNumber = $request->input('phoneNumber');
        \Log::info('Received customer name: ' . $custName);//debug
        \Log::info('Received phone number: ' . $phoneNumber);
        $totalPrice = array_sum(array_map(function($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));

        $orderDetails = json_encode($cart);

        $order = Order::create([
            'orderdetails' => $orderDetails,
            'totalprice' => $totalPrice,
            //'pickup' => $custName . ' - ' . $phoneNumber,
            'phoneNum'=>$phoneNumber,
            'custName'=>$custName,
            'status' => 'pending'
        ]);

        \Log::info('Order details:', [//debug
            'orderDetails' => $orderDetails,
            'totalPrice' => $totalPrice,
            'custName' => $custName,
            'phoneNumber' => $phoneNumber,
        ]);
        

        if ($order) {
            Session::forget('cart');
            \Log::info('Order placed successfully.');

            return response()->json(['success' => true]);
            
        } else {
            \Log::error('Failed to place order.');//debug

            return response()->json(['success' => false, 'message' => 'Failed to place order.']);
        }
    }
}
