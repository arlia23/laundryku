<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PaketController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\PelangganController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KurirController;
use App\Http\Controllers\Admin\MesinController;
use App\Http\Controllers\Admin\PesananController;
use App\Http\Controllers\Admin\PengantaranController;
use App\Http\Controllers\Courier\PengantaranController as CourierPengantaranController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Customer\PesananController as CustomerPesananController;

// Halaman utama
Route::get('/', function () {
    return view('welcome');
});

// Login dan Register
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register']);
});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Pengarah dashboard berdasarkan role
Route::get('/dashboard', function () {
    $user = request()->user();

    return match ($user->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'customer' => redirect('/customer/dashboard'),
        'courier' => redirect('/courier/dashboard'),
        default => abort(403),
    };
})->middleware('auth')->name('dashboard');

// Dashboard Admin
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [
            DashboardController::class,
            'index'
        ])->name('dashboard');

            Route::resource('pelanggan', PelangganController::class);
            Route::resource('paket', PaketController::class);
            Route::resource('pesanan', PesananController::class);  
            
            Route::patch('/pesanan/{id}/cancel', [PesananController::class, 'cancel'])
    ->name('pesanan.cancel');

    Route::patch('/pesanan/{id}/status', [PesananController::class, 'updateStatus'])
    ->name('pesanan.updateStatus');

    Route::patch('/pesanan/{id}/payment', [PesananController::class, 'updatePayment'])
    ->name('pesanan.updatePayment');

    Route::resource('mesin', MesinController::class);

    Route::resource('kurir', KurirController::class);

    Route::resource('pengantaran', PengantaranController::class)
    ->only(['index', 'create', 'store','show']);

    Route::patch('/pesanan/{id}/penimbangan', [PesananController::class, 'updateWeighing'])
    ->name('pesanan.updateWeighing');

    Route::patch('/pengantaran/{id}/assign-courier', 
    [PengantaranController::class, 'assignCourier']
)->name('pengantaran.assignCourier');
});


// ROUTE CUSTOMER
Route::middleware(['auth', 'role:customer'])
    ->prefix('customer')
    ->name('customer.')
    ->group(function () {

        Route::get('/dashboard', [CustomerDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/paket', [PaketController::class, 'index'])
    ->name('paket.index');

    Route::get('/pesanan/buat', [CustomerPesananController::class, 'create'])
    ->name('pesanan.create');

Route::post('/pesanan', [CustomerPesananController::class, 'store'])
    ->name('pesanan.store');

    Route::get('/pesanan', [CustomerPesananController::class, 'index'])
    ->name('pesanan.index');

    Route::get('/pesanan/{id}', [CustomerPesananController::class, 'show'])
    ->name('pesanan.show');

    Route::post('/pesanan/{id}/bukti-pembayaran', [CustomerPesananController::class, 'uploadPaymentProof'])
    ->name('pesanan.payment-proof');

    Route::get('/riwayat-pesanan', [CustomerPesananController::class, 'riwayat'])
    ->name('riwayat.index');

    });

// Dashboard Kurir

Route::middleware(['auth', 'role:courier'])
    ->prefix('courier')
    ->name('courier.')
    ->group(function () {

        // DASHBOARD KURIR
        Route::get('/dashboard', function () {

            $kurirId = Auth::user()->getAuthIdentifier();

            $totalTugas = DB::table('deliveries')
                ->where('courier_id', $kurirId)
                ->count();

            $menungguPenjemputan = DB::table('deliveries')
                ->where('courier_id', $kurirId)
                ->where('pickup_status', 'pending')
                ->count();

            $menungguPengantaran = DB::table('deliveries')
                ->join('orders', 'deliveries.order_id', '=', 'orders.id')
                ->where('deliveries.courier_id', $kurirId)
                ->where('deliveries.pickup_status', 'picked_up')
                ->where('deliveries.delivery_status', 'pending')
                ->where('orders.status', 'ready')
                ->count();

            $tugasSelesai = DB::table('deliveries')
                ->where('courier_id', $kurirId)
                ->where('delivery_status', 'delivered')
                ->count();

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


        // HALAMAN PENGANTARAN
        Route::get('/pengantaran', [CourierPengantaranController::class, 'index'])
            ->name('pengantaran.index');


        // KONFIRMASI PENJEMPUTAN
        Route::patch('/pengantaran/{id}/pickup', [CourierPengantaranController::class, 'updatePickup'])
            ->name('pengantaran.pickup');


        // KONFIRMASI PENGANTARAN
        Route::patch('/pengantaran/{id}/delivery', [CourierPengantaranController::class, 'updateDelivery'])
            ->name('pengantaran.delivery');

    });


// DASHBOARD KURIR
Route::get('/dashboard', function () {

    $kurirId = Auth::id();

    // Total seluruh tugas kurir
    $totalTugas = DB::table('deliveries')
        ->where('courier_id', $kurirId)
        ->count();

    // Tugas yang menunggu penjemputan
    $menungguPenjemputan = DB::table('deliveries')
        ->where('courier_id', $kurirId)
        ->where('pickup_status', 'pending')
        ->count();

    // Tugas yang siap diantarkan
    $menungguPengantaran = DB::table('deliveries')
        ->join('orders', 'deliveries.order_id', '=', 'orders.id')
        ->where('deliveries.courier_id', $kurirId)
        ->where('deliveries.pickup_status', 'picked_up')
        ->where('deliveries.delivery_status', 'pending')
        ->where('orders.status', 'ready')
        ->count();

    // Tugas yang sudah selesai
    $tugasSelesai = DB::table('deliveries')
        ->where('courier_id', $kurirId)
        ->where('delivery_status', 'delivered')
        ->count();

    // Lima tugas terbaru
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