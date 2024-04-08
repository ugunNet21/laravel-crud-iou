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
    <h1>Create Data for BSRE</h1>
    <form action="{{ route('bsre.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="nik">NIK:</label>
            <input type="text" name="nik" id="nik" required>
        </div>
        <div>
            <label for="passphrase">Passphrase:</label>
            <input type="text" name="passphrase" id="passphrase" required>
        </div>
        <div>
            <label for="tampilan">Tampilan:</label>
            <input type="text" name="tampilan" id="tampilan" required>
        </div>
        <div>
            <label for="page">Page:</label>
            <input type="number" name="page" id="page" required>
        </div>
        <div>
            <label for="image">Image:</label>
            <select name="image" id="image" required>
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </div>
        <div>
            <label for="xAxis">X Axis:</label>
            <input type="number" name="xAxis" id="xAxis" required>
        </div>
        <div>
            <label for="yAxis">Y Axis:</label>
            <input type="number" name="yAxis" id="yAxis" required>
        </div>
        <div>
            <label for="width">Width:</label>
            <input type="number" name="width" id="width" required>
        </div>
        <div>
            <label for="height">Height:</label>
            <input type="number" name="height" id="height" required>
        </div>
        <div>
            <label for="file">PDF File:</label>
            <input type="file" name="file" id="file" accept=".pdf" required>
        </div>
        <div>
            <label for="imageTTD">Signature Image:</label>
            <input type="file" name="imageTTD" id="imageTTD" accept="image/jpeg, image/png" required>
        </div>
        <button type="submit">Submit</button>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
