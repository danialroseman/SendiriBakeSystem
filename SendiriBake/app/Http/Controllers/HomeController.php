<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $pageTitle = "Home Page";
        return view('admin.home', compact('pageTitle'));
    }
}
