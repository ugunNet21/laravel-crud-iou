<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Konsultasi</title>
</head>
<body>

    <form action="{{ url('/create-consultation') }}" method="post">
        @csrf
        <!-- Other form fields -->
        <button type="submit">Submit</button>
    </form>


</body>
</html>
