@extends('layouts.app')

@section('title', 'Prestasi Siswa | MTs Nurul Falaah Soreang')

@section('content')
    <div class="container mx-auto px-3 sm:px-4 lg:px-6 xl:px-8 max-w-7xl py-8">
        <x-breadcrumb :items="[
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => 'Galeri', 'url' => route('galeri')],
            ['label' => 'Prestasi Siswa']
        ]" />
        <x-page-title title="Prestasi Siswa" />
    </div>
@endsection

