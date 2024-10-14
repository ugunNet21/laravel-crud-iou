<!DOCTYPE html>
<html>
<head>
    <title>Create Product</title>
</head>
<body>
    <h1>Create Product</h1>
    <form action="{{ route('products.store') }}" method="POST">
        @csrf
        <label for="name">Product Name:</label>
        <input type="text" name="name" required>

        <label for="url">Product URL:</label>
        <input type="url" name="url" required>

        <button type="submit">Create Product</button>
    </form>
</body>
</html>
