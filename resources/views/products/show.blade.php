<!DOCTYPE html>
<html>
<head>
    <title>Product Detail</title>
</head>
<body>
    <h1>{{ $product->name }}</h1>
    <p>URL: <a href="{{ $product->url }}">{{ $product->url }}</a></p>
    <h2>QR Code</h2>
    <div>{!! $qrCode !!}</div>
</body>
</html>
