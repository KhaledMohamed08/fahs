@extends('layouts.main')
@section('title', 'Assessmrnt')
@section('content')
    <x-page-title />

    <x-page-section section="{{ $assessment->title }}"
        description="here is the details of this assessment.">
        {{-- details card here. --}}
    </x-page-section>
@endsection