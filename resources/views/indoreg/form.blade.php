<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</head>

<body>
    <div class="container">
        <div class="form-group">
            <label for="province_id">Provinsi : </label><br />
            <select id='province_id' onchange="getRegency()">
                @foreach ($provinces as $row)
                    <option value="{{ $row['id'] }}"> {{ $row['name'] }} </option>
                @endforeach
            </select>
        </div>
        <br>
        <div class="form-group">
            <label for="city_id">Kabupaten / Kota : </label><br />
            <select id='city_id' onchange="getCity()">
                @foreach ($regencies as $kota)
                    <option value="{{ $kota['id'] }}">{{ $kota['name'] }}</option>
                @endforeach
            </select>
        </div>
        <br>
        <div class="form-group">
            <label for="district_id">Kecamatan : </label><br />
            <select id='district_id' onchange="getDistrict()">
                @foreach ($districts as $kecamatan)
                    <option value="{{ $kecamatan['id'] }}">{{ $kecamatan['name'] }}</option>
                @endforeach
            </select>
        </div>
        <br>
        <div class="form-group">
            <label for="villages_id">Kelurahan/Desa : </label><br />
            <select id='villages_id' onchange="getVillages()">
                @foreach ($villages as $kelurahan)
                    <option value="{{ $kelurahan['id'] }}">{{ $kelurahan['name'] }}</option>
                @endforeach
            </select>
        </div>

    </div>
    {{-- jquery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Add the following script inside your HTML's head or at the end of the body -->
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function getRegency() {
            var provinceId = $('#province_id').val();

            $.ajax({
                type: 'POST',
                url: '/get-regencies', // This should match the route definition
                data: {
                    province_id: provinceId
                },
                success: function(data) {
                    console.log('Success!', data);
                    // Update the Regency dropdown options
                    $('#city_id').empty();
                    $.each(data, function(key, value) {
                        $('#city_id').append('<option value="' + value.id + '">' + value.name +
                            '</option>');
                    });

                    // Trigger the change event to update subsequent dropdowns
                    $('#city_id').trigger('change');
                }
            });
        }

        // Repeat similar changes for getCity(), getDistrict(), and getVillages()


        function getCity() {
            var regencyId = $('#city_id').val();

            $.ajax({
                type: 'POST',
                url: '/get-districts',
                data: {
                    regency_id: regencyId
                },
                success: function(data) {
                    // Update the District dropdown options
                    $('#district_id').empty();
                    $.each(data, function(key, value) {
                        $('#district_id').append('<option value="' + value.id + '">' + value.name +
                            '</option>');
                    });

                    // Trigger the change event to update subsequent dropdowns
                    $('#district_id').trigger('change');
                }
            });
        }

        function getDistrict() {
            var districtId = $('#district_id').val();

            $.ajax({
                type: 'POST',
                url: '/get-villages',
                data: {
                    district_id: districtId
                },
                success: function(data) {
                    // Update the Village dropdown options
                    $('#villages_id').empty();
                    $.each(data, function(key, value) {
                        $('#villages_id').append('<option value="' + value.id + '">' + value.name +
                            '</option>');
                    });
                }
            });
        }
    </script>

</body>

</html>
