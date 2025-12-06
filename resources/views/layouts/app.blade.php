<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <title>@yield('title', 'MTs Nurul Falaah Soreang')</title>

    @php
        $siteSettings = \App\Models\SiteSetting::first();
        $faviconPath = $siteSettings && $siteSettings->logo_path ? ('storage/' . $siteSettings->logo_path) : 'img/logo.png';
        // Cache busting: untuk storage gunakan updated_at, untuk file default gunakan filemtime
        if ($siteSettings && $siteSettings->logo_path) {
            $faviconVersion = $siteSettings->updated_at ? $siteSettings->updated_at->timestamp : time();
        } else {
            $faviconVersion = file_exists(public_path($faviconPath)) ? filemtime(public_path($faviconPath)) : null;
        }
    @endphp
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset($faviconPath) }}@if($faviconVersion)?v={{ $faviconVersion }}@endif">

    <!-- Google Fonts - Dosis -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex flex-col">
        @include('components.top-bar')
        @include('components.header')

        <main class="grow">
            @yield('content')
        </main>

        @include('components.footer')
    </div>
    @include('components.chatbot-widget')
    @stack('scripts')
</body>
</html>

