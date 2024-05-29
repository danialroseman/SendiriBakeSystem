<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $cart = Session::get('cart', []);
        $name = $request->input('name');
        $price = $request->input('price');

        if (isset($cart[$name])) {
            $cart[$name]['quantity'] += 1;
        } else {
            $cart[$name] = ['price' => $price, 'quantity' => 1];
        }

        Session::put('cart', $cart);

        return response()->json(['success' => true, 'cart' => $cart]);
    }

    public function getCart()
    {
        $cart = Session::get('cart', []);
        return response()->json(['cart' => $cart]);
    }
}
