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
                @endforeach
            @else

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
            @endif

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</body>

</html> --}}


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Data Pendaftaran</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
</head>

<body>
    <div class="container">
        <h1>Data Pendaftaran</h1>
        @if (Session::has('success'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('success') }}
            </div>
        @endif

        <div class="row mb-3">
            <div class="col">
                <a href="{{ route('pendaftaran.create') }}" class="btn btn-primary">Tambah Pendaftaran Baru</a>
            </div>
        </div>

        @if ($pendaftaran->isNotEmpty())
            <table id="pendaftaranTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Telepon</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pendaftaran as $data)
                        <tr>
                            <td>{{ $data->nama }}</td>
                            <td>{{ $data->telepon }}</td>
                            <td>
                                <a href="{{ route('pendaftaran.show', $data->id) }}"
                                    class="btn btn-info btn-sm">Details</a>
                                <a href="{{ route('pendaftaran.edit', $data->id) }}"
                                    class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('pendaftaran.destroy', $data->id) }}" method="post"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

            <script>
                $(document).ready(function() {
                    $('#pendaftaranTable').DataTable();
                });
            </script>
        @else
            <div class="alert alert-info" role="alert">
                Tidak ada data pendaftaran.
            </div>
        @endif
    </div>
</body>

</html>
