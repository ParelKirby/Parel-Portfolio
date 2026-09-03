@extends('layouts.app')

@section('title', 'Resume — Parel Kirby')

@section('content')
    <main class="max-w-4xl mx-auto px-6 py-10 pt-25">
        @include('partials.resume', ['portfolio' => $portfolio])
    </main>
@endsection
