@extends('admin.layout')

@section('content')
    <h1 style="font-size: 35px; font-weight:bold;">Manage Order Quota</h1>
    <form class="editquota" method="POST" action="{{ route('quota.update') }}">
        @csrf
        <div class="date-input">
            <label for="start">Start Date:</label>
            <input type="date" id="start" name="start">
        </div>
        <div>
            <label for="quota">Order Quota:</label>
            <input type="number" id="quota" name="quota" min="1">
        </div>
        <button type="submit">Save</button>
    </form>
    <hr>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Quota</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($quotas as $quota)
                <tr>
                    <td>{{ $quota->date->format('Y-m-d') }}</td>
                    <td>{{ $quota->quota }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
