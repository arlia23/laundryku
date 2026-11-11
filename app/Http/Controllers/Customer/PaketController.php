<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PaketController extends Controller
{
    public function index()
    {
        // Mengambil semua paket laundry
        $paket = DB::table('packages')
            ->orderBy('price', 'asc')
            ->get();

        return view('customer.paket.index', compact('paket'));
    }
}
