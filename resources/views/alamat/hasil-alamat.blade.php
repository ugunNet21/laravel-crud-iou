<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Alamat</title>
    <style>
        /* Gaya CSS untuk tata letak hasil yang lebih profesional */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .hasil-alamat {
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .label {
            font-weight: bold;
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="hasil-alamat">
        <p class="label">Alamat Lengkap:</p>
        <p>{{ $alamatLengkap }}</p>
    </div>
</body>
</html>
