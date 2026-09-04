<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'NEXORA — Admin')</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layouts/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/category/admin-table.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/category/admin-edit.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/product/admin-edit.css') }}">

    <!-- flowbite -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>

</head>
<body>
    @include('admin.partial.sidebar')

    <div class="admin-main">

        @include('admin.partial.header')

        <main class="admin-content p-4 ">
            @yield('content')
        </main>
    </div>
</body>
</html>