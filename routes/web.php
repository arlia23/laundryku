<?php

// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Admin\PaketController;
// use App\Http\Controllers\AuthController;
// use App\Http\Controllers\Admin\PelangganController;
// use App\Http\Controllers\Admin\DashboardController;
// use App\Http\Controllers\Admin\KurirController;
// use App\Http\Controllers\Admin\MesinController;
// use App\Http\Controllers\Admin\PesananController;
// use App\Http\Controllers\Admin\PengantaranController;
// use App\Http\Controllers\Courier\PengantaranController as CourierPengantaranController;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Auth;
// use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
// use App\Http\Controllers\Customer\PesananController as CustomerPesananController;

// // Halaman utama
// Route::get('/', function () {
//     return view('welcome');
// });

// // Login dan Register
// Route::middleware('guest')->group(function () {
//     Route::get('/login', [AuthController::class, 'showLogin'])
//         ->name('login');

//     Route::post('/login', [AuthController::class, 'login']);

//     Route::get('/register', [AuthController::class, 'showRegister'])
//         ->name('register');

//     Route::post('/register', [AuthController::class, 'register']);
// });

// // Logout
// Route::post('/logout', [AuthController::class, 'logout'])
//     ->middleware('auth')
//     ->name('logout');

// // Pengarah dashboard berdasarkan role
// Route::get('/dashboard', function () {
//     $user = request()->user();

//     return match ($user->role) {
//         'admin' => redirect()->route('admin.dashboard'),
//         'customer' => redirect('/customer/dashboard'),
//         'courier' => redirect('/courier/dashboard'),
//         default => abort(403),
//     };
// })->middleware('auth')->name('dashboard');

// // Dashboard Admin
// Route::middleware(['auth', 'role:admin'])
//     ->prefix('admin')
//     ->name('admin.')
//     ->group(function () {
//         Route::get('/dashboard', [
//             DashboardController::class,
//             'index'
//         ])->name('dashboard');

//             Route::resource('pelanggan', PelangganController::class);
//             Route::resource('paket', PaketController::class);
//             Route::resource('pesanan', PesananController::class);  
            
//             Route::patch('/pesanan/{id}/cancel', [PesananController::class, 'cancel'])
//     ->name('pesanan.cancel');

//     Route::patch('/pesanan/{id}/status', [PesananController::class, 'updateStatus'])
//     ->name('pesanan.updateStatus');

//     Route::patch('/pesanan/{id}/payment', [PesananController::class, 'updatePayment'])
//     ->name('pesanan.updatePayment');

//     Route::resource('mesin', MesinController::class);

//     Route::resource('kurir', KurirController::class);

//     Route::resource('pengantaran', PengantaranController::class)
//     ->only(['index', 'create', 'store','show']);

//     Route::patch('/pesanan/{id}/penimbangan', [PesananController::class, 'updateWeighing'])
//     ->name('pesanan.updateWeighing');

//     Route::patch('/pengantaran/{id}/assign-courier', 
//     [PengantaranController::class, 'assignCourier']
// )->name('pengantaran.assignCourier');
// });


// // ROUTE CUSTOMER
// Route::middleware(['auth', 'role:customer'])
//     ->prefix('customer')
//     ->name('customer.')
//     ->group(function () {

//         Route::get('/dashboard', [CustomerDashboardController::class, 'index'])
//             ->name('dashboard');

//         Route::get('/paket', [PaketController::class, 'index'])
//     ->name('paket.index');

//     Route::get('/pesanan/buat', [CustomerPesananController::class, 'create'])
//     ->name('pesanan.create');

// Route::post('/pesanan', [CustomerPesananController::class, 'store'])
//     ->name('pesanan.store');

//     Route::get('/pesanan', [CustomerPesananController::class, 'index'])
//     ->name('pesanan.index');

//     Route::get('/pesanan/{id}', [CustomerPesananController::class, 'show'])
//     ->name('pesanan.show');

