<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Detail Data Pendaftaran</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1>Detail Data Pendaftaran</h1>

        @if (Session::has('success'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Nama: {{ $pendaftaran->nama }}</h5>
                <p class="card-text">Alamat: {{ $pendaftaran->alamat }}</p>
                <p class="card-text">Telepon: {{ $pendaftaran->telepon }}</p>
            </div>
        </div>

        <a href="{{ route('pendaftaran.index') }}" class="btn btn-primary mt-3">Kembali</a>
    </div>
</body>

</html>
