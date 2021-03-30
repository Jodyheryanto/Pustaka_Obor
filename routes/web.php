<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminPengarangController;
use App\Http\Controllers\Admin\AdminDistributorController;
use App\Http\Controllers\Admin\AdminPenerjemahController;
use App\Http\Controllers\Admin\AdminKategoriController;
use App\Http\Controllers\Admin\AdminLokasiController;
use App\Http\Controllers\Admin\AdminPenerbitController;
use App\Http\Controllers\Admin\AdminSalesmanController;
use App\Http\Controllers\Admin\AdminPelangganController;
use App\Http\Controllers\Admin\AdminSupplierController;
use App\Http\Controllers\Admin\AdminIndukBukuController;
use App\Http\Controllers\Admin\AdminBeliBukuController;
use App\Http\Controllers\Admin\AdminJualBukuController;
use App\Http\Controllers\Admin\AdminReturBeliController;
use App\Http\Controllers\Admin\AdminReturJualController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\DependentDropdownController;
use App\Http\Controllers\Admin\PDFController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminKonsinyasiController;
use App\Http\Controllers\Admin\AdminPenerimaController;
use App\Http\Controllers\Admin\AdminDebitHutangController;
use App\Http\Controllers\Admin\AdminDebitPiutangController;
use App\Http\Controllers\Admin\AdminKasController;
use App\Http\Controllers\Admin\AdminNeracaController;
use App\Http\Controllers\Admin\AdminBukuBesarController;
use App\Http\Controllers\Admin\AdminDataAccountController;
use App\Http\Controllers\Admin\AdminKasLainController;
use App\Http\Controllers\Admin\AdminLabaRugiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\User\UserRoyaltiController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', [UserController::class, 'index'])->name('dashboard');
// Untuk User Route
Route::namespace('User')->name('user.')->group(function() {
    Route::get('not-found', [UserRoyaltiController::class, 'not_found'])->name('not-found');
    Route::get('/', [UserRoyaltiController::class, 'index'])->name('index');
    Route::post('list-buku', [UserRoyaltiController::class, 'list_buku'])->name('list-buku');
    Route::get('list-buku', [UserRoyaltiController::class, 'index'])->name('list-buku');
    // Route::get('grafik-royalti', [UserRoyaltiController::class, 'grafik_royalti'])->name('grafik-royalti');
    Route::get('grafik-royalti/{id}', [UserRoyaltiController::class, 'grafik_royalti'])->name('grafik-royalti');
});

