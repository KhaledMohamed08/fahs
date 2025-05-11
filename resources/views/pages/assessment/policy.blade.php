@extends('layouts.main')
@section('title', 'Assessment Ploicy')
@section('content')
    <x-page-title />

    <x-page-section section="{{ 'Assessmemt ' . rtrim($assessment->title, '.') . ' Policy.' }}">
        <a href="{{ route('results.create', $assessment->id) }}"
            onclick="window.open(this.href, 'Start Assessment', 'width=1200,height=800'); return false;"
            class="btn btn-primary"
            id="start-assessment">
            Start Assessment
        </a>
    </x-page-section>
@endsection
@push('scripts')
    <script>
        document.getElementById("start-assessment").addEventListener("click", () => {
            window.location.href = "/index";
        });
    </script>
@endpush
