<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek tte</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1>CEK Data DTKS TTE</h1>
        <form action="{{ route('kirim.tte') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div>
                <label for="file_keterangan_dtks_sudtks">Lampiran Bukti DTKS SIKS-NG:</label>
                <input type="file" name="file_keterangan_dtks_sudtks" id="file_keterangan_dtks_sudtks" accept=".pdf" required>
            </div>

            <button type="submit">Submit</button>
        </form>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
</body>
</html>
