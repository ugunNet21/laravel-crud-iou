<?php

use App\Http\Controllers\Alamat\AlamatController;
use App\Http\Controllers\AuthLoginController;
use App\Http\Controllers\Consultation\ConsultationController;
use App\Http\Controllers\Indoregion\IndoregionController;
use App\Http\Controllers\Pendaftaran\PendaftaranController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Tte\BSREController;
use App\Http\Controllers\Tte\DTKSController;
use App\Http\Controllers\Tte\TTEController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// chat hotline grok
// Route::middleware(['auth', 'verified'])->group(function () {
//     // Hotline dashboard
//     Route::get('/hotline', [\App\Http\Controllers\Hotchat\HotlineController::class, 'index'])->name('hotline.index');
//     // View specific hotline conversation
//     Route::get('/hotline/{conversation}', [\App\Http\Controllers\Hotchat\HotlineController::class, 'show'])->name('hotline.show');
//     // Send a message in a hotline conversation
//     Route::post('/hotline/{conversation}/message', [\App\Http\Controllers\Hotchat\HotlineController::class, 'sendMessage'])->name('hotline.message.send');
//     // Fetch messages for a conversation (for AJAX)
//     Route::get('/hotline/{conversation}/messages', [\App\Http\Controllers\Hotchat\HotlineController::class, 'getMessages'])->name('hotline.messages');
//     Route::post('/hotline/create', [\App\Http\Controllers\Hotchat\HotlineController::class, 'createHotline'])->name('hotline.create');
// });

// gemini
// Route::prefix('hotline')->name('hotline.')->group(function () {
//     // Menampilkan daftar semua percakapan hotline
//     Route::get('/', [\App\Http\Controllers\Hotchat\HotlineController::class, 'index'])->name('index');
    
//     // Menampilkan form untuk membuat laporan baru
//     Route::get('/create', [\App\Http\Controllers\Hotchat\HotlineController::class, 'create'])->name('create');
    
//     // Menyimpan laporan baru dari form
//     Route::post('/', [\App\Http\Controllers\Hotchat\HotlineController::class, 'store'])->name('store');
    
//     // Menampilkan detail dan chat dari satu percakapan hotline
//     Route::get('/{conversation}', [\App\Http\Controllers\Hotchat\HotlineController::class, 'show'])->name('show');
    
//     // Mengirim pesan baru dalam sebuah percakapan
//     Route::post('/{conversation}/messages', [\App\Http\Controllers\Hotchat\HotlineController::class, 'storeMessage'])->name('messages.store');
// });

// deepsek
Route::middleware(['auth'])->group(function () {
    Route::prefix('hotline')->group(function () {
        Route::get('/', [\App\Http\Controllers\Hotchat\HotlineController::class, 'index'])->name('hotline.index');
        Route::get('/create', [\App\Http\Controllers\Hotchat\HotlineController::class, 'create'])->name('hotline.create');
        Route::post('/', [\App\Http\Controllers\Hotchat\HotlineController::class, 'store'])->name('hotline.store');
        Route::get('/{hotline}', [\App\Http\Controllers\Hotchat\HotlineController::class, 'show'])->name('hotline.show');
        Route::post('/{hotline}/status', [\App\Http\Controllers\Hotchat\HotlineController::class, 'updateStatus'])->name('hotline.update-status');
        Route::post('/{hotline}/message', [\App\Http\Controllers\Hotchat\HotlineController::class, 'sendMessage'])->name('hotline.send-message');

        Route::get('/hotline/group/create', [\App\Http\Controllers\Hotchat\HotlineController::class, 'createGroup'])->name('hotline.group.create');
        Route::post('/hotline/group', [\App\Http\Controllers\Hotchat\HotlineController::class, 'storeGroup'])->name('hotline.group.store');
        Route::get('/api/recipients', [\App\Http\Controllers\Hotchat\HotlineController::class, 'getRecipients']);
    });
});

Route::get('/pendaftaran', [PendaftaranController::class, 'index'])->name('pendaftaran.index');
Route::get('/pendaftaran/create', [PendaftaranController::class, 'create'])->name('pendaftaran.create');
Route::post('/pendaftaran', [PendaftaranController::class, 'store'])->name('pendaftaran.store');
Route::get('/pendaftaran/{id}', [PendaftaranController::class, 'show'])->name('pendaftaran.show');
Route::get('/pendaftaran/{id}/edit', [PendaftaranController::class, 'edit'])->name('pendaftaran.edit');
Route::put('/pendaftaran/{id}/update', [PendaftaranController::class, 'update'])->name('pendaftaran.update');
Route::delete('/pendaftaran/{id}/destroy', [PendaftaranController::class, 'destroy'])->name('pendaftaran.destroy');
Route::post('/pendaftaran/createNew', [PendaftaranController::class, 'storeNew'])->name('pendaftaran.storenew');

