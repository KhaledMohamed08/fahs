@extends('layouts.main')
@section('title', 'Profile')
@section('content')
    <x-page-title />

    <h1 class="text-center mt-5">Profile Page</h1>

    <x-page-section class="stats section p-0">
        <div class="row gy-4">

            <div class="col-lg-4 col-md-6">
                <div class="stats-item text-center w-100 h-100">
                    <span data-purecounter-start="0" data-purecounter-end="{{ $results->count() }}" data-purecounter-duration="1"
                        class="purecounter"></span>
                    <p>Results</p>
                </div>
            </div>
            {{-- End Stats Item --}}

            <div class="col-lg-4 col-md-6">
                <div class="stats-item text-center w-100 h-100">
                    <span data-purecounter-start="0" data-purecounter-end="521" data-purecounter-duration="1"
                        class="purecounter"></span>
                    <p>Attends</p>
                </div>
            </div>
            {{-- End Stats Item --}}

            <div class="col-lg-4 col-md-6">
                <div class="stats-item text-center w-100 h-100">
                    <span data-purecounter-start="0" data-purecounter-end="1453" data-purecounter-duration="1"
                        class="purecounter"></span>
                    <p>participant</p>
                </div>
            </div>
            {{-- End Stats Item --}}

        </div>
    </x-page-section>

    <x-page-section section="Results" containerClass="container-fluid">
        <div class="card">
            <div class="card-header">Results</div>
            <div class="card-body">
                <div class="table-responsive">
                    {{ $dataTable->table() }}
                </div>
            </div>
        </div>
    </x-page-section>
@endsection
@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
