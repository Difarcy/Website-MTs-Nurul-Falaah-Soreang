@extends('layouts.app')

@section('title', $post->title . ' - MTs Nurul Falaah Soreang')

@section('content')
    <div class="container mx-auto px-6 sm:px-8 lg:px-12 xl:px-16 max-w-5xl py-8 sm:py-12">
        <div class="mb-6">
            <a href="{{ $post->type === 'berita' ? route('informasi.berita') : route('informasi.artikel') }}" class="inline-flex items-center text-sm text-green-700 hover:text-green-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke daftar {{ $post->type }}
            </a>
        </div>

        <article class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm">
            @if($post->thumbnail_path)
                <img src="{{ asset('storage/' . $post->thumbnail_path) }}" alt="{{ $post->title }}" class="w-full h-72 object-cover">
            @else
                <div class="w-full h-72 bg-gradient-to-r from-green-700 to-emerald-500 flex items-center justify-center text-white text-2xl font-bold">
                    {{ strtoupper(substr($post->title, 0, 1)) }}
                </div>
            @endif
            <div class="p-6 sm:p-10 space-y-4">
                <div class="flex flex-wrap items-center gap-3 text-xs text-gray-500 uppercase tracking-wide">
                    <span class="px-3 py-1 bg-green-50 text-green-800 rounded-full font-semibold">
                        {{ $post->type === 'berita' ? 'Berita Madrasah' : 'Artikel' }}
                    </span>
                    <span>{{ ($post->published_at ?? $post->created_at)->format('d M Y • H:i') }}</span>
                    @if($post->author?->name)
                        <span>Oleh {{ $post->author->name }}</span>
                    @endif
                </div>

                <h1 class="text-3xl sm:text-4xl font-bold text-slate-900 leading-tight">
                    {{ $post->title }}
                </h1>

                @if($post->excerpt)
                    <p class="text-lg text-slate-600 border-l-4 border-green-700 pl-4">
                        {{ $post->excerpt }}
                    </p>
                @endif

                <div class="prose max-w-none prose-slate">
                    {!! nl2br(e($post->body)) !!}
                </div>
            </div>
        </article>

        @if($related->isNotEmpty())
            <section class="mt-10">
                <h2 class="text-xl font-bold text-slate-900 mb-4">Baca Juga</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($related as $item)
                        <a href="{{ route('informasi.show', ['type' => $item->type, 'slug' => $item->slug]) }}" class="block bg-white border border-gray-200 rounded-xl p-4 hover:border-green-700 hover:shadow-md transition">
                            <p class="text-xs uppercase text-green-700 font-semibold mb-2">{{ ucfirst($item->type) }}</p>
                            <h3 class="text-sm font-semibold text-slate-900 line-clamp-2">{{ $item->title }}</h3>
                            <p class="text-xs text-slate-500 mt-2">
                            {{ ($item->published_at ?? $item->created_at)->format('d M Y') }}
                            </p>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
@endsection

