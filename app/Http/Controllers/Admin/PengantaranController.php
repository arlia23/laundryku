<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengantaranController extends Controller
{
    public function index()
    {
        $pengantaran = DB::table('deliveries')
            ->join('orders', 'deliveries.order_id', '=', 'orders.id')
            ->join('users as pelanggan', 'orders.customer_id', '=', 'pelanggan.id')
            ->leftJoin('users as kurir', 'deliveries.courier_id', '=', 'kurir.id')
            ->select(
                'deliveries.*',
                'orders.order_code',
                'orders.order_date',
                'orders.total_price',
                'orders.status as status_pesanan',
                'pelanggan.name as nama_pelanggan',
                'kurir.name as nama_kurir'
            )
            ->orderByDesc('deliveries.created_at')
            ->paginate(10);

        return view('admin.pengantaran.index', compact('pengantaran'));
    }
    public function create()
{
    // Pesanan layanan antar yang belum memiliki data pengantaran
    $pesanan = DB::table('orders')
        ->join('users', 'orders.customer_id', '=', 'users.id')
        ->join('order_details', 'orders.id', '=', 'order_details.order_id')
        ->join('packages', 'order_details.package_id', '=', 'packages.id')
        ->where('packages.name', 'Cuci Setrika Antar')
        ->where('orders.status', '!=', 'cancelled')
        ->whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('deliveries')
                ->whereColumn('deliveries.order_id', 'orders.id');
        })
                ->select(
            'orders.id',
            'orders.order_code',
            'users.name as nama_pelanggan',
            'users.address as alamat_pelanggan',
            'orders.created_at'
        )
        ->distinct()
        ->orderByDesc('orders.created_at')
        ->get();

    $kurir = DB::table('users')
        ->where('role', 'courier')
        ->orderBy('name')
        ->get();

    return view('admin.pengantaran.create', compact('pesanan', 'kurir'));
}

public function store(Request $request)
{
    $request->validate([
        'order_id' => 'required|exists:orders,id',
        'courier_id' => 'required|exists:users,id',
        'pickup_address' => 'required|string',
        'delivery_address' => 'required|string',
    ]);

    // Pastikan pesanan memang menggunakan layanan antar
    $pesananValid = DB::table('orders')
        ->join('order_details', 'orders.id', '=', 'order_details.order_id')
        ->join('packages', 'order_details.package_id', '=', 'packages.id')
        ->where('orders.id', $request->order_id)
        ->where('orders.status', '!=', 'cancelled')
        ->where('packages.name', 'Cuci Setrika Antar')
        ->exists();

    if (!$pesananValid) {
        return back()->withInput()
            ->with('error', 'Pesanan tidak menggunakan layanan antar.');
    }

    // Pastikan pengguna yang dipilih benar-benar kurir
    $kurirValid = DB::table('users')
        ->where('id', $request->courier_id)
        ->where('role', 'courier')
        ->exists();

    if (!$kurirValid) {
        return back()->withInput()
            ->with('error', 'Kurir yang dipilih tidak valid.');
    }

    // Cegah satu pesanan dibuatkan pengantaran lebih dari sekali
    $sudahAda = DB::table('deliveries')
        ->where('order_id', $request->order_id)
        ->exists();

    if ($sudahAda) {
        return back()->withInput()
            ->with('error', 'Pesanan ini sudah memiliki data pengantaran.');
    }

    DB::table('deliveries')->insert([
        'order_id' => $request->order_id,
        'courier_id' => $request->courier_id,
        'pickup_address' => $request->pickup_address,
        'delivery_address' => $request->delivery_address,
        'pickup_status' => 'pending',
        'delivery_status' => 'pending',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()
        ->route('admin.pengantaran.index')
        ->with('success', 'Data pengantaran berhasil ditambahkan dan kurir berhasil ditugaskan.');
}


public function assignCourier(Request $request, string $id)
{
    $validated = $request->validate([
        'courier_id' => 'required|exists:users,id',
    ]);

    $pengantaran = DB::table('deliveries')
        ->join('orders', 'deliveries.order_id', '=', 'orders.id')
        ->where('deliveries.id', $id)
        ->select(
            'deliveries.*',
            'orders.status as status_pesanan'
        )
        ->first();

    abort_if(!$pengantaran, 404);

    if ($pengantaran->status_pesanan === 'cancelled') {
        return back()->with('error', 'Pesanan sudah dibatalkan.');
    }

    if (
        $pengantaran->pickup_status === 'picked_up' ||
        $pengantaran->delivery_status === 'delivered'
    ) {
        return back()->with('error', 'Kurir tidak dapat diganti karena tugas sudah berjalan.');
    }

    $kurirValid = DB::table('users')
        ->where('id', $validated['courier_id'])
        ->where('role', 'courier')
        ->exists();

    if (!$kurirValid) {
        return back()->with('error', 'Kurir yang dipilih tidak valid.');
    }

    DB::table('deliveries')
        ->where('id', $id)
        ->update([
            'courier_id' => $validated['courier_id'],
            'updated_at' => now(),
        ]);

    return back()->with('success', 'Kurir berhasil ditugaskan.');
}


   public function show(string $id)
{
    $item = DB::table('deliveries')
        ->join('orders', 'deliveries.order_id', '=', 'orders.id')
        ->join('users as pelanggan', 'orders.customer_id', '=', 'pelanggan.id')
        ->leftJoin('users as kurir', 'deliveries.courier_id', '=', 'kurir.id')
        ->where('deliveries.id', $id)
        ->select(
            'deliveries.*',
            'orders.order_code',
            'orders.order_date',
            'orders.total_price',
            'orders.status as status_pesanan',
            'orders.payment_status',
            'pelanggan.name as nama_pelanggan',
            'pelanggan.email as email_pelanggan',
            'pelanggan.phone as telepon_pelanggan',
            'kurir.name as nama_kurir',
            'kurir.phone as telepon_kurir'
        )
        ->first();

    if (!$item) {
        abort(404);
    }

    $kurir = DB::table('users')
    ->where('role', 'courier')
    ->orderBy('name')
    ->get();

return view('admin.pengantaran.show', compact('item', 'kurir'));
}
}