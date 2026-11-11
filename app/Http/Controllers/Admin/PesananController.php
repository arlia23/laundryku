<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PesananController extends Controller
{
    // Menampilkan daftar pesanan
    // Menampilkan daftar pesanan dengan filter dan pencarian
public function index(Request $request)
{
    $query = DB::table('orders')
        ->join('users', 'orders.customer_id', '=', 'users.id')
        ->select('orders.*', 'users.name as nama_pelanggan');

    // Pencarian kode pesanan, nama pelanggan, atau email
    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('orders.order_code', 'like', "%{$search}%")
                ->orWhere('users.name', 'like', "%{$search}%")
                ->orWhere('users.email', 'like', "%{$search}%");
        });
    }

    // Filter status pesanan
    if ($request->filled('status')) {
        $query->where('orders.status', $request->status);
    }

    // Filter status pembayaran
    if ($request->filled('payment_status')) {
        $query->where('orders.payment_status', $request->payment_status);
    }

    // Filter tanggal pesanan
    if ($request->filled('order_date')) {
        $query->whereDate('orders.order_date', $request->order_date);
    }

    $pesanan = $query
        ->orderByDesc('orders.created_at')
        ->paginate(10)
        ->withQueryString();

    return view('admin.pesanan.index', compact('pesanan'));
}

    // Menampilkan form tambah pesanan
    public function create()
    {
        $pelanggan = DB::table('users')
            ->where('role', 'customer')
            ->orderBy('name')
            ->get();

        $paket = DB::table('packages')
            ->orderBy('name')
            ->get();

        return view('admin.pesanan.create', compact('pelanggan', 'paket'));
    }

    // Membatalkan pesanan
public function cancel(string $id)
{
    $pesanan = DB::table('orders')
        ->where('id', $id)
        ->first();

    abort_if(!$pesanan, 404);

    if ($pesanan->status === 'cancelled') {
        return back()->with('error', 'Pesanan sudah dibatalkan.');
    }

    DB::table('orders')
        ->where('id', $id)
        ->update([
            'status' => 'cancelled',
            'updated_at' => now(),
        ]);

    return redirect()
        ->route('admin.pesanan.index')
        ->with('success', 'Pesanan berhasil dibatalkan.');
    }

    // Menampilkan detail pesanan
