<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function showCheckout(Request $request)
    {
        $cart = session('cart', []);
        return view('customer.checkout', ['cart' => $cart]);
    }
}
