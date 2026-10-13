<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class BukuController extends Controller
{public function index(Request $request)
{
        if ($request->filled('search')) {
            session(['last_search' => $request->search]); // state sesi: pencarian terakhir
        }

        $bukus = Buku::with('kategori')
            ->withCount('peminjamans')
            ->when($request->filled('search'), function ($q) use ($request) {
                $s = $request->search;
                // dikelompokkan dalam closure agar OR tidak merusak filter kategori
                $q->where(function ($w) use ($s) {
                    $w->where('judul', 'like', "%{$s}%")
                    ->orWhere('penulis', 'like', "%{$s}%")
                    ->orWhere('isbn', 'like', "%{$s}%");
                });
            })
            ->when($request->filled('kategori'), fn ($q) => $q->where('kategori_id', $request->kategori))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $kategoris = Kategori::orderBy('nama_kategori')->get();

        // Statistik perpustakaan lewat Fluent Query Builder
        $stats = [
            'total_judul'     => DB::table('bukus')->count(),
            'total_stok'      => (int) DB::table('bukus')->sum('stok'),
            'sedang_dipinjam' => DB::table('peminjamans')->where('status', 'dipinjam')->count(),
            'sudah_kembali'   => DB::table('peminjamans')->where('status', 'dikembalikan')->count(),
        ];

        return view('buku.index', compact('bukus', 'kategoris', 'stats'));
    }
}