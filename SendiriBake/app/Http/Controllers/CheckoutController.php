<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function showCheckout(Request $request)
    {
        $cart = session()->get('cart', []);
        return view('customer.checkout', compact('cart'));
    }
}