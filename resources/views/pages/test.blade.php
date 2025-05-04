@extends('layouts.main')
@section('title', 'test')

@section('content')
    <x-page-title title="Test" />

    <x-page-section section="Test" description="test page description">
        <h1>Hello From Test Page</h1>
    </x-page-section>
@endsection
