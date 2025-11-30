<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    
    @php
        $siteSettings = \App\Models\SiteSetting::first();
        $adminFaviconPath = $siteSettings && $siteSettings->logo_path ? ('storage/' . $siteSettings->logo_path) : null;
    @endphp
    @if($adminFaviconPath)
        <link rel="icon" type="image/png" href="{{ asset($adminFaviconPath) }}">
    @else
        <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23ffffff' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z'/%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M15 12a3 3 0 11-6 0 3 3 0 016 0z'/%3E%3C/svg%3E">
        <link rel="icon" type="image/svg+xml" media="(prefers-color-scheme: light)" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23000000' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z'/%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M15 12a3 3 0 11-6 0 3 3 0 016 0z'/%3E%3C/svg%3E">
    @endif
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Narrow:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css'])
    
    <style>
        body {
            font-family: 'Archivo Narrow', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            font-size: 16px;
            font-weight: 600;
        }
    </style>
</head>
<body class="min-h-screen bg-slate-100 flex items-center justify-center px-4">
    <div class="w-full max-w-md bg-white border border-gray-200 rounded-2xl shadow-sm p-8 space-y-6">
        <div class="text-center space-y-3">
            <div class="flex items-center justify-center">
                <div class="flex items-center justify-center w-24 h-24 bg-slate-900 rounded-xl">
                    <svg class="w-14 h-14 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
            </div>
            <div>
                <h1 class="text-4xl font-bold text-slate-900 tracking-tight">Admin Panel</h1>
                <p class="text-base text-slate-500 mt-1 font-medium">Masuk untuk mengelola konten website</p>
            </div>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 text-sm px-3 py-2 rounded">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.login.attempt') }}" method="POST" class="space-y-4">
            @csrf
            <div class="space-y-1">
                <label for="admin-login" class="text-base font-semibold text-slate-700">Nama Pengguna</label>
                <input
                    id="admin-login"
                    type="text"
                    name="login"
                    value="{{ old('login') }}"
                    required
                    autofocus
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-700 focus:border-green-700"
                    placeholder="Masukkan Nama Pengguna"
                >
            </div>

            <div class="space-y-1">
                <label for="admin-password" class="text-base font-semibold text-slate-700">Password</label>
                <input
                    id="admin-password"
                    type="password"
                    name="password"
                    required
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-700 focus:border-green-700"
                    placeholder="Masukkan Password"
                >
            </div>

            <button type="submit" class="w-full bg-slate-900 text-white font-semibold py-2 text-base rounded-lg hover:bg-slate-800 transition-colors border-2 border-white">
                Masuk
            </button>
        </form>
    </div>
</body>
</html>

