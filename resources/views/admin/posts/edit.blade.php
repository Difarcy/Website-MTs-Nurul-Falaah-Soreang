@extends('layouts.admin')

@section('title', 'Edit Berita & Artikel')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-2">
            <p class="text-sm text-slate-500 uppercase tracking-wide font-semibold">Perbarui Konten</p>
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">Edit: {{ $post->title }}</h1>
                    <p class="text-sm text-slate-500 mt-1">Terakhir diperbarui {{ $post->updated_at?->diffForHumans() }}</p>
                </div>
                <div class="flex items-center gap-2 text-xs">
                    <span class="px-2 py-1 rounded-full bg-slate-100 text-slate-700">ID: {{ $post->id }}</span>
                    <span class="px-2 py-1 rounded-full bg-slate-100 text-slate-700">{{ ucfirst($post->type) }}</span>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data" class="bg-white border border-gray-200 rounded-xl p-6 space-y-6">
            @method('PUT')
            @include('admin.posts._form', ['post' => $post])
        </form>
    </div>
@endsection

