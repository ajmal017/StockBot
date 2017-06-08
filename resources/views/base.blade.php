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
            <a class="navbar-brand" href="{{ route('home') }}">StockBot</a>
        </div>
        <div class="navbar-left">
            <div class="last-updated">Last updated: <strong>{{ $data['lastUpdated'] }}</strong></div>
        </div>
        @if ($page == 'home')
        <form action="{{ route('post-stock') }}" method="POST" class="navbar-form navbar-right">
            {{ csrf_field() }}
            <div class="input-group">
                <input type="text" name="stockCode" class="form-control" placeholder="Stock Code">
                <span class="input-group-btn"><button class="btn btn-primary" type="submit">Add Stock</button></span>
            </div>
        </form>
        <form class="navbar-form navbar-right">
            <div class="form-group">
                <input type="text" id="search-stock" class="form-control" placeholder="Search Stock">
            </div>
        </form>
        @endif
    </div>
</nav>
<div class="container">
    @yield('content')
</div>

<script src="{{ asset('plugins/jquery/jquery.slim.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.js') }}"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="{{ asset('js/googleChart.js') }}"></script>

@yield('scripts')
</body>
</html>