<!-- resources/views/pendaftaran/edit.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Pendaftaran</h1>
        @include('pendaftaran.form', ['pendaftaran' => $pendaftaran])
    </div>
@endsection
