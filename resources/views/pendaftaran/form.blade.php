<!-- resources/views/pendaftaran/form.blade.php -->

<form action="{{ isset($pendaftaran) ? route('pendaftaran.update', $pendaftaran->id) : route('pendaftaran.store') }}"
    method="post">
    @csrf
    @if (isset($pendaftaran))
        @method('PUT')
    @endif

    @if (isset($pendaftaran))
        <input type="hidden" name="id" value="{{ $pendaftaran->id }}">
    @endif

    <div class="form-group">
        <label for="nama">Nama</label>
        <input type="text" class="form-control" id="nama" name="nama" required
            value="{{ isset($pendaftaran) ? $pendaftaran->nama : '' }}">
    </div>
    <div class="form-group">
        <label for="alamat">Alamat</label>
        <textarea class="form-control" id="alamat" name="alamat" required>{{ isset($pendaftaran) ? $pendaftaran->alamat : '' }}</textarea>
    </div>
    <div class="form-group">
        <label for="telepon">Telepon</label>
        <input type="number" class="form-control" id="telepon" name="telepon" required
            value="{{ isset($pendaftaran) ? $pendaftaran->telepon : '' }}">
    </div>
    <button type="submit" class="btn btn-primary">{{ isset($pendaftaran) ? 'Update' : 'Simpan' }}</button>
</form>
