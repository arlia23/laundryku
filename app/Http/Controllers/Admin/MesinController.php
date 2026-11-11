<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class MesinController extends Controller
{
    public function index()
    {
        $mesin = DB::table('machines')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('admin.mesin.index', compact('mesin'));
    }

    public function create()
    {
        return view('admin.mesin.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'type' => 'required|string|max:100',
            'status' => [
                'required',
                Rule::in(['available', 'in_use', 'maintenance']),
            ],
        ]);

        DB::table('machines')->insert([
            'name' => $validated['name'],
            'type' => $validated['type'],
            'status' => $validated['status'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('admin.mesin.index')
            ->with('success', 'Mesin laundry berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $mesin = DB::table('machines')
            ->where('id', $id)
            ->first();

        if (!$mesin) {
            abort(404);
        }

        return view('admin.mesin.edit', compact('mesin'));
    }

    public function update(Request $request, string $id)
    {
        $mesin = DB::table('machines')
            ->where('id', $id)
            ->first();

        if (!$mesin) {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'type' => 'required|string|max:100',
            'status' => [
                'required',
                Rule::in(['available', 'in_use', 'maintenance']),
            ],
        ]);

        DB::table('machines')
            ->where('id', $id)
            ->update([
                'name' => $validated['name'],
                'type' => $validated['type'],
                'status' => $validated['status'],
                'updated_at' => now(),
            ]);

        return redirect()
            ->route('admin.mesin.index')
            ->with('success', 'Data mesin berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $mesin = DB::table('machines')
            ->where('id', $id)
            ->first();

        if (!$mesin) {
            abort(404);
        }

        $digunakan = DB::table('orders')
            ->where('machine_id', $id)
            ->exists();

        if ($digunakan) {
            return redirect()
                ->route('admin.mesin.index')
                ->with('error', 'Mesin tidak dapat dihapus karena sudah digunakan dalam pesanan.');
        }

        DB::table('machines')
            ->where('id', $id)
            ->delete();

        return redirect()
            ->route('admin.mesin.index')
            ->with('success', 'Mesin berhasil dihapus.');
    }
}
