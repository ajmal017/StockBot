<!DOCTYPE html>
<html>
<head>
    <title>StockBot</title>
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap/css/bootstrap-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    @yield('styles')
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand">StockBot</a>
        </div>
        <form action="" method="POST" class="navbar-form navbar-right">
            <div class="input-group">
                <input type="text" name="stockCode" class="form-control" placeholder="Stock Code">
                <span class="input-group-btn"><button class="btn btn-primary" type="button">Add Stock</button></span>
            </div>
        </form>
        <form class="navbar-form navbar-right">
            <div class="form-group">
                <input type="text" id="search-stock" class="form-control" placeholder="Search Stock">
            </div>
        </form>
    </div>
</nav>
<div class="container">
    @yield('content')
</div>

<script src="{{ asset('plugins/jquery/jquery.slim.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.js') }}"></script>
<script src="{{ asset('js/loader.js') }}"></script>
<script src="{{ asset('js/googleChart.js') }}"></script>

@yield('scripts')
</body>
</html>