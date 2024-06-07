<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function showCheckout(Request $request)
    {
        $cart = Session::get('cart', []);
        return view('customer.checkout', compact('cart'));
    }
}
