<?php

namespace App\Http\Controllers\Courier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PengantaranController extends Controller
{
    // Menampilkan tugas pengantaran milik kurir
    public function index(Request $request)
    {
        $kurirId = Auth::id();

        // Ringkasan seluruh tugas
        $ringkasan = DB::table('deliveries')
            ->where('courier_id', $kurirId)
            ->selectRaw("
                COUNT(*) as total_tugas,
                COALESCE(SUM(CASE WHEN pickup_status = 'pending' THEN 1 ELSE 0 END), 0) as menunggu_penjemputan,
                COALESCE(SUM(CASE WHEN delivery_status = 'delivered' THEN 1 ELSE 0 END), 0) as tugas_selesai
            ")
            ->first();

        // Query utama tugas kurir
        $query = DB::table('deliveries')
            ->join('orders', 'deliveries.order_id', '=', 'orders.id')
            ->join('users as pelanggan', 'orders.customer_id', '=', 'pelanggan.id')
            ->where('deliveries.courier_id', $kurirId)
            ->select(
                'deliveries.*',
                'orders.order_code',
                'orders.order_date',
                'orders.total_price',
                'orders.status as status_pesanan',
                'orders.payment_status',
                'pelanggan.name as nama_pelanggan',
                'pelanggan.phone as telepon_pelanggan'
            );

        // Pencarian kode pesanan atau nama pelanggan
        if ($request->filled('search')) {
            $keyword = $request->search;

            $query->where(function ($q) use ($keyword) {
                $q->where('orders.order_code', 'like', "%{$keyword}%")
                  ->orWhere('pelanggan.name', 'like', "%{$keyword}%");
            });
        }

        // Filter status tugas
        if ($request->filled('status')) {
            switch ($request->status) {

                case 'pickup':
                    $query->where('deliveries.pickup_status', 'pending');
                    break;

                case 'processing':
                    $query->where('deliveries.pickup_status', 'picked_up')
                          ->where('orders.status', 'processing')
                          ->where('deliveries.delivery_status', 'pending');
                    break;

                case 'ready':
                    $query->where('deliveries.pickup_status', 'picked_up')
                          ->where('orders.status', 'ready')
                          ->where('deliveries.delivery_status', 'pending');
                    break;

                case 'completed':
                    $query->where('deliveries.delivery_status', 'delivered');
                    break;
            }
        }

        // Filter tanggal pesanan
        if ($request->filled('tanggal')) {
            $query->whereDate('orders.order_date', $request->tanggal);
        }

        // Ambil data dengan pagination
        $pengantaran = $query
            ->orderByDesc('deliveries.created_at')
            ->paginate(10)
            ->withQueryString();

        return view('courier.pengantaran.index', compact(
            'pengantaran',
            'ringkasan'
        ));
    }

    // Konfirmasi penjemputan
    public function updatePickup(string $id)
    {
        $item = DB::table('deliveries')
            ->where('id', $id)
            ->where('courier_id', Auth::id())
            ->first();

        if (!$item) {
            abort(404);
        }

        if ($item->pickup_status !== 'pending') {
            return back()->with('error', 'Penjemputan sudah diproses.');
        }

        DB::table('deliveries')
            ->where('id', $id)
            ->update([
                'pickup_status' => 'picked_up',
                'updated_at' => now(),
            ]);

        return back()->with(
            'success',
            'Status penjemputan berhasil diperbarui.'
        );
    }

    // Konfirmasi pengantaran
    public function updateDelivery(string $id)
    {
        $item = DB::table('deliveries')
            ->join('orders', 'deliveries.order_id', '=', 'orders.id')
            ->where('deliveries.id', $id)
            ->where('deliveries.courier_id', Auth::id())
            ->select(
                'deliveries.*',
                'orders.status as status_pesanan'
            )
            ->first();

        if (!$item) {
            abort(404);
        }

        if ($item->pickup_status !== 'picked_up') {
            return back()->with(
                'error',
                'Pakaian harus dijemput terlebih dahulu.'
            );
        }

        if ($item->status_pesanan !== 'ready') {
            return back()->with(
                'error',
                'Pesanan belum siap untuk diantarkan.'
            );
        }

        if ($item->delivery_status !== 'pending') {
            return back()->with(
                'error',
                'Pengantaran sudah diproses.'
            );
        }

        DB::transaction(function () use ($item, $id) {
            DB::table('deliveries')
                ->where('id', $id)
                ->update([
                    'delivery_status' => 'delivered',
                    'updated_at' => now(),
                ]);

            DB::table('orders')
                ->where('id', $item->order_id)
                ->update([
                    'status' => 'completed',
                    'updated_at' => now(),
                ]);
        });

        return back()->with(
            'success',
            'Pesanan berhasil diantarkan dan diselesaikan.'
        );
    }
}


// namespace App\Http\Controllers\Courier;

// use App\Http\Controllers\Controller;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\DB;

// class PengantaranController extends Controller
// {
//     // Menampilkan tugas pengantaran milik kurir yang sedang login
//     public function index()
//     {
//         $kurirId = Auth::id();

//         // Menghitung ringkasan seluruh tugas kurir
//         $ringkasan = DB::table('deliveries')
//             ->where('courier_id', $kurirId)
//             ->selectRaw("
//                 COUNT(*) as total_tugas,
//                 SUM(CASE WHEN pickup_status = 'pending' THEN 1 ELSE 0 END) as menunggu_penjemputan,
//                 SUM(CASE WHEN delivery_status = 'delivered' THEN 1 ELSE 0 END) as tugas_selesai
//             ")
//             ->first();

//         // Mengambil daftar tugas dengan pagination
//         $pengantaran = DB::table('deliveries')
//             ->join('orders', 'deliveries.order_id', '=', 'orders.id')
//             ->join('users as pelanggan', 'orders.customer_id', '=', 'pelanggan.id')
//             ->where('deliveries.courier_id', $kurirId)
//             ->select(
//                 'deliveries.*',
//                 'orders.order_code',
//                 'orders.order_date',
//                 'orders.total_price',
//                 'orders.status as status_pesanan',
//                 'pelanggan.name as nama_pelanggan',
//                 'pelanggan.phone as telepon_pelanggan'
//             )
//             ->orderByDesc('deliveries.created_at')
//             ->paginate(10);

//         return view('courier.pengantaran.index', compact(
//             'pengantaran',
//             'ringkasan'
//         ));
//     }

//     // Kurir mengonfirmasi pakaian sudah dijemput
//     public function updatePickup(string $id)
//     {
//         $item = DB::table('deliveries')
//             ->where('id', $id)
//             ->where('courier_id', Auth::id())
//             ->first();

//         if (!$item) {
//             abort(404);
//         }

//         if ($item->pickup_status !== 'pending') {
//             return back()->with('error', 'Penjemputan sudah diproses.');
//         }

//         DB::table('deliveries')
//             ->where('id', $id)
//             ->update([
//                 'pickup_status' => 'picked_up',
//                 'updated_at' => now(),
//             ]);

//         return back()->with(
//             'success',
//             'Status penjemputan berhasil diperbarui.'
//         );
//     }

//     // Kurir mengonfirmasi pakaian sudah dikembalikan kepada pelanggan
//     public function updateDelivery(string $id)
//     {
//         $item = DB::table('deliveries')
//             ->join('orders', 'deliveries.order_id', '=', 'orders.id')
//             ->where('deliveries.id', $id)
//             ->where('deliveries.courier_id', Auth::id())
//             ->select(
//                 'deliveries.*',
//                 'orders.status as status_pesanan'
//             )
//             ->first();

//         if (!$item) {
//             abort(404);
//         }

//         if ($item->pickup_status !== 'picked_up') {
//             return back()->with(
//                 'error',
//                 'Pakaian harus dijemput terlebih dahulu.'
//             );
//         }

//         if ($item->status_pesanan !== 'ready') {
//             return back()->with(
//                 'error',
//                 'Pesanan belum siap untuk diantarkan.'
//             );
//         }

//         if ($item->delivery_status !== 'pending') {
//             return back()->with(
//                 'error',
//                 'Pengantaran sudah diproses.'
//             );
//         }

//         DB::transaction(function () use ($item, $id) {
//             DB::table('deliveries')
//                 ->where('id', $id)
//                 ->update([
//                     'delivery_status' => 'delivered',
//                     'updated_at' => now(),
//                 ]);

//             DB::table('orders')
//                 ->where('id', $item->order_id)
//                 ->update([
//                     'status' => 'completed',
//                     'updated_at' => now(),
//                 ]);
//         });

//         return back()->with(
//             'success',
//             'Pesanan berhasil diantarkan dan diselesaikan.'
//         );
//     }
// }
