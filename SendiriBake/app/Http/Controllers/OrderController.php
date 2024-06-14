<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Order;

class OrderController extends Controller
{
    public function newOrders()
    {
        $orders = Order::where('status', 'pending')->get();
        return view('admin.newOrders', compact('orders'));
    }

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
        $validatedData = $request->validate([
            'custName' => 'required|string|max:255',
            'phoneNumber' => 'required|string|max:20',
            'pickupDate' => 'required|date',
            'paymentMethod' => 'required|string|in:COD,QrTransfer', 
            'receipt-file' => 'nullable|file|mimes:pdf|max:2048' 
        ]);

        $cart = Session::get('cart', []);
        if (empty($cart)) {
            return response()->json(['success' => false, 'message' => 'Cart is empty.']);
        }

        $custName = $request->input('custName');
        $phoneNumber = $request->input('phoneNumber');
        $pickupDate = $validatedData['pickupDate']; 
        $paymentMethod = $request->input('paymentMethod');

        $paymentMethod = $request->input('paymentMethod');

        $receiptFilePath = null;
        if ($paymentMethod === 'QrTransfer' && $request->hasFile('receipt-file')) {
            $receiptFile = $request->file('receipt-file');
            \Log::info('Receipt file detected: ' . $receiptFile->getClientOriginalName());
            $receiptFilePath = $receiptFile->store('public/receipts');
            \Log::info('Receipt file path: ' . $receiptFilePath);
        } else {
            \Log::error('Receipt file not uploaded or payment method is not QrTransfer.');
        }


        $totalPrice = array_sum(array_map(function($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));

        $orderDetails = json_encode($cart);

        $order = Order::create([
            'orderdetails' => $orderDetails,
            'totalprice' => $totalPrice,
            'phoneNum' => $phoneNumber,
            'custName' => $custName,
            'pickup' => $pickupDate,
            'status' => 'pending',
            'payment_method' => $paymentMethod,
            'receipt' => $receiptFilePath
        ]);

        \Log::info('Order details:', [//debug
            'orderDetails' => $orderDetails,
            'totalPrice' => $totalPrice,
            'custName' => $custName,
            'phoneNumber' => $phoneNumber,
            'pickupDate'=> $pickupDate,
            'paymentMethod' => $paymentMethod,
            'receiptFilePath' => $receiptFilePath
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