// Untuk Admin Route
Route::middleware(['auth:sanctum', 'verified'])->namespace('Admin')->prefix('admin')->name('admin.')->group(function() {
    Route::get('/forbidden/2301c57345abf7a8c06651e72cae1992222cb6226ddd63018691df949794ba6f/maintenance', function (){
        Artisan::call('down');
        return redirect(Request::url());
    });
    Route::get('/forbidden/2301c57345abf7a8c06651e72cae1992222cb6226ddd63018691df949794ba6f/clear-cache', function() {
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        return "Cache is cleared";
    });
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/', [AdminDashboardController::class, 'index'])->name('home');
    Route::get('kartustock', [PDFController::class, 'downkartustok'])->name('kartustock');
    Route::get('viewkartustock', [PDFController::class, 'showkartustok'])->name('viewkartustock');
    Route::get('viewpersediaan', [PDFController::class, 'showpersediaan'])->name('viewpersediaan');
    Route::get('persediaan', [PDFController::class, 'downpersediaan'])->name('persediaan');
    Route::get('viewroyalti', [PDFController::class, 'showroyalti'])->name('viewroyalti');
    Route::get('royalti', [PDFController::class, 'downroyalti'])->name('royalti');
    Route::get('viewsalesman', [PDFController::class, 'showsalesman'])->name('viewsalesman');
    Route::get('analisa-salesman', [PDFController::class, 'downsalesman'])->name('analisa-salesman');
    Route::get('viewpelanggan', [PDFController::class, 'showpelanggan'])->name('viewpelanggan');
    Route::get('analisa-pelanggan', [PDFController::class, 'downpelanggan'])->name('analisa-pelanggan');
    /* Dashboard Section */
    Route::prefix('dependent-dropdown')->name('dependent-dropdown.')->group(function() {
        Route::get('district/{id}', [DependentDropdownController::class, 'district'])->name('district');    
        Route::get('village/{id}', [DependentDropdownController::class, 'village'])->name('village');    
    });
    Route::prefix('user')->name('user.')->group(function() {
        Route::get('register', [AdminUserController::class, 'create'])->name('showRegisterForm');
        Route::get('list', [AdminUserController::class, 'list'])->name('list');
        Route::post('register', [AdminUserController::class, 'store'])->name('register');
        Route::get('edit/{id}', [AdminUserController::class, 'showEditForm'])->name('showEditForm');
        Route::post('edit', [AdminUserController::class, 'edit'])->name('edit');
        Route::post('change-password', [AdminUserController::class, 'changePassword'])->name('change-password');
        Route::post('delete',[AdminUserController::class, 'delete'])->name('delete');
        Route::post('ubah-status',[AdminUserController::class, 'ubahStatus'])->name('ubah-status');
    });
    Route::prefix('master')->name('master.')->group(function() {
        Route::prefix('pengarang')->name('pengarang.')->group(function() {
            /* Dashboard Section */
            Route::get('create',[AdminPengarangController::class, 'showCreateForm'])->name('showCreateForm');
            Route::post('create',[AdminPengarangController::class, 'create'])->name('create');
            Route::get('edit/{id}',[AdminPengarangController::class, 'showEditForm'])->name('showEditForm');
            Route::post('edit',[AdminPengarangController::class, 'update'])->name('update');
            Route::get('list', [AdminPengarangController::class, 'list'])->name('list');
            Route::post('delete',[AdminPengarangController::class, 'delete'])->name('delete');
            Route::post('ubah-status',[AdminPengarangController::class, 'ubahStatus'])->name('ubah-status');
            Route::get('/info/{id}', [AdminPengarangController::class, 'getInfo']);
        });
        Route::prefix('distributor')->name('distributor.')->group(function() {
            /* Dashboard Section */
            Route::get('create',[AdminDistributorController::class, 'showCreateForm'])->name('showCreateForm');
            Route::post('create',[AdminDistributorController::class, 'create'])->name('create');
            Route::get('edit/{id}',[AdminDistributorController::class, 'showEditForm'])->name('showEditForm');
            Route::post('edit',[AdminDistributorController::class, 'update'])->name('update');
            Route::get('list', [AdminDistributorController::class, 'list'])->name('list');
            Route::post('delete',[AdminDistributorController::class, 'delete'])->name('delete');
            Route::get('/info/{id}', [AdminDistributorController::class, 'getInfo']);
        });
        Route::prefix('penerjemah')->name('penerjemah.')->group(function() {
            /* Dashboard Section */
            Route::get('create',[AdminPenerjemahController::class, 'showCreateForm'])->name('showCreateForm');
            Route::post('create',[AdminPenerjemahController::class, 'create'])->name('create');
            Route::get('edit/{id}',[AdminPenerjemahController::class, 'showEditForm'])->name('showEditForm');
            Route::post('edit',[AdminPenerjemahController::class, 'update'])->name('update');
            Route::get('list', [AdminPenerjemahController::class, 'list'])->name('list');
            Route::post('delete',[AdminPenerjemahController::class, 'delete'])->name('delete');
            Route::get('/info/{id}', [AdminPenerjemahController::class, 'getInfo']);
        });
        Route::prefix('kategori')->name('kategori.')->group(function() {
            /* Dashboard Section */
            Route::get('create',[AdminKategoriController::class, 'showCreateForm'])->name('showCreateForm');
            Route::post('create',[AdminKategoriController::class, 'create'])->name('create');
            Route::get('edit/{id}',[AdminKategoriController::class, 'showEditForm'])->name('showEditForm');
            Route::post('edit',[AdminKategoriController::class, 'update'])->name('update');
            Route::get('list', [AdminKategoriController::class, 'list'])->name('list');
            Route::post('delete',[AdminKategoriController::class, 'delete'])->name('delete');
        });
        Route::prefix('lokasi')->name('lokasi.')->group(function() {
            /* Dashboard Section */
            Route::get('create',[AdminLokasiController::class, 'showCreateForm'])->name('showCreateForm');
            Route::post('create',[AdminLokasiController::class, 'create'])->name('create');
            Route::get('edit/{id}',[AdminLokasiController::class, 'showEditForm'])->name('showEditForm');
            Route::post('edit',[AdminLokasiController::class, 'update'])->name('update');
            Route::get('list', [AdminLokasiController::class, 'list'])->name('list');
            Route::post('delete',[AdminLokasiController::class, 'delete'])->name('delete');
        });
        Route::prefix('penerbit')->name('penerbit.')->group(function() {
            /* Dashboard Section */
            Route::get('create',[AdminPenerbitController::class, 'showCreateForm'])->name('showCreateForm');
            Route::post('create',[AdminPenerbitController::class, 'create'])->name('create');
            Route::get('edit/{id}',[AdminPenerbitController::class, 'showEditForm'])->name('showEditForm');
            Route::post('edit',[AdminPenerbitController::class, 'update'])->name('update');
            Route::get('list', [AdminPenerbitController::class, 'list'])->name('list');
            Route::post('delete',[AdminPenerbitController::class, 'delete'])->name('delete');
            Route::get('/info/{id}', [AdminPenerbitController::class, 'getInfo']);
        });
        Route::prefix('salesman')->name('salesman.')->group(function() {
            /* Dashboard Section */
            Route::get('create',[AdminSalesmanController::class, 'showCreateForm'])->name('showCreateForm');
            Route::post('create',[AdminSalesmanController::class, 'create'])->name('create');
            Route::get('edit/{id}',[AdminSalesmanController::class, 'showEditForm'])->name('showEditForm');
            Route::post('edit',[AdminSalesmanController::class, 'update'])->name('update');
            Route::get('list', [AdminSalesmanController::class, 'list'])->name('list');
            Route::post('delete',[AdminSalesmanController::class, 'delete'])->name('delete');
            Route::get('/info/{id}', [AdminSalesmanController::class, 'getInfo']);
        });
        Route::prefix('pelanggan')->name('pelanggan.')->group(function() {
            /* Dashboard Section */
            Route::get('create',[AdminPelangganController::class, 'showCreateForm'])->name('showCreateForm');
            Route::post('create',[AdminPelangganController::class, 'create'])->name('create');
            Route::get('edit/{id}',[AdminPelangganController::class, 'showEditForm'])->name('showEditForm');
            Route::post('edit',[AdminPelangganController::class, 'update'])->name('update');
            Route::get('list', [AdminPelangganController::class, 'list'])->name('list');
            Route::post('delete',[AdminPelangganController::class, 'delete'])->name('delete');
            Route::get('/info/{id}', [AdminPelangganController::class, 'getInfo']);
        });
        Route::prefix('supplier')->name('supplier.')->group(function() {
            /* Dashboard Section */
            Route::get('create',[AdminSupplierController::class, 'showCreateForm'])->name('showCreateForm');
            Route::post('create',[AdminSupplierController::class, 'create'])->name('create');
            Route::get('edit/{id}',[AdminSupplierController::class, 'showEditForm'])->name('showEditForm');
            Route::post('edit',[AdminSupplierController::class, 'update'])->name('update');
            Route::get('list', [AdminSupplierController::class, 'list'])->name('list');
            Route::post('delete',[AdminSupplierController::class, 'delete'])->name('delete');
            Route::get('/info/{id}', [AdminSupplierController::class, 'getInfo']);
        });
    });
    Route::prefix('inventori')->name('inventori.')->group(function() {
        Route::prefix('induk-buku')->name('induk-buku.')->group(function() {
            /* Dashboard Section */
            Route::get('create',[AdminIndukBukuController::class, 'showCreateForm'])->name('showCreateForm');
            Route::post('create',[AdminIndukBukuController::class, 'create'])->name('create');
            Route::get('edit/{id}',[AdminIndukBukuController::class, 'showEditForm'])->name('showEditForm');
            Route::post('edit',[AdminIndukBukuController::class, 'update'])->name('update');
            Route::get('list', [AdminIndukBukuController::class, 'list'])->name('list');
            Route::post('delete',[AdminIndukBukuController::class, 'delete'])->name('delete');
            Route::get('/info/{id}', [AdminIndukBukuController::class, 'getInfo']);
        });
        Route::prefix('pembelian-buku')->name('pembelian-buku.')->group(function() {
            /* Dashboard Section */
            Route::get('create',[AdminBeliBukuController::class, 'showCreateForm'])->name('showCreateForm');
            Route::post('create',[AdminBeliBukuController::class, 'create'])->name('create');
            Route::get('edit/{id}',[AdminBeliBukuController::class, 'showEditForm'])->name('showEditForm');
            Route::post('edit',[AdminBeliBukuController::class, 'update'])->name('update');
            Route::get('list', [AdminBeliBukuController::class, 'list'])->name('list');
            Route::post('delete',[AdminBeliBukuController::class, 'delete'])->name('delete');
            Route::get('/info/{id}', [AdminBeliBukuController::class, 'getInfo']);
            Route::get('/faktur/{id}', [AdminBeliBukuController::class, 'getFaktur']);
            Route::get('cetak', [AdminBeliBukuController::class, 'cetak'])->name('cetak-faktur');
            Route::get('filter', [AdminBeliBukuController::class, 'filter'])->name('filter');
        });
        Route::prefix('penjualan-buku')->name('penjualan-buku.')->group(function() {
            /* Dashboard Section */
            Route::get('create',[AdminJualBukuController::class, 'showCreateForm'])->name('showCreateForm');
            Route::post('create',[AdminJualBukuController::class, 'create'])->name('create');
            Route::get('edit/{id}',[AdminJualBukuController::class, 'showEditForm'])->name('showEditForm');
            Route::post('edit',[AdminJualBukuController::class, 'update'])->name('update');
            Route::get('list', [AdminJualBukuController::class, 'list'])->name('list');
            Route::post('delete',[AdminJualBukuController::class, 'delete'])->name('delete');
            Route::get('/info/{id}', [AdminJualBukuController::class, 'getInfo']);
            Route::get('/faktur/{id}', [AdminJualBukuController::class, 'getFaktur']);
            Route::get('cetak', [AdminJualBukuController::class, 'cetak'])->name('cetak-faktur');
            Route::get('cek-ongkir', [AdminJualBukuController::class, 'showOngkirForm'])->name('showOngkirForm');
            // Route::post('cek-ongkir',function (){
            //     return response()->view('errors.403');
            // })->name('cekOngkir');
            Route::post('cek-ongkir',[AdminJualBukuController::class, 'cekOngkir'])->name('cekOngkir');
            Route::post('info-ongkir', [AdminJualBukuController::class, 'info_ongkir']);
            Route::post('ubah-status', [AdminJualBukuController::class, 'ubahstatus'])->name('ubahstatus');
            Route::get('filter', [AdminJualBukuController::class, 'filter'])->name('filter');
        });
        Route::prefix('retur-pembelian')->name('retur-pembelian.')->group(function() {
            /* Dashboard Section */
            Route::get('create',[AdminReturBeliController::class, 'showCreateForm'])->name('showCreateForm');
            Route::post('create',[AdminReturBeliController::class, 'create'])->name('create');
            Route::get('edit/{id}',[AdminReturBeliController::class, 'showEditForm'])->name('showEditForm');
            Route::post('edit',[AdminReturBeliController::class, 'update'])->name('update');
            Route::get('list', [AdminReturBeliController::class, 'list'])->name('list');
            Route::post('delete',[AdminReturBeliController::class, 'delete'])->name('delete');
            Route::get('cetak', [AdminReturBeliController::class, 'cetak'])->name('cetak-faktur');
        });
        Route::prefix('retur-penjualan')->name('retur-penjualan.')->group(function() {
            /* Dashboard Section */
            Route::get('create',[AdminReturJualController::class, 'showCreateForm'])->name('showCreateForm');
            Route::post('create',[AdminReturJualController::class, 'create'])->name('create');
            Route::get('edit/{id}',[AdminReturJualController::class, 'showEditForm'])->name('showEditForm');
            Route::post('edit',[AdminReturJualController::class, 'update'])->name('update');
            Route::get('list', [AdminReturJualController::class, 'list'])->name('list');
            Route::get('cetak', [AdminReturJualController::class, 'cetak'])->name('cetak-faktur');
            Route::post('delete',[AdminReturJualController::class, 'delete'])->name('delete');
        });
        Route::prefix('penerima-titip')->name('penerima-titip.')->group(function() {
            Route::get('/info/{id}', [AdminPenerimaController::class, 'getInfo']);
        });
    });
    Route::prefix('hutang-piutang')->name('hutang-piutang.')->group(function() {
        Route::prefix('debit-piutang')->name('debit-piutang.')->group(function() {
            /* Dashboard Section */
            Route::get('create',[AdminDebitPiutangController::class, 'showCreateForm'])->name('showCreateForm');
            Route::post('create',[AdminDebitPiutangController::class, 'create'])->name('create');
            Route::get('bayar/{id}',[AdminDebitPiutangController::class, 'showBayarForm'])->name('showBayarForm');
            Route::post('bayar',[AdminDebitPiutangController::class, 'bayar'])->name('bayar');
            Route::post('filter',[AdminDebitPiutangController::class, 'filter'])->name('filter');
            Route::get('edit/{id}',[AdminDebitPiutangController::class, 'showEditForm'])->name('showEditForm');
            Route::post('edit',[AdminDebitPiutangController::class, 'update'])->name('update');
            Route::get('list', [AdminDebitPiutangController::class, 'list'])->name('list');
            Route::post('delete',[AdminDebitPiutangController::class, 'delete'])->name('delete');
            Route::get('/info/{id}', [AdminDebitPiutangController::class, 'getInfo']);
        });
        Route::prefix('debit-hutang')->name('debit-hutang.')->group(function() {
            /* Dashboard Section */
            Route::get('create',[AdminDebitHutangController::class, 'showCreateForm'])->name('showCreateForm');
            Route::post('create',[AdminDebitHutangController::class, 'create'])->name('create');
            Route::get('bayar/{id}',[AdminDebitHutangController::class, 'showBayarForm'])->name('showBayarForm');
            Route::post('bayar',[AdminDebitHutangController::class, 'bayar'])->name('bayar');
            Route::get('edit/{id}',[AdminDebitHutangController::class, 'showEditForm'])->name('showEditForm');
            Route::post('edit',[AdminDebitHutangController::class, 'update'])->name('update');
            Route::get('list', [AdminDebitHutangController::class, 'list'])->name('list');
            Route::post('delete',[AdminDebitHutangController::class, 'delete'])->name('delete');
            Route::get('/info/{id}', [AdminDebitHutangController::class, 'getInfo']);
            Route::get('cetak', [AdminDebitHutangController::class, 'cetak'])->name('cetak-faktur');
        });
    });
    Route::prefix('buku-besar')->name('buku-besar.')->group(function() {
        Route::get('laporan-keuangan',[AdminBukuBesarController::class, 'index'])->name('laporan-keuangan');
        Route::get('laporan-kas',[AdminKasController::class, 'index'])->name('laporan-kas');
        Route::get('laporan-laba-rugi',[AdminLabaRugiController::class, 'index'])->name('laporan-laba-rugi');
        Route::prefix('kas-lain2')->name('kas-lain2.')->group(function() {
            /* Dashboard Section */
            Route::get('create',[AdminKasLainController::class, 'showCreateForm'])->name('showCreateForm');
            Route::post('create',[AdminKasLainController::class, 'create'])->name('create');
            Route::get('edit/{id}',[AdminKasLainController::class, 'showEditForm'])->name('showEditForm');
            Route::post('edit',[AdminKasLainController::class, 'update'])->name('update');
            Route::get('list', [AdminKasLainController::class, 'list'])->name('list');
            Route::post('delete',[AdminKasLainController::class, 'delete'])->name('delete');
        });
        Route::prefix('data-account')->name('data-account.')->group(function() {
            /* Dashboard Section */
            Route::get('create',[AdminDataAccountController::class, 'showCreateForm'])->name('showCreateForm');
            Route::post('create',[AdminDataAccountController::class, 'create'])->name('create');
            Route::get('edit/{id}',[AdminDataAccountController::class, 'showEditForm'])->name('showEditForm');
            Route::post('edit',[AdminDataAccountController::class, 'update'])->name('update');
            Route::get('list', [AdminDataAccountController::class, 'list'])->name('list');
            Route::post('delete',[AdminDataAccountController::class, 'delete'])->name('delete');
        });
        Route::get('laporan-neraca',[AdminNeracaController::class, 'index'])->name('laporan-neraca');
        Route::prefix('penjualan')->name('penjualan.')->group(function() {
            Route::get('filter',[AdminDebitPiutangController::class, 'filter'])->name('filter');
            Route::get('lapor-penjualan',[AdminDebitPiutangController::class, 'penjualan'])->name('lapor-penjualan');
            Route::get('lapor-piutang',[AdminDebitPiutangController::class, 'piutang'])->name('lapor-piutang');
            Route::get('lapor-retur-penjualan',[AdminDebitPiutangController::class, 'retur_penjualan'])->name('lapor-retur-penjualan');
            Route::get('lapor-royalti',[AdminDebitPiutangController::class, 'royalti'])->name('lapor-royalti');
        });
        Route::prefix('pembelian')->name('pembelian.')->group(function() {
            Route::get('filter',[AdminDebitHutangController::class, 'filter'])->name('filter');
            Route::get('lapor-pembelian',[AdminDebitHutangController::class, 'pembelian'])->name('lapor-pembelian');
            Route::get('lapor-hutang',[AdminDebitHutangController::class, 'hutang'])->name('lapor-hutang');
            Route::get('lapor-retur-pembelian',[AdminDebitHutangController::class, 'retur_pembelian'])->name('lapor-retur-pembelian');
        });
    });
    Route::prefix('faktur')->name('faktur.')->group(function() {
        Route::prefix('konsinyasi')->name('konsinyasi.')->group(function() {
            /* Dashboard Section */
            Route::get('create',[AdminKonsinyasiController::class, 'showCreateForm'])->name('showCreateForm');
            Route::post('create',[AdminKonsinyasiController::class, 'create'])->name('create');
            Route::get('edit/{id}',[AdminKonsinyasiController::class, 'showEditForm'])->name('showEditForm');
            Route::post('edit',[AdminKonsinyasiController::class, 'update'])->name('update');
            Route::get('list', [AdminKonsinyasiController::class, 'list'])->name('list');
            Route::post('delete',[AdminKonsinyasiController::class, 'delete'])->name('delete');
            Route::get('/cetak/{id}', [AdminKonsinyasiController::class, 'cetak'])->name('cetak-faktur');
            Route::get('sold/{id}',[AdminKonsinyasiController::class, 'showSoldForm'])->name('showSoldForm');
            Route::post('sold',[AdminKonsinyasiController::class, 'sold'])->name('sold');
            Route::get('not-sold/{id}',[AdminKonsinyasiController::class, 'notSold'])->name('not-sold');
        });
    });
});
