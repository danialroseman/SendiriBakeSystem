@extends('admin.layout');

@section('content')
        <h1 style="font-size: 35px; font-weight:bold;">Manage Order Quota</h1>
        <form class="editquota" method="POST" action="{{ route('quota.update') }}">
            @csrf
            <div class="date-input">
                <label for="start">Start Date:</label>
                <input type="date" id="start" name="start">
            </div>
            <label for="quota">Order Quota</label>
            <input type="text" id="quota" name="quota">
            <button type="submit">Save</button>
        </form>
@endsection