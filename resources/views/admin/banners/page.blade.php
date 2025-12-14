@extends('layouts.admin')

@section('title', 'Banner')

@section('content')
    @include('admin.banners.index', ['banners' => $banners, 'settings' => $settings])
@endsection
