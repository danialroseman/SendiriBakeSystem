<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $cart = session()->get('cart', []);
        $name = $request->input('name');
        $price = $request->input('price');

        if (isset($cart[$name])) {
            $cart[$name]['quantity'] += 1;
        } else {
            $cart[$name] = [
                'price' => $price,
                'quantity' => 1
            ];
        }

        session()->put('cart', $cart);

        return response()->json(['success' => true, 'cart' => $cart]);
    }

    public function removeFromCart(Request $request)
    {
        $cart = session()->get('cart', []);
        $name = $request->input('name');

        if (isset($cart[$name])) {
            unset($cart[$name]);
        }

        session()->put('cart', $cart);

        return response()->json(['success' => true, 'cart' => $cart]);
    }

    public function getCart()
    {
        $cart = session()->get('cart', []);
        return response()->json(['cart' => $cart]);
    }

    public function saveCart(Request $request)
    {
        $cart = $request->input('cart');
        session()->put('cart', $cart);

        return response()->json(['success' => true]);
    }
}
