<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class KurirController extends Controller
{
    public function index()
    {
        $kurir = DB::table('users')
            ->where('role', 'courier')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('admin.kurir.index', compact('kurir'));
    }

    public function create()
    {
        return view('admin.kurir.create');
    }

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
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'role' => 'courier',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('admin.kurir.index')
            ->with('success', 'Akun kurir berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $kurir = DB::table('users')
            ->where('id', $id)
            ->where('role', 'courier')
            ->first();

        if (!$kurir) {
            abort(404);
        }

        return view('admin.kurir.edit', compact('kurir'));
    }

    public function update(Request $request, string $id)
    {
        $kurir = DB::table('users')
            ->where('id', $id)
            ->where('role', 'courier')
            ->first();

        if (!$kurir) {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($id),
            ],
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
            ->where('role', 'courier')
            ->update($data);

        return redirect()
            ->route('admin.kurir.index')
            ->with('success', 'Data kurir berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $kurir = DB::table('users')
            ->where('id', $id)
            ->where('role', 'courier')
            ->first();

        if (!$kurir) {
            abort(404);
        }

        DB::table('users')
            ->where('id', $id)
            ->where('role', 'courier')
            ->delete();

        return redirect()
            ->route('admin.kurir.index')
            ->with('success', 'Akun kurir berhasil dihapus.');
    }
    
public function show(string $id)
{
    $kurir = DB::table('users')
        ->where('id', $id)
        ->where('role', 'courier')
        ->first();

    if (!$kurir) {
        abort(404);
    }

    return view('admin.kurir.show', compact('kurir'));
}

}
