@extends('layouts.app')

@section('title', 'MTs Nurul Falaah Soreang')

@push('styles')
    @vite('resources/css/home.css')
@endpush

@push('scripts')
    @vite('resources/js/home.js')
@endpush

@section('content')
    @include('home.sections.banner')
    @include('home.sections.info-bar')
    @include('home.sections.berita-terbaru')
@endsection
