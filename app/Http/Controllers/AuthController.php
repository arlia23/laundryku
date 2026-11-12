<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Memproses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ])->onlyInput('email');
        }

        // Memperbarui session setelah login
        $request->session()->regenerate();

        $user = Auth::user();

        // Redirect berdasarkan role
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');

            case 'customer':
                return redirect()->route('customer.dashboard');

            case 'courier':
                return redirect()->route('courier.dashboard');

            default:
                Auth::logout();

                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect('/login')->withErrors([
                    'email' => 'Role pengguna tidak valid.',
                ]);
        }
    }

    // Menampilkan halaman registrasi
    public function showRegister()
    {
        return view('auth.register');
    }

// Memproses registrasi customer
public function register(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email',
        'password' => [
            'required',
            'confirmed',
            Password::min(8),
        ],
        'phone' => 'nullable|string|max:20',
        'address' => 'nullable|string',
    ]);

    // Membuat akun customer
   $user = new User();

$user->name = $validated['name'];
$user->email = $validated['email'];
$user->password = Hash::make($validated['password']);
$user->role = 'customer';
$user->phone = $validated['phone'] ?? null;
$user->address = $validated['address'] ?? null;

$user->save();

    // Login otomatis setelah registrasi
    Auth::login($user);

    $request->session()->regenerate();

    return redirect()->route('customer.dashboard')
        ->with('success', 'Registrasi berhasil!');
}

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')
            ->with('success', 'Berhasil logout.');
    }
}



// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;


// class AuthController extends Controller
// {
//     // Menampilkan halaman login
//     public function showLogin()
//     {
//         return view('auth.login');
//     }

//     // Proses login
//     public function login(Request $request)
//     {
//         $credentials = $request->validate([
//             'email' => 'required|email',
//             'password' => 'required',
//         ]);

//         if (Auth::attempt($credentials)) {

//             $request->session()->regenerate();

//             $role = Auth::user()->role;

//             if ($role === 'admin') {
//                 return redirect('/admin/dashboard');
//             }

//             if ($role === 'customer') {
//                 return redirect('/customer/dashboard');
//             }

//             if ($role === 'courier') {
//                 return redirect('/courier/dashboard');
//             }

//             Auth::logout();

//             return back()->withErrors([
//                 'email' => 'Role pengguna tidak valid.',
//             ]);
//         }

//         return back()->withErrors([
//             'email' => 'Email atau password salah.',
//         ])->onlyInput('email');
//     }

//     // Logout
//     public function logout(Request $request)
//     {
//         Auth::logout();

//         $request->session()->invalidate();
//         $request->session()->regenerateToken();

//         return redirect('/login');
//     }
// }