@extends('layouts.app')

@section('title', 'Galeri | MTs Nurul Falaah Soreang')

@section('content')
    <div class="container mx-auto px-3 sm:px-4 lg:px-6 xl:px-8 max-w-7xl py-8">
        <x-breadcrumb :items="[
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => 'Galeri']
        ]" />
        <x-page-title title="Galeri" />
    </div>
@endsection

