<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaketController extends Controller
{
     // Menampilkan semua paket
    public function index()
    {
        $paket = DB::table('packages')
            ->orderBy('id')
            ->paginate(10);

        return view('admin.paket.index', compact('paket'));
    }

    // Form tambah paket
    public function create()
    {
        return view('admin.paket.create');
    }

    // Menyimpan paket baru
    public function store(Request $request)
    {
       $validated = $request->validate([
    'name' => 'required|string|max:255',
    'description' => 'nullable|string',
    'price' => 'required|numeric|min:1',
    'duration' => 'required|integer|min:1',
]);

        DB::table('packages')->insert([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'duration' => $validated['duration'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('admin.paket.index')
            ->with('success', 'Paket laundry berhasil ditambahkan!');
    }

    // Form edit paket
    public function edit(string $id)
    {
        $paket = DB::table('packages')
            ->where('id', $id)
            ->first();

        abort_if(!$paket, 404);

        return view('admin.paket.edit', compact('paket'));
    }

    // Memperbarui paket
    public function update(Request $request, string $id)
    {
        $paket = DB::table('packages')
            ->where('id', $id)
            ->first();

        abort_if(!$paket, 404);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:1',
        ]);

        DB::table('packages')
            ->where('id', $id)
            ->update([
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'price' => $validated['price'],
                'duration' => 1,
                'updated_at' => now(),
            ]);

        return redirect()
            ->route('admin.paket.index')
            ->with('success', 'Paket laundry berhasil diperbarui!');
    }

    // Menghapus paket
    public function destroy(string $id)
    {
        $paket = DB::table('packages')
            ->where('id', $id)
            ->first();

        abort_if(!$paket, 404);

        $digunakan = DB::table('order_details')
            ->where('package_id', $id)
            ->exists();

        if ($digunakan) {
            return back()->with(
                'error',
                'Paket tidak dapat dihapus karena sudah digunakan dalam pesanan.'
            );
        }

        DB::table('packages')
            ->where('id', $id)
            ->delete();

        return redirect()
            ->route('admin.paket.index')
            ->with('success', 'Paket laundry berhasil dihapus!');
    }
}
