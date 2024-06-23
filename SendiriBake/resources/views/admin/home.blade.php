@extends('admin.layout')

@section('content')
        <h1 style="font-size: 35px; font-weight:bold;">Home Page</h1>
        <div class="card-container">
        <div class="card" style="display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 20px; border: 1px solid #ccc; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <img src="{{ asset('images/sendiribakelogo.png') }}" alt="Admin Welcome Image" style="width: 200px; height:auto;">
                <h2>Welcome, Admin!</h2>
                <p>What would you like to do today?</p>
            </div>
            
        </div>
@endsection