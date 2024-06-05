<!DOCTYPE html>
<html>
<head>
    <title>{{ $pageTitle ?? 'Sendiri Bake' }}</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
</head>
<body>
    <!-- Sidebar -->
    <section> 
        <div class="sidebar">
            <h1>Sendiri Bake</h1>
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('manage.catalogue') }}">Manage Catalogue</a>
            <a href="{{ route('manage.quota') }}">Manage Order Quota</a>
            <a href="{{ route('new.orders') }}">New Orders</a>
            <a href="{{ route('active.orders') }}">Active Orders</a>
            <a href="{{ route('reports') }}">Reports</a>
        </div>
    </section>

    

    <!-- Main content -->
    <section>
        <div class="main" style="padding-top: 50px;">
            @yield('content')
        </div>
        
    </section>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</body>
</html>
