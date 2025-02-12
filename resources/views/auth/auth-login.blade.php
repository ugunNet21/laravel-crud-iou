<!DOCTYPE html>
<html lang="id"> <!-- Ubah lang ke ID -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Sertakan stylesheet CAPTCHA -->
    <link href="{{ captcha_layout_stylesheet_url() }}" type="text/css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>

    <div class="container">
        <div class="row justify-content-center">
           <div class="form-control mt-5">
            <form method="POST" action="{{ route('login-masuk') }}">
                @csrf
                <div class="mb-3">
                    <input type="email" class="form-control"
                           placeholder="Alamat Email"
                           name="email" required>
                </div>

                <div class="mb-3">
                    <input type="password" class="form-control"
                           placeholder="Kata Sandi"
                           name="password" required>
                </div>

                <div class="mb-3">
                    <!-- Gambar CAPTCHA -->
                    {!! captcha_image_html('LoginCaptcha') !!}
                    <input type="text"
                           class="form-control mt-2"
                           placeholder="Masukkan kode CAPTCHA"
                           name="CaptchaCode"
                           id="CaptchaCode"
                           required>

                    @error('CaptchaCode')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    Masuk
                </button>
            </form>
           </div>
        </div>
    </div>

</body>
</html>
