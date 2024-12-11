<?php
// sumber namespace dari file controllernya
// fungsi namespace mengatur alamat
use App\Http\Controllers\landingPageController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
// use : import file
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::httpMethod('/isi-path', [NamaControlller::class, 'namaFunc'])->(identitas_unique_route);
// httpMethod: Get = mengambil data / menampilkan halaman
// post = menambahkan data ke db
// put/patch -> mengupdate data ke db
// delete -> menghapus data dari db
// mengelola data obat
// prefix = nilai awal (awalan) = >mempersingkat
//   /fitur/bagian fitur/
Route::middleware(['isGuest'])->group(function () {
    Route::get('/', [UserController::class, 'showLogin'])->name('login.auth');
    Route::post('/login', [UserController::class, 'loginAuth'])->name('login.proses');
});

// ditambahkan midleware agar dapat diakses hanya untuk yang login
Route::middleware(['isLogin'])->group(function () {
    Route::get('/logout', [UserController::class, 'logout'])->name('logout.proses');
    Route::get('/landing', [landingPageController::class, 'index'])->name('home');

    Route::middleware(['isAdmin'])->group(function () {
        Route::get('/order', [OrderController::class, 'indexAdmin'])->name('pembelian.admin');
        Route::get('/order/export-excel', [OrderController::class, 'exportExcel'])->name('pembelian.admin.export');
        Route::prefix('/obat')->name('obat.')->group(function() {
            // menampilkan halaman
            Route::get('/tambah-obat', [MedicineController::class, 'create'])->name('tambah_obat');
            // menambahkan data
            Route::post('/tambah-obat', [MedicineController::class, 'store'])->name('tambah_obat.formulir');
            Route::get('/data', [MedicineController::class, 'index'])->name('data');
            // kurung kurawal di path disebut path dinamis (akses data spesifik)
            // memakai id karena unik
            // menentukan path dinamis sesuai dengan tujuannya
            // jika ingin mengakses data spesifik, id harus ada
            // jika mengakses semua data, bisa menggunakan selain id (name)
            Route::delete('/hapus/{id}', [MedicineController::class, 'destroy'])->name('hapus');
            Route::get('/edit/{id}', [MedicineController::class, 'edit'])->name('edit');
            Route::patch('/edit/{id}', [MedicineController::class, 'update'])->name('edit.formulir');
            Route::patch('edit/stok/{id}', [MedicineController::class, 'updateStock'])->name('edit.stok');
            Route::get('/export-excel-obat',[MedicineController::class, 'exportExcel'])->name('export');
            // Route::get('/obat', [MedicineController::class, 'index'])->name('obat.index');
        });

        Route::prefix('/user')->name('user.')->group(function() {
            Route::get('/data', [UserController::class, 'index'])->name('data');
            Route::get('/tambah', [UserController::class, 'create'])->name('tambah');
            Route::post('/tambah', [UserController::class, 'store'])->name('tambah.formulir');
            Route::delete('/hapus/{id}', [UserController::class, 'destroy'])->name('hapus');
            Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
            Route::patch('/edit/{id}', [UserController::class, 'update'])->name('edit.formulir');
            Route::get('/export-excel',[UserController::class, 'exportExcel'])->name('export');
        });
    });

    Route::middleware(['isKasir'])->group(function () {
        Route::prefix('/pembelian')->name('pembelian.')->group(function() {
            Route::get('/order', [OrderController::class, 'index'])->name('order');
            Route::get('/formulir', [OrderController::class, 'create'])->name('formulir');
            Route::post('/store-order', [OrderController::class, 'store'])->name('store.order');
            Route::get('/print/{id}', [OrderController::class, 'show'])->name('print');
            Route::get('/download-pdf/{id}', [OrderController::class, 'downloadPDF'])->name('download_pdf');
        });
    });
});
