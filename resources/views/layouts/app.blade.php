<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Mini Inventario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f6f7f9;
            color: #222;
            margin: 0
        }

        .nav {
            background: #111827;
            color: white;
            padding: 14px 24px
        }

        .nav a {
            color: white;
            margin-right: 18px;
            text-decoration: none
        }

        .wrap {
            max-width: 980px;
            margin: 28px auto;
            background: white;
            padding: 24px;
            border-radius: 10px;
            box-shadow: 0 2px 10px #0001
        }

        table {
            width: 100%;
            border-collapse: collapse
        }

        th,
        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left
        }

        input,
        select {
            padding: 8px;
            width: 100%;
            box-sizing: border-box
        }

        .row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px
        }

        .field {
            margin-bottom: 14px
        }

        .btn {
            display: inline-block;
            padding: 8px 12px;
            background: #2563eb;
            color: white;
            border: 0;
            border-radius: 6px;
            text-decoration: none;
            cursor: pointer
        }

        .btn-danger {
            background: #b91c1c
        }

        .muted {
            color: #6b7280
        }

        .alert {
            padding: 10px;
            margin-bottom: 14px;
            background: #dcfce7
        }

        .error {
            background: #fee2e2;
            padding: 10px;
            margin-bottom: 14px
        }
    </style>
</head>

<body>
    <div class="nav"><strong>Mini Inventario</strong> &nbsp; <a href="{{ route('products.index') }}">Productos</a><a href="{{ route('categories.index') }}">Categorías</a></div>
    <div class="wrap">@if(session('ok'))<div class="alert">{{ session('ok') }}</div>@endif @if(session('error'))<div class="error">{{ session('error') }}</div>@endif @if($errors->any())<div class="error"><strong>Revisar:</strong>
            <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>@endif @yield('content')</div>
</body>

</html>