@extends('layouts.admin')

@section('title', 'Tambah Berita & Artikel')

@section('content')
    <div class="space-y-6">
        <div>
            <p class="text-sm text-slate-500 uppercase tracking-wide font-semibold">Konten Baru</p>
            <h1 class="text-2xl font-bold text-slate-900 mt-1">Tambah Berita / Artikel</h1>
            <p class="text-sm text-slate-500 mt-2">Isi formulir berikut untuk mempublikasikan informasi di website utama.</p>
        </div>

        <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data" class="bg-white border border-gray-200 rounded-xl p-6 space-y-6">
            @include('admin.posts._form', ['post' => $post])
        </form>
    </div>
@endsection

