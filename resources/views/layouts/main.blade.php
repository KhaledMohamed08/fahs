@extends('layouts.empty')
@section('body')
    @include('includes.header')

    <main class="main">
        @yield('content')
    </main>

    @include('includes.footer')
@endsection
