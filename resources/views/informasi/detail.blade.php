@extends('layouts.app')

@section('title', $post->title . ' - MTs Nurul Falaah Soreang')

@section('content')
    <div class="container mx-auto px-3 sm:px-4 lg:px-6 xl:px-8 max-w-7xl py-8 sm:py-12">
        <!-- Breadcrumb -->
        <nav class="mb-2" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2 text-sm text-gray-600">
                <li>
                    <a href="{{ route('home') }}" class="hover:text-green-700 transition-colors">Beranda</a>
                </li>
                <li>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </li>
                <li>
                    <a href="{{ $post->type === 'berita' ? route('informasi.berita') : route('informasi.artikel') }}" class="hover:text-green-700 transition-colors">
                        {{ ucfirst($post->type) }}
                    </a>
                </li>
                <li>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </li>
                <li class="text-gray-900 font-medium line-clamp-1" title="{{ $post->title }}">
                    {{ str()->limit($post->title, 60) }}
                </li>
            </ol>
        </nav>

        @if(isset($displayTags) && !empty($displayTags))
            <div class="mb-6 flex flex-wrap items-center gap-2">
                @foreach($displayTags as $tag)
                    <a href="{{ route('informasi.tag', ['tag' => urlencode($tag)]) }}" class="inline-flex items-center px-1.5 py-0.5 text-[10px] font-bold bg-green-700 text-white hover:bg-green-800 dark:bg-green-600 dark:text-white dark:hover:bg-green-700 transition-colors cursor-pointer" style="border-radius: 0;">
                        {{ $tag }}
                    </a>
                @endforeach
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
            <!-- Main Content (2/3 width) -->
            <div class="lg:col-span-2">
        <article>
            <div class="space-y-4">
                <h1 class="text-3xl sm:text-4xl font-bold text-slate-900 leading-tight">
                    {{ $post->title }}
                </h1>

                <div class="flex flex-wrap items-center justify-between gap-3 text-xs text-gray-500 uppercase tracking-wide">
                    <div class="flex flex-wrap items-center gap-3">
                        <span>{{ ucfirst($post->type) }} | {{ ($post->published_at ?? $post->created_at)->format('d/m/Y') }} | {{ ($post->published_at ?? $post->created_at)->format('H:i') }}</span>
                        @if($post->author_name)
                            <span class="normal-case">Oleh <strong class="font-bold text-black dark:text-white">{{ $post->author_name }}</strong></span>
                        @elseif($post->author?->name)
                            <span class="normal-case">Oleh <strong class="font-bold text-black dark:text-white">{{ $post->author->name }}</strong></span>
                        @endif
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <span class="text-gray-500">{{ $post->view_count ?? 0 }}</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            <span class="text-gray-500">{{ $comments->count() }}</span>
                        </div>
                    </div>
                </div>

                @php
                    $topBarSettings = \App\Models\TopBarSetting::first();
                    $facebookUrl = !empty($topBarSettings->facebook_url) ? $topBarSettings->facebook_url : route('social-media-unavailable');
                    $instagramUrl = !empty($topBarSettings->instagram_url) ? $topBarSettings->instagram_url : route('social-media-unavailable');
                    $youtubeUrl = !empty($topBarSettings->youtube_url) ? $topBarSettings->youtube_url : route('social-media-unavailable');
                    $tiktokUrl = !empty($topBarSettings->tiktok_url) ? $topBarSettings->tiktok_url : route('social-media-unavailable');
                @endphp

                <!-- Social Media Icons (Follow) -->
                <div class="flex items-center gap-3">
                    <a href="{{ $facebookUrl }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 flex items-center justify-center bg-blue-600 text-white hover:bg-blue-700 transition-colors duration-300" style="border-radius: 4px;" aria-label="Facebook">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    <a href="{{ $instagramUrl }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 flex items-center justify-center bg-pink-600 text-white hover:bg-pink-700 transition-colors duration-300" style="border-radius: 4px;" aria-label="Instagram">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                    <a href="{{ $youtubeUrl }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 flex items-center justify-center bg-red-600 text-white hover:bg-red-700 transition-colors duration-300" style="border-radius: 4px;" aria-label="YouTube">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                    </a>
                    <a href="{{ $tiktokUrl }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 flex items-center justify-center bg-gray-900 text-white hover:bg-gray-800 transition-colors duration-300" style="border-radius: 4px;" aria-label="TikTok">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/>
                        </svg>
                    </a>
                </div>

                @if(!empty($post->images))
                    @php
                        $imageCount = count($post->images);

                        if ($imageCount === 1) {
                            // 1 gambar: full width landscape
                            $gridCols = 'grid-cols-1';
                        } else {
                            // 2-6 gambar: 2 kolom landscape (1 baris untuk 2 gambar, 2 baris untuk 4 gambar, 3 baris untuk 6 gambar)
                            $gridCols = 'grid-cols-2';
                        }
                    @endphp
                    <div class="grid {{ $gridCols }} gap-4 my-6">
                        @foreach($post->images as $index => $image)
                            @php
                                $metadata = null;
                                if ($post->image_metadata && is_array($post->image_metadata)) {
                                    $metadata = collect($post->image_metadata)->firstWhere('path', $image);
                                }
                            @endphp
                            <div class="relative">
                                <div class="overflow-hidden border border-gray-200 cursor-pointer hover:opacity-90 transition-opacity" style="border-radius: 0;" onclick="openImageModal('{{ asset('storage/' . $image) }}')">
                                    <img src="{{ asset('storage/' . $image) }}" alt="Gambar {{ $loop->iteration }}" class="w-full aspect-video object-cover">
                                </div>
                                @if($metadata && ($metadata['source_url'] || $metadata['source_name']))
                                    <div class="mt-2 text-xs text-slate-600 dark:text-slate-400">
                                        <span class="font-semibold">Sumber:</span>
                                        @if($metadata['source_url'])
                                            <a href="{{ $metadata['source_url'] }}" target="_blank" rel="noopener noreferrer" class="text-green-700 dark:text-green-400 hover:underline">
                                                {{ $metadata['source_name'] ?? 'Link' }}
                                            </a>
                                        @else
                                            <span>{{ $metadata['source_name'] }}</span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="prose max-w-none prose-slate">
                    <div class="tinymce-content">
                        {!! $post->body !!}
                    </div>
                </div>

                @if(isset($relatedPosts) && $relatedPosts->isNotEmpty() && $post->type !== 'berita')
                    <!-- Baca Juga Section (hanya untuk artikel) -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h3 class="text-base font-bold text-slate-900 mb-3">Baca Juga:</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                            @foreach($relatedPosts->take(3) as $item)
                                @php
                                    $dateObj = $item->published_at ?? $item->created_at;
                                    $monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                    $monthName = $monthNames[$dateObj->month - 1];
                                    $date = $dateObj->day . ' ' . $monthName . ', ' . $dateObj->year;
                                    $time = $dateObj->format('H:i');
                                @endphp
                                <article class="bg-white border border-gray-200 overflow-hidden hover:shadow-md transition-all duration-300">
                                    <a href="{{ route('informasi.show', ['type' => $item->type, 'slug' => $item->slug]) }}" class="block">
                                        <div class="w-full cursor-pointer hover:opacity-90 transition-opacity">
                                            @if($item->thumbnail_path)
                                                <img src="{{ asset('storage/' . $item->thumbnail_path) }}" alt="{{ $item->title }}" class="w-full h-32 object-cover">
                                            @else
                                                <div class="w-full h-32 bg-gradient-to-r from-green-700 to-emerald-500 flex items-center justify-center text-white text-lg font-bold">
                                                    {{ strtoupper(substr($item->title, 0, 1)) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="p-2.5">
                                            <h4 class="text-xs font-semibold text-gray-900 mb-1 line-clamp-2 hover:text-green-700 transition-colors">
                                                {{ $item->title }}
                                            </h4>
                                            <p class="text-[10px] text-gray-500">
                                                {{ $date }}
                                            </p>
                                        </div>
                                    </a>
                                </article>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Share Section -->
                <div class="pt-4 mt-4 border-t border-gray-200">
                    <p class="text-base font-semibold text-slate-700 mb-2">Bagikan {{ $post->type === 'berita' ? 'berita' : 'artikel' }} ini:</p>
                    <div class="flex items-center gap-3">
                        @php
                            $shareUrl = url()->current();
                            $shareTitle = $post->title;
                            $shareText = $post->title;
                        @endphp
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($shareUrl) }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 flex items-center justify-center bg-blue-600 text-white hover:bg-blue-700 transition-colors duration-300" style="border-radius: 4px;" aria-label="Bagikan di Facebook">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode($shareUrl) }}&text={{ urlencode($shareText) }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 flex items-center justify-center bg-sky-500 text-white hover:bg-sky-600 transition-colors duration-300" style="border-radius: 4px;" aria-label="Bagikan di Twitter">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($shareText . ' ' . $shareUrl) }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 flex items-center justify-center bg-green-600 text-white hover:bg-green-700 transition-colors duration-300" style="border-radius: 4px;" aria-label="Bagikan di WhatsApp">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                            </svg>
                        </a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode($shareUrl) }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 flex items-center justify-center bg-blue-700 text-white hover:bg-blue-800 transition-colors duration-300" style="border-radius: 4px;" aria-label="Bagikan di LinkedIn">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </article>

        <!-- Suggested Posts Section (hanya untuk berita) -->
        @if($post->type === 'berita' && $suggestedPosts->isNotEmpty())
            <section class="mt-10">
                <h2 class="text-base font-bold text-slate-900 mb-3">Berita yang Disarankan</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                    @foreach($suggestedPosts as $item)
                        @php
                            $dateObj = $item->published_at ?? $item->created_at;
                            $monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                            $monthName = $monthNames[$dateObj->month - 1];
                            $date = $dateObj->day . ' ' . $monthName . ', ' . $dateObj->year;
                        @endphp
                        <article class="bg-white border border-gray-200 overflow-hidden hover:shadow-md transition-all duration-300">
                            <a href="{{ route('informasi.show', ['type' => $item->type, 'slug' => $item->slug]) }}" class="block">
                                <div class="w-full cursor-pointer hover:opacity-90 transition-opacity">
                                    @if($item->thumbnail_path)
                                        <img src="{{ asset('storage/' . $item->thumbnail_path) }}" alt="{{ $item->title }}" class="w-full h-32 object-cover">
                                    @else
                                        <div class="w-full h-32 bg-gradient-to-r from-green-700 to-emerald-500 flex items-center justify-center text-white text-lg font-bold">
                                            {{ strtoupper(substr($item->title, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="p-2.5">
                                    <h3 class="text-xs font-semibold text-gray-900 mb-1 line-clamp-2 hover:text-green-700 transition-colors">
                                        {{ $item->title }}
                                    </h3>
                                    <p class="text-[10px] text-gray-500">
                                        {{ $date }}
                                    </p>
                                </div>
                            </a>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- Comments Section -->
        <section class="mt-10">
            <h2 class="text-2xl font-bold text-slate-900 mb-6">Komentar ({{ $comments->count() }})</h2>

            @if($comments->isNotEmpty())
                <div class="space-y-6 mb-8">
                    @foreach($comments as $comment)
                        <div class="pb-6 last:pb-0">
                            <div class="flex items-start justify-between mb-3">
                                <div>
                                    <h4 class="font-semibold text-slate-900">{{ $comment->name }}</h4>
                                    <p class="text-xs text-slate-500">{{ $comment->created_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                            <p class="text-slate-700 leading-relaxed">{{ $comment->comment }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-slate-500 mb-8">Belum ada komentar. Jadilah yang pertama berkomentar!</p>
            @endif

            <!-- Leave a Reply Form -->
            <div class="pt-6">
                <h3 class="text-xl font-bold text-slate-900 mb-6">Tinggalkan Komentar</h3>

                @if(session('comment_success'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-800 text-sm">
                        {{ session('comment_success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <ul class="text-red-800 text-sm space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('comments.store', ['type' => $post->type, 'slug' => $post->slug]) }}" method="POST" class="space-y-4" id="comment-form">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Nama <span class="text-red-600 dark:text-red-500">*</span></label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required autocomplete="name" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-600 focus:border-green-600" placeholder="Masukkan nama Anda">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email <span class="text-red-600 dark:text-red-500">*</span></label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-600 focus:border-green-600" placeholder="Masukkan email Anda">
                        </div>
                    </div>
                    <div>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" id="anonymous" name="anonymous" value="1" class="rounded border-gray-300 text-green-700 focus:ring-green-600" {{ old('anonymous') ? 'checked' : '' }}>
                            <span class="text-sm text-slate-700">Komentar sebagai Anonymous</span>
                        </label>
                        <p class="text-xs text-slate-500 mt-1">Centang jika Anda tidak ingin mencantumkan nama</p>
                    </div>
                    <div>
                        <label for="comment" class="block text-sm font-semibold text-slate-700 mb-2">Komentar <span class="text-red-600 dark:text-red-500">*</span></label>
                        <textarea id="comment" name="comment" rows="6" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-600 focus:border-green-600" placeholder="Tulis komentar Anda di sini...">{{ old('comment') }}</textarea>
                        <p class="text-xs text-slate-500 mt-1">Maksimal 1000 karakter</p>
                    </div>
                    <div>
                        <button type="submit" class="px-6 py-2 bg-green-700 text-white font-semibold rounded-lg hover:bg-green-800 transition-colors">
                            Kirim Komentar
                        </button>
                        <p class="text-xs text-slate-500 mt-2">* Komentar akan ditinjau oleh admin sebelum dipublikasikan</p>
                    </div>
                </form>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const anonymousCheckbox = document.getElementById('anonymous');
                        const nameInput = document.getElementById('name');
                        const commentForm = document.getElementById('comment-form');

                        function toggleNameField() {
                            if (anonymousCheckbox.checked) {
                                nameInput.value = 'Anonymous';
                                nameInput.disabled = true;
                                nameInput.classList.add('bg-gray-100', 'cursor-not-allowed');
                                nameInput.removeAttribute('required');
                            } else {
                                nameInput.disabled = false;
                                nameInput.classList.remove('bg-gray-100', 'cursor-not-allowed');
                                nameInput.setAttribute('required', 'required');
                                if (nameInput.value === 'Anonymous') {
                                    nameInput.value = '';
                                }
                            }
                        }

                        anonymousCheckbox.addEventListener('change', toggleNameField);

                        // Handle form submission - ensure name is set to Anonymous if checkbox is checked
                        commentForm.addEventListener('submit', function(e) {
                            if (anonymousCheckbox.checked) {
                                nameInput.disabled = false; // Enable temporarily for form submission
                                nameInput.value = 'Anonymous';
                            }
                        });

                        // Initialize on page load
                        toggleNameField();
                    });
                </script>
            </div>
        </section>
            </div>

            <!-- Sidebar (1/3 width) -->
            <div class="lg:col-span-1">
                <div class="space-y-6">
                    <!-- Latest Posts -->
                    <div class="bg-white border border-gray-200 overflow-hidden">
                        <div class="p-4">
                            <h3 class="text-sm sm:text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                Post Terbaru
                            </h3>
                            <div class="space-y-3 min-h-[300px]">
                                @forelse($latestPosts as $latestPost)
                                    <article class="pb-4 last:pb-0">
                                        <a href="{{ route('informasi.show', ['type' => $latestPost->type, 'slug' => $latestPost->slug]) }}" class="block hover:text-green-700 transition-colors">
                                            <h4 class="text-xs sm:text-sm font-semibold text-gray-900 mb-2 line-clamp-2 hover:text-green-700">
                                                {{ $latestPost->title }}
                                            </h4>
                                            <p class="text-xs text-gray-500">
                                                {{ ($latestPost->published_at ?? $latestPost->created_at)->format('d M Y') }} | {{ ($latestPost->published_at ?? $latestPost->created_at)->format('H:i') }}
                                            </p>
                                        </a>
                                    </article>
                                @empty
                                    <div class="flex items-center justify-center" style="min-height: 300px;">
                                        <p class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-300 text-center">
                                            Belum Ada {{ ucfirst($post->type) }}
                                        </p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/30 dark:bg-black/50 backdrop-blur-md">
        <div class="relative w-full h-full flex items-center justify-center p-4" onclick="event.stopPropagation()">
            <img id="modalImage" src="" alt="Zoom" class="max-w-full max-h-full aspect-video object-cover pointer-events-none">
            <button type="button" class="close-image-modal-btn fixed top-4 right-4 w-10 h-10 bg-red-600 rounded-full flex items-center justify-center hover:bg-red-700 transition-colors z-10 shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>

    <script>
        function openImageModal(imageSrc) {
            const modal = document.getElementById('imageModal');
            const img = document.getElementById('modalImage');
            img.src = imageSrc;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeImageModal(event) {
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }
            const modal = document.getElementById('imageModal');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = '';
            }
            return false;
        }

        // Setup event listeners untuk modal
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('imageModal');
            const closeBtn = modal?.querySelector('.close-image-modal-btn');

            if (closeBtn) {
                closeBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    closeImageModal(e);
                    return false;
                }, true);
            }

            // Background click handler
            if (modal) {
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        e.preventDefault();
                        e.stopPropagation();
                        closeImageModal(e);
                        return false;
                    }
                }, true);
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modal = document.getElementById('imageModal');
                if (modal && !modal.classList.contains('hidden')) {
                    closeImageModal(e);
                }
            }
        });
    </script>
@endsection

