@extends('layouts.app')

@section('title', 'Tag: ' . $decodedTag . ' - MTs Nurul Falaah Soreang')

@section('content')
    @php
        // Determine breadcrumb based on post types
        $postTypes = $posts->pluck('type')->unique();
        $breadcrumbItems = [
            ['label' => 'Beranda', 'url' => route('home')]
        ];

        if ($postTypes->count() === 1) {
            // All posts are the same type
            $type = $postTypes->first();
            if ($type === 'berita') {
                $breadcrumbItems[] = ['label' => 'Berita', 'url' => route('informasi.berita')];
            } elseif ($type === 'artikel') {
                $breadcrumbItems[] = ['label' => 'Artikel', 'url' => route('informasi.artikel')];
            }
        } else {
            // Mixed types or other cases
            $breadcrumbItems[] = ['label' => 'Informasi', 'url' => route('home')];
        }

        $breadcrumbItems[] = ['label' => 'Tag: ' . $decodedTag];
    @endphp

    <div class="container mx-auto px-3 sm:px-4 lg:px-6 xl:px-8 max-w-7xl py-8 sm:py-12">
        <x-breadcrumb :items="$breadcrumbItems" />
        <x-page-title :title="'Tag: ' . $decodedTag" />

        @php
            $monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            $fallbackImages = ['img/banner1.jpg', 'img/banner2.jpg', 'img/banner3.jpg'];

            // Helper function untuk formatting tanggal
            function formatDate($item, $monthNames) {
                $dateObj = $item->published_at ?? $item->created_at;
                $month = $monthNames[$dateObj->month - 1];
                return [
                    'date' => $dateObj->day . ' ' . $month . ', ' . $dateObj->year,
                    'time' => $dateObj->format('H:i')
                ];
            }
        @endphp

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-6">
            <div class="lg:col-span-2">
                @if($posts->count() > 0)
                    <div class="space-y-6">
                        @forelse($posts as $post)
                            @php
                                $image = $post->thumbnail_path
                                    ? asset('storage/' . $post->thumbnail_path)
                                    : asset($fallbackImages[$loop->index % count($fallbackImages)]);
                                $formattedDate = formatDate($post, $monthNames);
                            @endphp
                            <article class="bg-white border border-gray-200 overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300">
                                <div class="flex flex-col sm:flex-row">
                                    <div class="w-full sm:w-[38%] shrink-0">
                                        <div class="w-full aspect-video bg-gray-100 overflow-hidden">
                                            <img src="{{ $image }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                                        </div>
                                    </div>
                                    <div class="w-full sm:w-[62%] p-2.5 sm:p-3 flex flex-col justify-between">
                                        <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2">
                                            <a href="{{ route('informasi.show', ['type' => $post->type, 'slug' => $post->slug]) }}" class="hover:text-green-700 transition-colors">
                                                {{ $post->title }}
                                            </a>
                                        </h3>
                                        @if($post->excerpt)
                                            <p class="text-xs sm:text-sm text-gray-600 line-clamp-4 mb-2 text-justify">
                                                {{ $post->excerpt }}
                                            </p>
                                        @endif
                                        <div class="flex items-center justify-between">
                                            <p class="text-xs text-gray-500">
                                                {{ $formattedDate['date'] }} | {{ $formattedDate['time'] }}
                                            </p>
                                            <a href="{{ route('informasi.show', ['type' => $post->type, 'slug' => $post->slug]) }}" class="inline-flex items-center gap-1 text-green-700 hover:text-green-800 font-semibold text-xs transition-colors duration-300 group">
                                                Selengkapnya
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 group-hover:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <div class="mt-8">
                        {{ $posts->links('vendor.pagination.tailwind') }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">Tidak Ada Konten</h3>
                        <p class="text-sm text-gray-500">
                            Belum ada berita atau artikel dengan tag "<strong>{{ $decodedTag }}</strong>"
                        </p>
                    </div>
                @endif
            </div>

            <aside class="lg:col-span-1">
                <div class="space-y-6">
                    @if($sidebarNews->count() > 0)
                        <div class="bg-white border border-gray-200 rounded-xl p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Berita Terbaru</h3>
                            <div class="space-y-4">
                                @foreach($sidebarNews as $news)
                                    @php
                                        $formattedDate = formatDate($news, $monthNames);
                                    @endphp
                                    <a href="{{ route('informasi.show', ['type' => $news->type, 'slug' => $news->slug]) }}" class="block group">
                                        <h4 class="text-sm font-semibold text-gray-900 group-hover:text-green-700 transition-colors line-clamp-2 mb-1">
                                            {{ $news->title }}
                                        </h4>
                                        <p class="text-xs text-gray-500">{{ $formattedDate['date'] }} | {{ $formattedDate['time'] }}</p>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($sidebarArticles->count() > 0)
                        <div class="bg-white border border-gray-200 rounded-xl p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Artikel Terbaru</h3>
                            <div class="space-y-4">
                                @foreach($sidebarArticles as $article)
                                    @php
                                        $formattedDate = formatDate($article, $monthNames);
                                    @endphp
                                    <a href="{{ route('informasi.show', ['type' => $article->type, 'slug' => $article->slug]) }}" class="block group">
                                        <h4 class="text-sm font-semibold text-gray-900 group-hover:text-green-700 transition-colors line-clamp-2 mb-1">
                                            {{ $article->title }}
                                        </h4>
                                        <p class="text-xs text-gray-500">{{ $formattedDate['date'] }} | {{ $formattedDate['time'] }}</p>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($infoTerkini->count() > 0)
                        <div class="bg-white border border-gray-200 rounded-xl p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Informasi Terkini</h3>
                            <div class="space-y-4">
                                @foreach($infoTerkini as $info)
                                    @php
                                        $dateObj = $info->published_at ?? $info->created_at;
                                        $month = $monthNames[$dateObj->month - 1];
                                        $date = $dateObj->day . ' ' . $month . ', ' . $dateObj->year;
                                    @endphp
                                    <a href="{{ route('informasi.show', ['type' => $info->type, 'slug' => $info->slug]) }}" class="block group">
                                        <h4 class="text-sm font-semibold text-gray-900 group-hover:text-green-700 transition-colors line-clamp-2 mb-1">
                                            {{ $info->title }}
                                        </h4>
                                        <p class="text-xs text-gray-500">{{ $date }}</p>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </aside>
        </div>
    </div>
@endsection