public function show(string $id)
{
    $pesanan = DB::table('orders')
        ->join('users', 'orders.customer_id', '=', 'users.id')
        ->where('orders.id', $id)
        ->select(
            'orders.*',
            'users.name as nama_pelanggan',
            'users.email as email_pelanggan',
            'users.phone as telepon_pelanggan',
            'users.address as alamat_pelanggan'
        )
        ->first();

    abort_if(!$pesanan, 404);

    $detail = DB::table('order_details')
        ->join('packages', 'order_details.package_id', '=', 'packages.id')
        ->where('order_details.order_id', $id)
        ->select(
            'order_details.*',
            'packages.name as nama_paket'
        )
        ->get();

    return view('admin.pesanan.show', compact('pesanan', 'detail'));
}

    // Menyimpan pesanan baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => [
                'required',
                Rule::exists('users', 'id')->where('role', 'customer'),
            ],
            'package_id' => 'required|exists:packages,id',
            'quantity' => 'required|integer|min:1',
            'order_date' => 'required|date',
        ]);

        // Ambil harga paket dari database
        $paket = DB::table('packages')
            ->where('id', $validated['package_id'])
            ->first();

        $harga = $paket->price;
        $berat = $validated['quantity'];
        $subtotal = $harga * $berat;

        DB::transaction(function () use (
            $validated,
            $harga,
            $berat,
            $subtotal
        ) {
            // Membuat kode pesanan otomatis
            do {
                $kodePesanan = 'ORD-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5));
            } while (
                DB::table('orders')
                    ->where('order_code', $kodePesanan)
                    ->exists()
            );

            // Simpan data pesanan
            $orderId = DB::table('orders')->insertGetId([
                'order_code' => $kodePesanan,
                'customer_id' => $validated['customer_id'],
                'machine_id' => null,
                'order_date' => $validated['order_date'],
                'total_price' => $subtotal,
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Simpan detail pesanan
            DB::table('order_details')->insert([
                'order_id' => $orderId,
                'package_id' => $validated['package_id'],
                'quantity' => $berat,
                'price' => $harga,
                'subtotal' => $subtotal,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            
        });

        return redirect()
            ->route('admin.pesanan.index')
            ->with('success', 'Pesanan berhasil ditambahkan!');
    }

    // Mengubah status pesanan

// Mengubah status pembayaran
public function updatePayment(Request $request, string $id)
{
    $validated = $request->validate([
        'payment_status' => 'required|in:unpaid,paid',
    ]);

    $pesanan = DB::table('orders')
        ->where('id', $id)
        ->first();

    abort_if(!$pesanan, 404);

    if ($pesanan->status === 'cancelled') {
        return back()->with('error', 'Pesanan yang dibatalkan tidak dapat diproses pembayarannya.');
    }

    DB::table('orders')
        ->where('id', $id)
        ->update([
            'payment_status' => $validated['payment_status'],
            'updated_at' => now(),
        ]);

    return back()->with('success', 'Status pembayaran berhasil diperbarui.');
}


// Mengubah status pesanan
public function updateStatus(Request $request, string $id)
{
    $validated = $request->validate([
        'status' => 'required|in:pending,confirmed,processing,ready,completed,cancelled',
    ]);

    $pesanan = DB::table('orders')
        ->where('id', $id)
        ->first();

    abort_if(!$pesanan, 404);

    if ($pesanan->status === 'cancelled') {
        return back()->with('error', 'Pesanan yang sudah dibatalkan tidak dapat diubah lagi.');
    }

    // Cek apakah pakaian sudah ditimbang
    if (
        in_array($validated['status'], ['processing', 'ready', 'completed'])
        && $pesanan->total_price <= 0
    ) {
        return back()->with(
            'error',
            'Silakan timbang pakaian dan tentukan harga terlebih dahulu.'
        );
    }

    // Cek apakah pesanan menggunakan paket Cuci Setrika Antar
    $paketAntar = DB::table('order_details')
        ->join('packages', 'order_details.package_id', '=', 'packages.id')
        ->where('order_details.order_id', $id)
        ->where('packages.name', 'Cuci Setrika Antar')
        ->exists();

    // Paket antar wajib lunas sebelum diproses
    if (
        $paketAntar &&
        in_array($validated['status'], ['processing', 'ready', 'completed']) &&
        $pesanan->payment_status !== 'paid'
    ) {
        return back()->with(
            'error',
            'Pesanan Cuci Setrika Antar wajib dibayar terlebih dahulu sebelum pakaian diproses.'
        );
    }

    DB::table('orders')
        ->where('id', $id)
        ->update([
            'status' => $validated['status'],
            'updated_at' => now(),
        ]);

    return back()->with('success', 'Status pesanan berhasil diperbarui.');
}


// Menyimpan hasil penimbangan pakaian oleh Admin
public function updateWeighing(Request $request, string $id)
{
    $validated = $request->validate([
        'quantity' => 'required|integer|min:1|max:1000',
    ]);

    $pesanan = DB::table('orders')
        ->where('id', $id)
        ->first();

    abort_if(!$pesanan, 404);

    if ($pesanan->status === 'cancelled') {
        return back()->with('error', 'Pesanan yang dibatalkan tidak dapat ditimbang.');
    }

    if ($pesanan->payment_status === 'paid') {
        return back()->with('error', 'Berat tidak dapat diubah karena pesanan sudah dibayar.');
    }

    $detail = DB::table('order_details')
        ->join('packages', 'order_details.package_id', '=', 'packages.id')
        ->where('order_details.order_id', $id)
        ->select(
            'order_details.id',
            'packages.price as harga_paket'
        )
        ->first();

    if (!$detail) {
        return back()->with('error', 'Detail paket pesanan tidak ditemukan.');
    }

    $berat = $validated['quantity'];
    $harga = $detail->harga_paket;
    $subtotal = $berat * $harga;

    DB::transaction(function () use ($id, $detail, $berat, $harga, $subtotal) {

        DB::table('order_details')
            ->where('id', $detail->id)
            ->update([
                'quantity' => $berat,
                'price' => $harga,
                'subtotal' => $subtotal,
                'updated_at' => now(),
            ]);

        DB::table('orders')
            ->where('id', $id)
            ->update([
                'total_price' => $subtotal,
                'updated_at' => now(),
            ]);
    });

    return back()->with(
        'success',
        'Penimbangan berhasil disimpan. Total harga: Rp' .
        number_format($subtotal, 0, ',', '.')
    );
}

}
