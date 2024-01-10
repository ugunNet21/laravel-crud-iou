<!-- resources/views/pendaftaran/create.blade.php -->

{{-- @extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Form Pendaftaran</h1>
        @include('pendaftaran.form', ['pendaftaran' => null])
    </div>
@endsection --}}

{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Form Pendaftaran</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1>Form Pendaftaran</h1>


        @if (Session::has('success'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('success') }}
            </div>
        @endif

        <form action="{{ route('pendaftaran.store') }}" method="post">
            @csrf


            @if ($pendaftaran->isNotEmpty())
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
</html> --}}

{{-- tampiil semua oldv alue dan daftar id --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Form Pendaftaran</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">

        <a href="#" id="buatDataBaru" class="btn btn-primary">Buat data baru</a>
        <a href="/pendaftaran" id="buatDataBaru" class="btn btn-primary">Back to home</a>

        <h1>Form Pendaftaran</h1>

        @if (Session::has('success'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('success') }}
            </div>
        @endif

        {{-- Formulir Update --}}
        @if ($pendaftaran->isNotEmpty())
            @foreach ($pendaftaran as $index => $data)
                <form action="{{ route('pendaftaran.update', $data->id) }}" method="post">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" required
                            value="{{ old('nama', $data->nama) }}">
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" required>{{ old('alamat', $data->alamat) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="telepon">Telepon</label>
                        <input type="number" class="form-control" id="telepon" name="telepon" required
                            value="{{ old('telepon', $data->telepon) }}">
                    </div>

                    <button type="submit" class="btn btn-primary">{{ 'Update Data ' . ($index + 1) }}</button>
                </form>
            @endforeach
        @else
            {{-- Formulir Tambah Data Baru --}}
            <form action="{{ route('pendaftaran.store') }}" method="post">
                @csrf

                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" required
                        value="{{ old('nama') }}">
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" required>{{ old('alamat') }}</textarea>
                </div>
                <div class="form-group">
                    <label for="telepon">Telepon</label>
                    <input type="number" class="form-control" id="telepon" name="telepon" required
                        value="{{ old('telepon') }}">
                </div>

                <button type="submit" class="btn btn-success">{{ 'Simpan Data Baru' }}</button>
            </form>
        @endif
    </div>
    <script>
        document.getElementById('buatDataBaru').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default link behavior

            var confirmation = confirm('Apakah Anda yakin ingin membuat data baru?');

            if (confirmation) {
                var nama = prompt('Masukkan Nama:');
                var alamat = prompt('Masukkan Alamat:');
                var telepon = prompt('Masukkan Nomor Telepon:');

                if (nama !== null && alamat !== null && telepon !== null) {
                    // Create a form dynamically and submit it
                    var form = document.createElement('form');
                    form.method = 'POST';
                    form.action = "{{ route('pendaftaran.storenew') }}";
                    form.style.display = 'none';

                    // Create and append input fields
                    var inputNama = document.createElement('input');
                    inputNama.type = 'text';
                    inputNama.name = 'nama';
                    inputNama.value = nama;
                    form.appendChild(inputNama);

                    var inputAlamat = document.createElement('input');
                    inputAlamat.type = 'text';
                    inputAlamat.name = 'alamat';
                    inputAlamat.value = alamat;
                    form.appendChild(inputAlamat);

                    var inputTelepon = document.createElement('input');
                    inputTelepon.type = 'text';
                    inputTelepon.name = 'telepon';
                    inputTelepon.value = telepon;
                    form.appendChild(inputTelepon);

                    // CSRF token
                    var csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = "{{ csrf_token() }}";
                    form.appendChild(csrfToken);

                    // Append form to the body
                    document.body.appendChild(form);

                    // Submit the form
                    form.submit();
                }
            }
        });
    </script>
</body>

</html>





{{-- end old tampil semua  --}}


{{-- ini tidak tampil --}}
{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Form Pendaftaran</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1>Form Pendaftaran</h1>


        @if (Session::has('success'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('success') }}
            </div>
        @endif

        <form action="{{ isset($data) ? route('pendaftaran.update', $data->id) : route('pendaftaran.store') }}"
            method="post">
            @csrf
            @if (isset($data))
                @method('PUT')
            @endif

            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" required
                    value="{{ old('nama', isset($data) ? $data->nama : '') }}">
            </div>
            <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat" required>{{ old('alamat', isset($data) ? $data->alamat : '') }}</textarea>
            </div>
            <div class="form-group">
                <label for="telepon">Telepon</label>
                <input type="number" class="form-control" id="telepon" name="telepon" required
                    value="{{ old('telepon', isset($data) ? $data->telepon : '') }}">
            </div>

            <button type="submit" class="btn btn-primary">{{ isset($data) ? 'Update' : 'Simpan' }}</button>
        </form>
    </div>
</body>

</html> --}}

{{-- end tidak tampil valuenya --}}


{{-- ini ok untuk edit --}}
{{--
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

        @if (Session::has('success'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('success') }}
            </div>
        @endif
        @if ($pendaftaran->isNotEmpty())
            @foreach ($pendaftaran as $data)
                <form action="{{ route('pendaftaran.update', $data->id) }}" method="post">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" required
                            value="{{ old('nama', $data->nama) }}">
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" required>{{ old('alamat', $data->alamat) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="telepon">Telepon</label>
                        <input type="number" class="form-control" id="telepon" name="telepon" required
                            value="{{ old('telepon', $data->telepon) }}">
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            @endforeach

        @else
            <form action="{{ route('pendaftaran.store') }}" method="post">
                @csrf

                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" required
                        value="{{ old('nama') }}">
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" required>{{ old('alamat') }}</textarea>
                </div>
                <div class="form-group">
                    <label for="telepon">Telepon</label>
                    <input type="number" class="form-control" id="telepon" name="telepon" required
                        value="{{ old('telepon') }}">
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        @endif
    </div>
</body>

</html> --}}


{{-- in or update  --}}
{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Form Pendaftaran</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1>Form Pendaftaran</h1>

        @if (Session::has('success'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('success') }}
            </div>
        @endif
        @if ($pendaftaran->isNotEmpty())
            @foreach ($pendaftaran as $data)
                <form action="{{ route('pendaftaran.update', $data->id) }}" method="post">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" required
                            value="{{ old('nama', $data->nama) }}">
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" required>{{ old('alamat', $data->alamat) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="telepon">Telepon</label>
                        <input type="number" class="form-control" id="telepon" name="telepon" required
                            value="{{ old('telepon', $data->telepon) }}">
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            @endforeach
        @else
            <form action="{{ route('pendaftaran.store') }}" method="post">
                @csrf

                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" required
                        value="{{ old('nama') }}">
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" required>{{ old('alamat') }}</textarea>
                </div>
                <div class="form-group">
                    <label for="telepon">Telepon</label>
                    <input type="number" class="form-control" id="telepon" name="telepon" required
                        value="{{ old('telepon') }}">
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>

            <button class="btn btn-success mt-3" id="btnTambahBaru">Tambah Baru</button>
            <form action="{{ route('pendaftaran.create') }}" method="get" id="formTambahBaru" style="display: none;">
                @csrf
                <button type="submit" class="btn btn-info mt-3">Tambah Data Baru</button>
            </form>
        @endif

        <script>
            document.getElementById('btnTambahBaru').addEventListener('click', function () {
                document.getElementById('formTambahBaru').style.display = 'block';
            });
        </script>

    </div>
</body>

</html> --}}
