<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Alamat</title>
</head>
<body>
    <form action="{{ route('prosesAlamat') }}" method="post">
        @csrf
        <!--input alamat -->
        <label for="alamat_lembaga">Alamat Lembaga:</label>
        <input type="text" name="alamat_lembaga" required><br>
        <!-- Input untuk RT -->
        <label for="rt">RT:</label>
        <input type="text" name="rt" required><br>

        <!-- Input untuk RW -->
        <label for="rw">RW:</label>
        <input type="text" name="rw" required><br>

        <!-- Input untuk Kelurahan -->
        <label for="kelurahan">Kelurahan:</label>
        <input type="text" name="kelurahan" required><br>

        <!-- Input untuk Kecamatan -->
        <label for="kecamatan">Kecamatan:</label>
        <input type="text" name="kecamatan" required><br>

        <!-- Tombol Submit -->
        <button type="submit">Submit</button>
    </form>
</body>
</html>
