<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use DomainException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $peminjamans = Peminjaman::with('buku')
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->when($request->filled('search'), function ($q) use ($request) {
                $s = $request->search;
                $q->where(function ($w) use ($s) {
                    $w->where('kode_pinjam', 'like', "%{$s}%")
                      ->orWhere('nim_peminjam', 'like', "%{$s}%")
                      ->orWhere('nama_peminjam', 'like', "%{$s}%");
                });
            })
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('peminjaman.index', compact('peminjamans'));
    }

    public function pinjam(Request $request, int $id)
    {
        $data = $request->validate([
            'nim_peminjam'  => 'required|string|min:6|max:15',
            'nama_peminjam' => 'required|string|min:3|max:150',
            'durasi_hari'   => 'required|integer|min:1|max:30',
        ]);

        try {
            $peminjaman = DB::transaction(function () use ($data, $id) {
                // 1. Kunci baris buku: request lain untuk buku yang sama harus menunggu di sini
                $buku = Buku::where('id', $id)->lockForUpdate()->firstOrFail();

                // 2. Cek stok (setelah dikunci, nilainya pasti yang terbaru)
                if ($buku->stok < 1) {
                    throw new DomainException("Stok buku \"{$buku->judul}\" habis, peminjaman ditolak.");
                }

                // 3. NIM yang sama tidak boleh meminjam buku yang sama sebelum mengembalikan
                $nim = strtoupper(trim($data['nim_peminjam']));
                $masihPinjam = Peminjaman::where('buku_id', $buku->id)
                    ->where('nim_peminjam', $nim)
                    ->where('status', 'dipinjam')
                    ->exists();

                if ($masihPinjam) {
                    throw new DomainException("NIM {$nim} masih meminjam buku ini dan belum mengembalikannya.");
                }

                // 4. Mutasi atomik: stok turun + transaksi tercatat, atau dua-duanya batal
                $buku->decrement('stok');

                return Peminjaman::create([
                    'kode_pinjam'         => 'PJM-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5)),
                    'buku_id'             => $buku->id,
                    'nim_peminjam'        => $nim,
                    'nama_peminjam'       => trim($data['nama_peminjam']),
                    'tanggal_pinjam'      => now()->toDateString(),
                    'tanggal_jatuh_tempo' => now()->addDays((int) $data['durasi_hari'])->toDateString(),
                    'status'              => 'dipinjam',
                ]);
            }, 3); // 3x percobaan ulang jika terjadi deadlock

            // state sesi: peminjam terakhir dipakai untuk mengisi otomatis form berikutnya
            session(['last_peminjam' => [
                'nim'  => $peminjaman->nim_peminjam,
                'nama' => $peminjaman->nama_peminjam,
            ]]);

            return back()->with('success', "Peminjaman {$peminjaman->kode_pinjam} berhasil dicatat.");
        } catch (DomainException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        } catch (QueryException $e) {
            Log::error('[DB EXCEPTION] pinjam: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Terjadi kesalahan database, transaksi dibatalkan.');
        }
    }

    public function kembali(int $id)
    {
        try {
            $peminjaman = DB::transaction(function () use ($id) {
                $pinjam = Peminjaman::where('id', $id)->lockForUpdate()->firstOrFail();

                if ($pinjam->status === 'dikembalikan') {
                    throw new DomainException('Buku ini sudah dikembalikan sebelumnya.');
                }

                $buku = Buku::where('id', $pinjam->buku_id)->lockForUpdate()->firstOrFail();

                $pinjam->update([
                    'status'          => 'dikembalikan',
                    'tanggal_kembali' => now()->toDateString(),
                ]);
                $buku->increment('stok');

                return $pinjam;
            }, 3);

            return back()->with('success', "Pengembalian {$peminjaman->kode_pinjam} berhasil, stok buku bertambah.");
        } catch (DomainException $e) {
            return back()->with('error', $e->getMessage());
        } catch (QueryException $e) {
            Log::error('[DB EXCEPTION] kembali: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan database, pengembalian dibatalkan.');
        }
    }
}