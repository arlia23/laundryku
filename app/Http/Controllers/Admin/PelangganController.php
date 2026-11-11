<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PelangganController extends Controller
{
    // Menampilkan daftar pelanggan
    public function index()
    {
        $pelanggan = DB::table('users')
            ->where('role', 'customer')
            ->orderByDesc('id')
            ->paginate(10);

        return view('admin.pelanggan.index', compact('pelanggan'));
    }

    // Menampilkan form tambah pelanggan
    public function create()
    {
        return view('admin.pelanggan.create');
    }

    // Menyimpan pelanggan baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        DB::table('users')->insert([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'customer',
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('admin.pelanggan.index')
            ->with('success', 'Pelanggan berhasil ditambahkan!');
    }

    // Menampilkan form edit
    public function edit(string $id)
    {
        $pelanggan = DB::table('users')
            ->where('role', 'customer')
            ->where('id', $id)
            ->first();

        abort_if(!$pelanggan, 404);

        return view('admin.pelanggan.edit', compact('pelanggan'));
    }

    // Memperbarui pelanggan
    public function update(Request $request, string $id)
    {
        $pelanggan = DB::table('users')
            ->where('role', 'customer')
            ->where('id', $id)
            ->first();

        abort_if(!$pelanggan, 404);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'updated_at' => now(),
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        DB::table('users')
            ->where('id', $id)
            ->update($data);

        return redirect()
            ->route('admin.pelanggan.index')
            ->with('success', 'Data pelanggan berhasil diperbarui!');
    }

    // Menghapus pelanggan
    public function destroy(string $id)
    {
        $pelanggan = DB::table('users')
            ->where('role', 'customer')
            ->where('id', $id)
            ->first();

        abort_if(!$pelanggan, 404);

        $memilikiPesanan = DB::table('orders')
            ->where('customer_id', $id)
            ->exists();

        if ($memilikiPesanan) {
            return back()->with(
                'error',
                'Pelanggan tidak dapat dihapus karena sudah memiliki pesanan.'
            );
        }

        DB::table('users')
            ->where('id', $id)
            ->delete();

        return redirect()
            ->route('admin.pelanggan.index')
            ->with('success', 'Pelanggan berhasil dihapus!');
    }
}