//     Route::post('/pesanan/{id}/bukti-pembayaran', [CustomerPesananController::class, 'uploadPaymentProof'])
//     ->name('pesanan.payment-proof');

//     Route::get('/riwayat-pesanan', [CustomerPesananController::class, 'riwayat'])
//     ->name('riwayat.index');

//     });

// // Dashboard Kurir

// Route::middleware(['auth', 'role:courier'])
//     ->prefix('courier')
//     ->name('courier.')
//     ->group(function () {

//         // DASHBOARD KURIR
//         Route::get('/dashboard', function () {

//             $kurirId = Auth::user()->getAuthIdentifier();

//             $totalTugas = DB::table('deliveries')
//                 ->where('courier_id', $kurirId)
//                 ->count();

//             $menungguPenjemputan = DB::table('deliveries')
//                 ->where('courier_id', $kurirId)
//                 ->where('pickup_status', 'pending')
//                 ->count();

//             $menungguPengantaran = DB::table('deliveries')
//                 ->join('orders', 'deliveries.order_id', '=', 'orders.id')
//                 ->where('deliveries.courier_id', $kurirId)
//                 ->where('deliveries.pickup_status', 'picked_up')
//                 ->where('deliveries.delivery_status', 'pending')
//                 ->where('orders.status', 'ready')
//                 ->count();

//             $tugasSelesai = DB::table('deliveries')
//                 ->where('courier_id', $kurirId)
//                 ->where('delivery_status', 'delivered')
//                 ->count();

//             $tugasTerbaru = DB::table('deliveries')
//     ->join('orders', 'deliveries.order_id', '=', 'orders.id')
//     ->join('users as pelanggan', 'orders.customer_id', '=', 'pelanggan.id')
//     ->where('deliveries.courier_id', $kurirId)
//     ->select(
//         'deliveries.*',
//         'orders.order_code',
//         'orders.order_date',
//         'orders.status as status_pesanan',
//         'orders.total_price',
//         'pelanggan.name as nama_pelanggan',
//         'pelanggan.phone as telepon_pelanggan'
//     )
//     ->orderByDesc('deliveries.created_at')
//     ->limit(5)
//     ->get();

//             return view('courier.dashboard', compact(
//                 'totalTugas',
//                 'menungguPenjemputan',
//                 'menungguPengantaran',
//                 'tugasSelesai',
//                 'tugasTerbaru'
//             ));

//         })->name('dashboard');


//         // HALAMAN PENGANTARAN
//         Route::get('/pengantaran', [CourierPengantaranController::class, 'index'])
//             ->name('pengantaran.index');


//         // KONFIRMASI PENJEMPUTAN
//         Route::patch('/pengantaran/{id}/pickup', [CourierPengantaranController::class, 'updatePickup'])
//             ->name('pengantaran.pickup');


//         // KONFIRMASI PENGANTARAN
//         Route::patch('/pengantaran/{id}/delivery', [CourierPengantaranController::class, 'updateDelivery'])
//             ->name('pengantaran.delivery');

//     });


// // DASHBOARD KURIR
// Route::get('/dashboard', function () {

//     $kurirId = Auth::id();

//     // Total seluruh tugas kurir
//     $totalTugas = DB::table('deliveries')
//         ->where('courier_id', $kurirId)
//         ->count();

//     // Tugas yang menunggu penjemputan
//     $menungguPenjemputan = DB::table('deliveries')
//         ->where('courier_id', $kurirId)
//         ->where('pickup_status', 'pending')
//         ->count();

//     // Tugas yang siap diantarkan
//     $menungguPengantaran = DB::table('deliveries')
//         ->join('orders', 'deliveries.order_id', '=', 'orders.id')
//         ->where('deliveries.courier_id', $kurirId)
//         ->where('deliveries.pickup_status', 'picked_up')
//         ->where('deliveries.delivery_status', 'pending')
//         ->where('orders.status', 'ready')
//         ->count();

