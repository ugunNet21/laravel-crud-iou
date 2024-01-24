<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Alamat</title>
</head>
<body>
    <div id="app">
        <form @submit.prevent="submitForm">
            @csrf
            <label for="rt">RT:</label>
            <input type="text" v-model="rt" required><br>

            <label for="rw">RW:</label>
            <input type="text" v-model="rw" required><br>

            <label for="kecamatan">Kecamatan:</label>
            <select v-model="selectedKecamatan" @change="loadKelurahan">
                <option value="" disabled>Pilih Kecamatan</option>
                <option v-for="kecamatan in kecamatans" :value="kecamatan.id">{{ kecamatan.nama }}</option>
            </select><br>

            <label for="kelurahan">Kelurahan:</label>
            <select v-model="selectedKelurahan" @change="updateKecamatan">
                <option value="" disabled>Pilih Kelurahan</option>
                <option v-for="kelurahan in kelurahans" :value="kelurahan.id">{{ kelurahan.nama }}</option>
            </select><br>

            <button type="submit">Submit</button>
        </form>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
