<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik umum
        $stats = [
            'customers' => DB::table('users')
                ->where('role', 'customer')
                ->count(),

            'couriers' => DB::table('users')
                ->where('role', 'courier')
                ->count(),

            'orders' => DB::table('orders')->count(),

            'machines' => DB::table('machines')->count(),

            'packages' => DB::table('packages')->count(),

            // Total nilai pesanan yang tidak dibatalkan
            'total_order_value' => DB::table('orders')
                ->where('status', '!=', 'cancelled')
                ->sum('total_price'),

            // Total pendapatan dari pesanan yang sudah lunas
            'paid_income' => DB::table('orders')
                ->where('status', '!=', 'cancelled')
                ->where('payment_status', 'paid')
                ->sum('total_price'),

            // Total tagihan yang belum dibayar
            'unpaid_total' => DB::table('orders')
                ->where('status', '!=', 'cancelled')
                ->where('payment_status', 'unpaid')
                ->sum('total_price'),

            // Jumlah pesanan yang sudah lunas
            'paid_orders' => DB::table('orders')
                ->where('status', '!=', 'cancelled')
                ->where('payment_status', 'paid')
                ->count(),

            // Jumlah pesanan yang belum dibayar
            'unpaid_orders' => DB::table('orders')
                ->where('status', '!=', 'cancelled')
                ->where('payment_status', 'unpaid')
                ->count(),
        ];

        // 5 pesanan terbaru beserta nama pelanggan
        $latestOrders = DB::table('orders')
            ->join('users', 'orders.customer_id', '=', 'users.id')
            ->select(
                'orders.*',
                'users.name as nama_pelanggan'
            )
            ->orderByDesc('orders.created_at')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'latestOrders'
        ));
    }
}


// namespace App\Http\Controllers\Admin;

// use App\Http\Controllers\Controller;
// use Illuminate\Support\Facades\DB;

// class DashboardController extends Controller
// {
//     public function index()
//     {
//         // Statistik dari database MySQL
//         $stats = [
//             'customers' => DB::table('users')
//                 ->where('role', 'customer')
//                 ->count(),

//             'couriers' => DB::table('users')
//                 ->where('role', 'courier')
//                 ->count(),

//             'orders' => DB::table('orders')->count(),

//             'machines' => DB::table('machines')->count(),

//             'packages' => DB::table('packages')->count(),

//             'total_order_value' => DB::table('orders')
//                 ->sum('total_price'),
//         ];

//         // 5 pesanan terbaru
//         $latestOrders = DB::table('orders')
//             ->orderByDesc('order_date')
//             ->limit(5)
//             ->get();

//         return view('admin.dashboard', compact(
//             'stats',
//             'latestOrders'
//         ));
//     }
// }


