<!-- resources/views/pendaftaran/create.blade.php -->

@extends('layouts.app') {{-- Assuming you have a layout template --}}

@section('content')
    <div class="container">
        <h1>Form Pendaftaran</h1>
        @include('pendaftaran.form', ['pendaftaran' => null])
    </div>
@endsection
