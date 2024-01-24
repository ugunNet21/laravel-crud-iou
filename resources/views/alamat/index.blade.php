<!-- resources/views/alamat/index.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Alamat</title>
    <style>
        label {
            display: block;
            margin-bottom: 8px;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>

    <div class="container">
        <form>
            <label for="kelurahan">Kelurahan:</label>
            <select id="kelurahan" onchange="populateKecamatan()">
                @foreach ($kelurahans as $kelurahan)
                    <option value="{{ $kelurahan->id }}">{{ $kelurahan->name }}</option>
                @endforeach
            </select>

            <label for="kecamatan">Kecamatan:</label>
            <select id="kecamatan">
            </select>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script>
        function populateKecamatan() {
            const kelurahanId = $('#kelurahan').val();

            $.ajax({
                type: 'GET',
                url: '/get-kecamatan/' + kelurahanId,
                success: function(data) {
                    $('#kecamatan').html('<option value="' + data.id + '">' + data.name + '</option>');
                }
            });
        }
    </script>

</body>

</html>
