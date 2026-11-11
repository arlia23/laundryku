<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PesananController extends Controller
{
    
// Menampilkan daftar pesanan milik Customer


public function index(Request $request)
{
    $query = DB::table('orders')
        ->join('order_details', 'orders.id', '=', 'order_details.order_id')
        ->join('packages', 'order_details.package_id', '=', 'packages.id')
        ->where('orders.customer_id', Auth::id());

    // Cari berdasarkan kode pesanan
    if ($request->filled('search')) {
        $keyword = trim($request->search);

        $query->where('orders.order_code', 'like', "%{$keyword}%");
    }

    // Filter berdasarkan tanggal pesanan
    if ($request->filled('tanggal')) {
        $query->whereDate('orders.order_date', $request->tanggal);
    }

    $pesanan = $query
        ->select(
            'orders.id',
            'orders.order_code',
            'orders.order_date',
            'orders.total_price',
            'orders.status',
            'orders.payment_status',
            'packages.name as nama_paket',
            'order_details.quantity'
        )
        ->orderByDesc('orders.created_at')
        ->paginate(10)
        ->withQueryString();

    return view('customer.pesanan.index', compact('pesanan'));
}


// Menampilkan riwayat pesanan yang sudah lunas dan selesai
public function riwayat()
{
    $pesanan = DB::table('orders')
        ->join('order_details', 'orders.id', '=', 'order_details.order_id')
        ->join('packages', 'order_details.package_id', '=', 'packages.id')
        ->where('orders.customer_id', Auth::id())
        ->where('orders.status', 'completed')
        ->where('orders.payment_status', 'paid')
        ->select(
            'orders.id',
            'orders.order_code',
            'orders.order_date',
            'orders.total_price',
            'orders.status',
            'orders.payment_status',
            'packages.name as nama_paket',
            'order_details.quantity'
        )
        ->orderByDesc('orders.created_at')
        ->paginate(10);

    return view('customer.riwayat.index', compact('pesanan'));
}

// Menampilkan detail dan perkembangan pesanan Customer
public function show(string $id)
{
    $pesanan = DB::table('orders')
        ->join('users', 'orders.customer_id', '=', 'users.id')
        ->where('orders.id', $id)
        ->where('orders.customer_id', Auth::id())
        ->select(
            'orders.*',
            'users.name as nama_customer'
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

    $pengantaran = DB::table('deliveries')
        ->where('order_id', $id)
        ->first();

    return view('customer.pesanan.show', compact(
        'pesanan',
        'detail',
        'pengantaran'
    ));
}

    // Menampilkan formulir pemesanan
    public function create()
    {
        $paket = DB::table('packages')
            ->orderBy('price', 'asc')
            ->get();

        return view('customer.pesanan.create', compact('paket'));
    }


// Upload bukti pembayaran oleh Customer
public function uploadPaymentProof(Request $request, string $id)
{
    $pesanan = DB::table('orders')
        ->where('id', $id)
        ->where('customer_id', Auth::id())
        ->first();

    abort_if(!$pesanan, 404);

    if ($pesanan->status === 'cancelled') {
        return back()->with('error', 'Pesanan yang dibatalkan tidak dapat dibayar.');
    }

    if ($pesanan->payment_status === 'paid') {
        return back()->with('error', 'Pesanan ini sudah lunas.');
    }

    if ($pesanan->total_price <= 0) {
        return back()->with('error', 'Silakan tunggu Admin menimbang pakaian terlebih dahulu.');
    }

    $paketAntar = DB::table('order_details')
        ->join('packages', 'order_details.package_id', '=', 'packages.id')
        ->where('order_details.order_id', $id)
        ->where('packages.name', 'Cuci Setrika Antar')
        ->exists();

    if (!$paketAntar) {
        return back()->with('error', 'Upload bukti pembayaran hanya tersedia untuk paket Cuci Setrika Antar.');
    }

    $request->validate([
        'bukti_pembayaran' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ], [
        'bukti_pembayaran.required' => 'Silakan pilih foto bukti transfer.',
        'bukti_pembayaran.image' => 'File harus berupa gambar.',
        'bukti_pembayaran.mimes' => 'Format foto harus JPG, JPEG, atau PNG.',
        'bukti_pembayaran.max' => 'Ukuran foto maksimal 2 MB.',
    ]);

    $folder = 'payment-proofs';

    // Hapus foto sebelumnya agar hanya ada satu foto per pesanan
    foreach (['jpg', 'jpeg', 'png'] as $extension) {
        Storage::disk('public')->delete(
            "{$folder}/order-{$id}.{$extension}"
        );
    }

    $file = $request->file('bukti_pembayaran');
    $extension = strtolower($file->extension());

    $file->storeAs(
        $folder,
        "order-{$id}.{$extension}",
        'public'
    );

    return back()->with(
        'success',
        'Bukti transfer berhasil diunggah. Silakan tunggu verifikasi Admin.'
    );
}


    // Menyimpan pesanan customer
    public function store(Request $request)
    {
        $validated = $request->validate([
            'package_id' => 'required|exists:packages,id',
            'pickup_address' => 'nullable|string|max:1000',
            'delivery_address' => 'nullable|string|max:1000',
        ]);

        $paket = DB::table('packages')
            ->where('id', $validated['package_id'])
            ->first();

        if (!$paket) {
            return back()->withInput()
                ->with('error', 'Paket laundry tidak ditemukan.');
        }

        $layananAntar = $paket->name === 'Cuci Setrika Antar';

        // Alamat wajib diisi jika menggunakan layanan antar-jemput
        if ($layananAntar) {
            $request->validate([
                'pickup_address' => 'required|string|max:1000',
                'delivery_address' => 'required|string|max:1000',
            ]);
        }

        DB::transaction(function () use ($paket, $layananAntar, $validated) {

            // Membuat pesanan utama
            $orderId = DB::table('orders')->insertGetId([
                'order_code' => 'LK-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5)),
                'customer_id' => Auth::id(),
                'machine_id' => null,
                'order_date' => now()->toDateString(),

                // Harga ditentukan Admin setelah penimbangan
                'total_price' => 0,

                'status' => 'pending',
                'payment_status' => 'unpaid',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Detail paket dibuat dengan nilai sementara.
            // Admin mengisi quantity, price, dan subtotal setelah penimbangan.
            DB::table('order_details')->insert([
                'order_id' => $orderId,
                'package_id' => $paket->id,
                'quantity' => 0,
                'price' => $paket->price,
                'subtotal' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Membuat data pengantaran jika memilih layanan antar-jemput
            if ($layananAntar) {
                DB::table('deliveries')->insert([
                    'order_id' => $orderId,
                    'courier_id' => null,
                    'pickup_address' => $validated['pickup_address'],
                    'delivery_address' => $validated['delivery_address'],
                    'pickup_status' => 'pending',
                    'delivery_status' => 'pending',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });

        return redirect()
            ->route('customer.pesanan.index')
            ->with('success', 'Pesanan berhasil dibuat! Silakan tunggu konfirmasi Admin.');
    }
}