//     // Tugas yang sudah selesai
//     $tugasSelesai = DB::table('deliveries')
//         ->where('courier_id', $kurirId)
//         ->where('delivery_status', 'delivered')
//         ->count();

//     // Lima tugas terbaru
//    $tugasTerbaru = DB::table('deliveries')
//     ->join('orders', 'deliveries.order_id', '=', 'orders.id')
//     ->join('users as pelanggan', 'orders.customer_id', '=', 'pelanggan.id')
//     ->where('deliveries.courier_id', $kurirId)
//     ->select(
//         'deliveries.*',
//         'orders.order_code',
//         'orders.order_date',
//         'orders.status as status_pesanan',
//         'orders.total_price',
//         'pelanggan.name as nama_pelanggan',
//         'pelanggan.phone as telepon_pelanggan'
//     )
//     ->orderByDesc('deliveries.created_at')
//     ->limit(5)
//     ->get();

//     return view('courier.dashboard', compact(
//         'totalTugas',
//         'menungguPenjemputan',
//         'menungguPengantaran',
//         'tugasSelesai',
//         'tugasTerbaru'
//     ));

// })->name('dashboard');


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AuthController;

use App\Http\Controllers\Admin\PaketController;
use App\Http\Controllers\Admin\PelangganController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KurirController;
use App\Http\Controllers\Admin\MesinController;
use App\Http\Controllers\Admin\PesananController;
use App\Http\Controllers\Admin\PengantaranController;

use App\Http\Controllers\Courier\PengantaranController as CourierPengantaranController;

use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Customer\PesananController as CustomerPesananController;


// ==================================================
// HALAMAN UTAMA
// ==================================================

Route::get('/', function () {
    return view('welcome');
});


// ==================================================
// LOGIN DAN REGISTER
// ==================================================

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register']);

});


// ==================================================
// LOGOUT
// ==================================================

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


// ==================================================
// PENGARAH DASHBOARD BERDASARKAN ROLE
// ==================================================

Route::get('/dashboard', function () {

    $user = Auth::user();

    return match ($user->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'customer' => redirect()->route('customer.dashboard'),
        'courier' => redirect()->route('courier.dashboard'),
        default => abort(403),
    };

})->middleware('auth')->name('dashboard');


// ==================================================
// ROUTE ADMIN
// ==================================================

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard Admin
        Route::get('/dashboard', [
            DashboardController::class,
            'index'
        ])->name('dashboard');


        // Data Pelanggan
        Route::resource('pelanggan', PelangganController::class);


        // Data Paket
        Route::resource('paket', PaketController::class);


        // Data Pesanan
        Route::resource('pesanan', PesananController::class);

        // Batalkan Pesanan
        Route::patch('/pesanan/{id}/cancel', [
            PesananController::class,
            'cancel'
        ])->name('pesanan.cancel');

        // Update Status Pesanan
        Route::patch('/pesanan/{id}/status', [
            PesananController::class,
            'updateStatus'
        ])->name('pesanan.updateStatus');

        // Update Pembayaran
        Route::patch('/pesanan/{id}/payment', [
            PesananController::class,
            'updatePayment'
        ])->name('pesanan.updatePayment');

        // Update Penimbangan
        Route::patch('/pesanan/{id}/penimbangan', [
            PesananController::class,
            'updateWeighing'
        ])->name('pesanan.updateWeighing');


        // Data Mesin
        Route::resource('mesin', MesinController::class);


        // Data Kurir
        Route::resource('kurir', KurirController::class);


        // Data Pengantaran
        Route::resource('pengantaran', PengantaranController::class)
            ->only(['index', 'create', 'store', 'show']);

        // Assign Kurir
        Route::patch('/pengantaran/{id}/assign-courier', [
            PengantaranController::class,
            'assignCourier'
        ])->name('pengantaran.assignCourier');

    });


// ==================================================
// ROUTE CUSTOMER
// ==================================================

