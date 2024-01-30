<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <div class="container">
        <h1>Data JSON</h1>

        <p>Status: {{ $data['status'] ? 'True' : 'False' }}</p>

        <form action="{{ route('cek-json') }}" method="post">
            @csrf
            <p>Keterangan Pemohon</p>
            <h2>Provinsi :</h2>
            <select name="provinsi" id="provinsi">
                @foreach ($data['provinces'] as $province)
                    <option value="{{ $province['id'] }}">{{ $province['name'] }}</option>
                @endforeach
            </select>

            <h2>Kota/Kabupaten :</h2>
            <select name="kota_kabupaten" id="kota_kabupaten">
            </select>

            <h2>Kecamatan :</h2>
            <select name="kecamatan" id="kecamatan">
            </select>
            <h2>Kelurahan :</h2>
            <select name="kelurahan" id="kelurahan">
            </select>

            <p>Alamat Pemohon</p>
            <h2>Kelurahan Pemohon :</h2>
            <select name="kelurahan_2" id="kelurahan_2">
                @foreach ($data['villages'] as $village)
                    <option value="{{ $village['id'] }}">{{ $village['name'] }}</option>
                @endforeach
            </select>

            <h2>Kecamatan Pemohon :</h2>
            <select name="kecamatan_2" id="kecamatan_2">
                {{-- dynamic otomatis kecamatan_2 --}}
            </select>

            <button type="submit">Kirim</button>
        </form>
    </div>
    <script>
        $(document).ready(function() {
            $('#provinsi').change(function() {
                var provinceId = $(this).val();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('get-regencies') }}',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'province_id': provinceId
                    },
                    success: function(data) {
                        var options = '<option value="">Pilih Kota/Kabupaten</option>';
                        $.each(data.regencies, function(key, regency) {
                            options += '<option value="' + regency.id + '">' + regency
                                .name + '</option>';
                        });
                        $('#kota_kabupaten').html(options);
                    }
                });
            });

            $('#kota_kabupaten').change(function() {
                var regencyId = $(this).val();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('get-districts') }}',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'regency_id': regencyId
                    },
                    success: function(data) {
                        var options = '<option value="">Pilih Kecamatan</option>';
                        $.each(data.districts, function(key, district) {
                            options += '<option value="' + district.id + '">' + district
                                .name + '</option>';
                        });
                        $('#kecamatan').html(options);
                    }
                });
            });
            $(document).ready(function() {
                $('#kecamatan').change(function() {
                    var districtId = $(this).val();

                    $.ajax({
                        type: 'POST',
                        url: '{{ route('get-villages') }}',
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'district_id': districtId
                        },
                        success: function(data) {
                            var options = '<option value="">Pilih Kelurahan</option>';
                            $.each(data.villages, function(key, village) {
                                options += '<option value="' + village.id +
                                    '">' + village.name + '</option>';
                            });
                            $('#kelurahan').html(options);
                        }
                    });
                });
            });

            $('#kelurahan_2').change(function() {
                var villageId = $(this).val();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('get-districts-by-villages') }}',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'village_id': villageId
                    },
                    success: function(data) {
                        var options = '<option value="">Pilih Kecamatan</option>';
                        $.each(data.districts, function(key, district) {
                            options += '<option value="' + district.id + '">' + district
                                .name + '</option>';
                        });
                        $('#kecamatan_2').html(options);
                    }
                });
            });

            $('#kecamatan_2').change(function() {
                var districtId = $(this).val();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('get-villages-by-district') }}',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'district_id': districtId
                    },
                    success: function(data) {
                        var options = '<option value="">Pilih Kelurahan</option>';
                        $.each(data.villages, function(key, village) {
                            options += '<option value="' + village.id +
                                '">' + village.name + '</option>';
                        });
                        $('#kelurahan_2').html(options);
                    }
                });
            });

        });
    </script>

</body>

</html>
{{-- <div class="container">
        <h1>Data JSON</h1>

        <p>Status: {{ $data['status'] ? 'True' : 'False' }}</p>

        <h2>Provinsi :</h2>
        <select>
            @foreach ($data['provinces'] as $province)
                <option value="{{ $province['id'] }}">{{ $province['name'] }}</option>
            @endforeach
        </select>

        <h2>Kota/Kabupaten :</h2>
        <select>
            @foreach ($data['regencies'] as $regencies)
                <option value="{{ $regencies['id'] }} "> {{ $regencies['name'] }}</option>
            @endforeach
        </select>

        <h2>Kecamatan :</h2>
        <select>
            @foreach ($data['districts'] as $districts)
                <option value="{{ $districts['id'] }} "> {{ $districts['name'] }}</option>
            @endforeach
        </select>
    </div> --}}
