<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function showCheckout(Request $request)
{
    // Retrieve cart data from query parameters
    $encodedCartData = $request->query('cart');

    // Decode and parse the JSON string
    $cart = json_decode(urldecode($encodedCartData), true);
   
    return view('customer.checkout', ['cart' => $cart]);
}

}