Route::middleware(['auth', 'role:customer'])
    ->prefix('customer')
    ->name('customer.')
    ->group(function () {

        // Dashboard Customer
        Route::get('/dashboard', [
            CustomerDashboardController::class,
            'index'
        ])->name('dashboard');


        // Paket Laundry
        Route::get('/paket', [
            PaketController::class,
            'index'
        ])->name('paket.index');


        // Buat Pesanan
        Route::get('/pesanan/buat', [
            CustomerPesananController::class,
            'create'
        ])->name('pesanan.create');

        // Simpan Pesanan
        Route::post('/pesanan', [
            CustomerPesananController::class,
            'store'
        ])->name('pesanan.store');


        // Pesanan Saya
        Route::get('/pesanan', [
            CustomerPesananController::class,
            'index'
        ])->name('pesanan.index');

        // Detail Pesanan
        Route::get('/pesanan/{id}', [
            CustomerPesananController::class,
            'show'
        ])->name('pesanan.show');

        // Upload Bukti Pembayaran
        Route::post('/pesanan/{id}/bukti-pembayaran', [
            CustomerPesananController::class,
            'uploadPaymentProof'
        ])->name('pesanan.payment-proof');


        // Riwayat Pesanan
        Route::get('/riwayat-pesanan', [
            CustomerPesananController::class,
            'riwayat'
        ])->name('riwayat.index');

    });


// ==================================================
// ROUTE COURIER
// ==================================================

Route::middleware(['auth', 'role:courier'])
    ->prefix('courier')
    ->name('courier.')
    ->group(function () {

        // Dashboard Kurir
        Route::get('/dashboard', function () {

            $kurirId = Auth::id();

            // Total Tugas
            $totalTugas = DB::table('deliveries')
                ->where('courier_id', $kurirId)
                ->count();

            // Menunggu Penjemputan
            $menungguPenjemputan = DB::table('deliveries')
                ->where('courier_id', $kurirId)
                ->where('pickup_status', 'pending')
                ->count();

            // Menunggu Pengantaran
            $menungguPengantaran = DB::table('deliveries')
                ->join('orders', 'deliveries.order_id', '=', 'orders.id')
                ->where('deliveries.courier_id', $kurirId)
                ->where('deliveries.pickup_status', 'picked_up')
                ->where('deliveries.delivery_status', 'pending')
                ->where('orders.status', 'ready')
                ->count();

            // Tugas Selesai
            $tugasSelesai = DB::table('deliveries')
                ->where('courier_id', $kurirId)
                ->where('delivery_status', 'delivered')
                ->count();

            // Lima Tugas Terbaru
            $tugasTerbaru = DB::table('deliveries')
                ->join('orders', 'deliveries.order_id', '=', 'orders.id')
                ->join('users as pelanggan', 'orders.customer_id', '=', 'pelanggan.id')
                ->where('deliveries.courier_id', $kurirId)
                ->select(
                    'deliveries.*',
                    'orders.order_code',
                    'orders.order_date',
                    'orders.status as status_pesanan',
                    'orders.total_price',
                    'pelanggan.name as nama_pelanggan',
                    'pelanggan.phone as telepon_pelanggan'
                )
                ->orderByDesc('deliveries.created_at')
                ->limit(5)
                ->get();

            return view('courier.dashboard', compact(
                'totalTugas',
                'menungguPenjemputan',
                'menungguPengantaran',
                'tugasSelesai',
                'tugasTerbaru'
            ));

        })->name('dashboard');


        // Halaman Pengantaran
        Route::get('/pengantaran', [
            CourierPengantaranController::class,
            'index'
        ])->name('pengantaran.index');


        // Konfirmasi Penjemputan
        Route::patch('/pengantaran/{id}/pickup', [
            CourierPengantaranController::class,
            'updatePickup'
        ])->name('pengantaran.pickup');


        // Konfirmasi Pengantaran
        Route::patch('/pengantaran/{id}/delivery', [
            CourierPengantaranController::class,
            'updateDelivery'
        ])->name('pengantaran.delivery');

    });
