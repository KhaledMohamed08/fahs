@extends('layouts.main')
@section('title', 'Profile')
@section('content')
    <x-page-title />
    <x-page-section section="Profile">
        <h1>Profile Page</h1>
        <span>{{ 'Welcome, ' . auth()->user()->name }}</span>
    </x-page-section>
@endsection