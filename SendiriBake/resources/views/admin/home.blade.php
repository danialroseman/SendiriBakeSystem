@extends('admin.layout')

@section('content')
        <h1 style="font-size: 35px; font-weight:bold;">Home Page</h1>
        <div class="card-container">
            <div class="card">
                <h2>Active Orders</h2>
                <p>Details about active orders...</p>
            </div>
            <div class="card">
                <h2>Completed Sales</h2>
                <p>Details about completed sales...</p>
            </div>
            <div class="card" style="height: 300px;">
                <h2>To-Do List</h2>
                <p>Tasks to be done...</p>
            </div>
        </div>
@endsection