Route::get('/consultation', [ConsultationController::class, 'index'])->name('consultation');
Route::post('/create-consultation', [ConsultationController::class, 'create'])->name('create-consultation');

Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('login-page', [AuthLoginController::class, 'showLogin'])->name('login-page');
Route::post('login-masuk', [AuthLoginController::class, 'loginMasuk'])->name('login-masuk');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// otomatis
Route::get('/alamat', [AlamatController::class, 'index']);
Route::get('/get-kecamatan/{kelurahanId}', [AlamatController::class, 'getKecamatan']);

// form gabung alamat
Route::get('/form', function () {
    return view('alamat.form');
});

Route::post('/proses-alamat', [AlamatController::class, 'prosesAlamat'])->name('prosesAlamat');
Route::get('/kecamatans', [AlamatController::class, 'getKecamatans']);
Route::get('/kelurahans/{kecamatan_id}', [AlamatController::class, 'getKelurahans']);

Route::get('/get-all-wilayah', [IndoregionController::class, 'getAllWilayah']);
// Route::post('/get-regencies', [IndoregionController::class, 'getRegenciesByProvince']);
// Route::post('/get-districts', [IndoregionController::class, 'getDistrictsByRegency']);
// Route::post('/get-villages', [IndoregionController::class, 'getVillagesByDistrict']);

// cek json alamat
Route::get('/cekjson', [IndoregionController::class, 'cekJson'])->name('cek-json');
Route::post('/get-regencies', [IndoregionController::class, 'getRegencies'])->name('get-regencies');
Route::post('/get-districts', [IndoregionController::class, 'getDistricts'])->name('get-districts');
Route::post('/get-villages', [IndoregionController::class, 'getVillages'])->name('get-villages');
Route::get('/get-districts-by-villages', [IndoregionController::class, 'getDistrictsByVillages'])->name('get-districts-by-villages');
Route::post('/send-districts-by-villages', [IndoregionController::class, 'getDistrictsByVillages'])->name('send-districts-by-villages');
Route::get('/get-villages-by-district', [IndoregionController::class, 'getVillagesByDistrict'])->name('get-villages-by-district');
Route::post('/send-villages-by-district', [IndoregionController::class, 'getVillagesByDistrict'])->name('send-villages-by-district');
// Route::get('/get-district-by-village', [IndoregionController::class, 'getDistrictByVillage']);
// Route::view('/get-district-by-village', 'get_district_by_village')->name('get-district-by-village');
// Route::post('/get-district-by-village', [IndoregionController::class, 'getDistrictByVillage']);

// Route::get('/get-village', [IndoregionController::class, 'getVillage'])->name('get-village');
// Route::get('/get-district', [IndoregionController::class, 'getDistrict'])->name('get-district');
Route::get('/show-dropdown', [IndoregionController::class, 'showDropdown'])->name('show-dropdown');

Route::get('/get-by-village', [IndoregionController::class, 'getVillage'])->name('get-by-village');
Route::post('/send-by-village', [IndoregionController::class, 'getVillage'])->name('send-by-village');
Route::get('/get-by-district', [IndoregionController::class, 'getDistrict'])->name('get-by-district');
Route::post('/send-by-district', [IndoregionController::class, 'getDistrict'])->name('send-by-district');
// Route::get('/get-district-by-village', [IndoregionController::class, 'showDropdown'])->name('get-district-by-village');
// Route::post('/get-district-by-village', [IndoregionController::class, 'showDropdown'])->name('get-district-by-village');
// Route::post('/get-district-by-village', [IndoregionController::class, 'getDistrictByVillage']);

Route::get('getBSrE', [BSREController::class, 'index']);
Route::post('/send-data-to-bsre', [BSREController::class, 'sendDataToBSRE'])->name('sendDataToBSRE');
Route::get('/generate-pdf/{id}', [BSREController::class, 'generatePDF'])->name('bsre.generate-pdf');

// tte dtks
Route::middleware('dtks')->group(function () {
    Route::get('proses-tte', [DTKSController::class, 'index']);
    Route::post('send-tte', [DTKSController::class, 'update'])->name('dtks.update');

    Route::get('cek-tte', [TTEController::class, 'index']);
    Route::post('kirim-tte', [TTEController::class, 'store'])->name('kirim.tte');
});

// product
Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('products', [ProductController::class, 'store'])->name('products.store');
Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// require __DIR__.'/auth.php';