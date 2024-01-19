<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Jadwal Konsultasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</head>

<body>
    <div class="container">
        @auth
            <p>Halo {{ Auth::user()->name }},</p>

            <p>Terima kasih telah membuat jadwal konsultasi. Berikut adalah detail konfirmasi:</p>

            <ul>
                <li>Nama Pengguna: {{ Auth::user()->name }}</li>
                <li>Waktu Konsultasi: {{ $consultationTime ?? 'Belum Dijadwalkan' }}</li>
            </ul>

            <p>Terima kasih dan semoga konsultasi Anda bermanfaat.</p>

            <p>Salam,</p>
            <p>Tim Kesehatan Aplikasi Kami</p>

            <!-- Sembunyikan formulir setelah pengguna membuat jadwal konsultasi -->
            @empty($consultationTime)
                <form action="/create-consultation" method="POST">
                    @csrf
                    <!-- Hard code input fields -->
                    <label for="appointment_date">Pilih Tanggal Konsultasi:</label>
                    <input type="date" id="appointment_date" name="appointment_date" required>

                    <label for="appointment_time">Pilih Waktu Konsultasi:</label>
                    <input type="time" id="appointment_time" name="appointment_time" required>

                    <button type="submit">Buat Jadwal Konsultasi</button>
                </form>
            @endempty
        @else
            <p>Anda tidak masuk. Silakan <a href="{{ route('login') }}">masuk</a> untuk membuat jadwal konsultasi.</p>
        @endauth
    </div>
</body>

</html>
