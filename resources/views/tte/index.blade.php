<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Data for BSRE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1>Create Data for BSRE</h1>
        <form action="{{ route('sendDataToBSRE') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div>
                <label for="nik">NIK:</label>
                <input type="text" name="nik" id="nik" value="0803202100007062" required>
            </div>
            <div>
                <label for="passphrase">Passphrase:</label>
                <input type="text" name="passphrase" id="passphrase" value="Hantek1234.!" required>
            </div>
            <div>
                <label for="tampilan">Tampilan:</label>
                <input type="text" name="tampilan" id="tampilan" value="visible" required>
            </div>
            {{-- <div>
                <label for="page">Page:</label>
                <input type="number" name="page" id="page" value="1" required>
            </div> --}}
            {{-- <div>
                <label for="image">Image:</label>
                <select name="image" id="image" required>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div> --}}
            <div>
                <label for="linkQR">link QR:</label>
                <input type="text" name="linkQR" id="linkQR" value="wwww.google.com" required>
            </div>
            {{-- <div>
                <label for="xAxis">X Axis:</label>
                <input type="number" name="xAxis" id="xAxis" value="0" required>
            </div>
            <div>
                <label for="yAxis">Y Axis:</label>
                <input type="number" name="yAxis" id="yAxis" value="0" required>
            </div> --}}
            <div>
                <label for="width">Width:</label>
                <input type="number" name="width" id="width" value="550" required>
            </div>
            <div>
                <label for="height">Height:</label>
                <input type="number" name="height" id="height" value="150" required>
            </div>
            <div>
                <label for="file">PDF File:</label>
                <input type="file" name="file" id="file" accept=".pdf" required>
            </div>
            {{-- <div>
                <label for="imageTTD">Signature Image:</label>
                <input type="file" name="imageTTD" id="imageTTD" accept="image/jpeg, image/png" required>
            </div> --}}
            <div>
                <label for="tag_koordinat">Koordinat:</label>
                <input type="text" name="tag_koordinat" id="tag_koordinat" value="#" >
            </div>
            <button type="submit">Submit</button>
        </form>
        <!-- Tombol cetak PDF -->
        @foreach($getBSRE as $bsre)
            <a href="{{ route('bsre.generate-pdf', ['id' => $bsre->id]) }}" class="btn btn-primary mt-3">Cetak PDF</a>
        @endforeach
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
</body>
</html>
