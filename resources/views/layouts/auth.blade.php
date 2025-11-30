<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'MTs Nurul Falaah Soreang')</title>

    @php
        $siteSettings = \App\Models\SiteSetting::first();
        $logoPath = $siteSettings && $siteSettings->logo_path ? ('storage/' . $siteSettings->logo_path) : 'img/logo.png';
        // Cache busting: untuk storage gunakan updated_at, untuk file default gunakan filemtime
        if ($siteSettings && $siteSettings->logo_path) {
            $logoVersion = $siteSettings->updated_at ? $siteSettings->updated_at->timestamp : time();
        } else {
            $logoVersion = file_exists(public_path($logoPath)) ? filemtime(public_path($logoPath)) : null;
        }
    @endphp
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset($logoPath) }}@if($logoVersion)?v={{ $logoVersion }}@endif">

    <!-- Google Fonts - Dosis & Lato -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex relative">
        @yield('content')
    </div>
    @stack('scripts')
</body>
</html>

