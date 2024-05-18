@extends('admin.layout');

@section('content')
        <h1 style="font-size: 35px; font-weight:bold;">Manage Order Quota</h1>
        <form class="editquota" method="POST" action="{{ route('quota.update') }}">
            @csrf
            <div class="date-input">
                <label for="start">Start Date:</label>
                <input type="date" id="start" name="start">
                <label for="end">End Date:</label>
                <input type="date" id="end" name="end">
            </div>
            <label for="quota">Order Quota</label>
            <input type="text" id="quota" name="quota">
            <label for="basic">Basic Orders</label>
            <input type="text" id="basic" name="basic">
            <label for="custom">Custom Orders</label>
            <input type="text" id="custom" name="custom">
            <button type="submit">Save</button>
        </form>
@endsection