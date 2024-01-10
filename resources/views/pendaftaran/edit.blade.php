<!-- resources/views/pendaftaran/edit.blade.php -->

{{-- @extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Pendaftaran</h1>
        @include('pendaftaran.form', ['pendaftaran' => $pendaftaran])
    </div>
@endsection --}}


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Data Pendaftaran</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1>Edit Data Pendaftaran</h1>

        @if (Session::has('success'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('success') }}
            </div>
        @endif

        <form action="{{ route('pendaftaran.update', $pendaftaran->id) }}" method="post">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" required
                    value="{{ old('nama', $pendaftaran->nama) }}">
            </div>
            <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat" required>{{ old('alamat', $pendaftaran->alamat) }}</textarea>
            </div>
            <div class="form-group">
                <label for="telepon">Telepon</label>
                <input type="number" class="form-control" id="telepon" name="telepon" required
                    value="{{ old('telepon', $pendaftaran->telepon) }}">
            </div>

            <button type="submit" class="btn btn-primary">Update Data</button>
        </form>
    </div>
</body>

</html>
