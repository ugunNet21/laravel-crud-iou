<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Select Kelurahan and Show Kecamatan</title>
    <!-- Load CSS Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <!-- Load jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <h2>Select Kelurahan and Show Kecamatan</h2>

    {{-- <!-- Dropdown for Kelurahan -->
    <label for="village_name">Select Kelurahan:</label><br>
    <select name="village_name" id="village_name" style="width: 50%;">
        @foreach ($datas as $data)
            <option value="{{ $data['id'] }}">{{ $data['text'] }}</option>
        @endforeach
    </select><br><br>

    <!-- Dropdown for Kecamatan -->
    <label for="district_name">Select Kecamatan:</label><br>
    <select name="district_name" id="district_name" style="width: 50%;">
    </select><br><br> --}}

    {{-- <!-- Dropdown for Kelurahan -->
    <label for="village_name">Select Kelurahan:</label><br>
    <select name="village_name" id="village_name" style="width: 50%;">
        <option value="">Select a Kelurahan</option>
    </select><br><br>

    <!-- Dropdown for Kecamatan -->
    <label for="district_name">Select Kecamatan:</label><br>
    <select name="district_name" id="district_name" style="width: 50%;">
        <option value="">Select a Kecamatan</option>
    </select><br><br> --}}

    <!-- Dropdown for Kelurahan -->
    <label for="village_name">Select Kelurahan:</label><br>
    <select name="village_name" id="village_name" style="width: 50%;">
        <option value="">Select a Kelurahan</option>
        @foreach ($villages as $village)
            <option value="{{ $village->id }}">{{ $village->name }}</option>
        @endforeach
    </select><br><br>

    <!-- Dropdown for Kecamatan -->
    <label for="district_name">Select Kecamatan:</label><br>
    <select name="district_name" id="district_name" style="width: 50%;">
        <option value="">Select a Kecamatan</option>
        @foreach ($districts as $district)
            <option value="{{ $district->id }}">{{ $district->name }}</option>
        @endforeach
    </select><br><br>



    <!-- Element to Show Kecamatan -->
    <div id="district_info"></div>

    <!-- Load Select2 JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        // Memuat data kelurahan saat halaman dimuat
        $(document).ready(function() {
            // Inisialisasi Select2 pada dropdown kelurahan dan kecamatan
            $('#village_name').select2();
            $('#district_name').select2();

            // Memuat data kelurahan saat halaman dimuat
            $.ajax({
                url: '/show-dropdown',
                method: 'GET',
                success: function(response) {
                    if (response.status === 200) {
                        // Mengosongkan dropdown sebelum menambahkan opsi baru
                        $('#village_name').empty();
                        response.data.villages.forEach(function(village) {
                            $('#village_name').append('<option value="' + village.id + '">' +
                                village.name + '</option>');
                        });
                    } else {
                        console.log("Failed to get villages");
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    console.log("Error - " + error);
                }
            });

            // Memuat data kecamatan saat halaman dimuat
            $.ajax({
                url: '/show-dropdown',
                method: 'GET',
                success: function(response) {
                    if (response.status === 200) {
                        // Mengosongkan dropdown sebelum menambahkan opsi baru
                        $('#district_name').empty();
                        response.data.districts.forEach(function(district) {
                            $('#district_name').append('<option value="' + district.id + '">' +
                                district.name + '</option>');
                        });
                    } else {
                        console.log("Failed to get districts");
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    console.log("Error - " + error);
                }
            });
        });
    </script>
    {{-- <script>
        $(document).ready(function() {
            // Inisialisasi Select2 pada dropdown kelurahan dan kecamatan
            $('#village_name').select2();
            $('#district_name').select2();

            // Tambahkan event listener untuk perubahan dropdown kelurahan
            $('#village_name').on('change', function() {
                var villageId = $(this).val(); // Ambil nilai kelurahan yang dipilih

                // Kirim permintaan AJAX ke server untuk mendapatkan kecamatan berdasarkan kelurahan yang dipilih
                $.ajax({
                    url: '/get-by-village', // Ganti dengan URL yang sesuai
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content') // Ambil token CSRF dari tag meta
                    },
                    data: {
                        village_name: villageId
                    },
                    success: function(response) {
                        // Perbarui dropdown kecamatan dengan opsi yang diterima dari server
                        $('#district_name').html('');
                        if (response.status === 200) {
                            $.each(response.districts, function(key, value) {
                                $('#district_name').append('<option value="' + value
                                    .id + '">' + value.name + '</option>');
                            });
                        } else {
                            $('#district_name').html(
                                '<option value="">Kecamatan tidak ditemukan</option>');
                            // console
                            console.log("Failed to get districts by village");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        $('#district_name').html(
                            '<option value="">Terjadi kesalahan dalam memproses permintaan</option>'
                            );
                        // console
                        console.log("Error - " + error);
                    }
                });
            });
        });
    </script> --}}

</body>

</html>
