<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Form Pendaftaran</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1>Form Pendaftaran</h1>
        <form action="{{ route('pendaftaran.store') }}" method="post">
            @csrf

            {{-- Cek apakah koleksi pendaftaran tidak kosong --}}
            @if($pendaftaran->isNotEmpty())
                @foreach ($pendaftaran as $data)
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" required value="{{ old('nama', $data->nama) }}">
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" required>{{ old('alamat', $data->alamat) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="telepon">Telepon</label>
                        <input type="number" class="form-control" id="telepon" name="telepon" required value="{{ old('telepon', $data->telepon) }}">
                    </div>
                @endforeach
            @else
                {{-- Jika data kosong, tampilkan formulir dengan input kosong --}}
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" required value="{{ old('nama') }}">
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" required>{{ old('alamat') }}</textarea>
                </div>
                <div class="form-group">
                    <label for="telepon">Telepon</label>
                    <input type="number" class="form-control" id="telepon" name="telepon" required value="{{ old('telepon') }}">
                </div>
            @endif

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</body>
</html>
