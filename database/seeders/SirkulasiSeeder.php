<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Database\Seeder;

class SirkulasiSeeder extends Seeder
{
    public function run(): void
    {
        $cari = fn (string $judul) => Buku::where('judul', $judul)->firstOrFail();

        $clean   = $cari('Clean Code');
        $algo    = $cari('Introduction to Algorithms');
        $pragma  = $cari('The Pragmatic Programmer');
        $laravel = $cari('Laravel: Up & Running');

        // Skenario uji: stok 1 (hanya satu peminjam yang berhasil) dan stok 0 (selalu ditolak)
        $clean->update(['stok' => 1]);
        $algo->update(['stok' => 0]);      // 1 eksemplar sedang dipinjam
        $pragma->update(['stok' => 2]);    // 3 eksemplar, 1 sedang dipinjam
        $laravel->update(['stok' => 4]);

        $lalu  = fn (int $n) => now()->subDays($n)->toDateString();
        $depan = fn (int $n) => now()->addDays($n)->toDateString();

        $data = [
            // kode,          buku,          nim,        nama,              pinjam,     tempo,       kembali,    status
            ['PJM-SEED-001', $algo->id,    '12S24001', 'Dina Sihombing',  $lalu(10), $lalu(3),    null,       'dipinjam'],      // terlambat
            ['PJM-SEED-002', $pragma->id,  '12S24002', 'Rizky Manurung',  $lalu(2),  $depan(5),   null,       'dipinjam'],
            ['PJM-SEED-003', $laravel->id, '12S24003', 'Maria Panjaitan', $lalu(12), $lalu(5),    $lalu(6),   'dikembalikan'],
            ['PJM-SEED-004', $clean->id,   '12S24004', 'Samuel Siregar',  $lalu(20), $lalu(13),   $lalu(14),  'dikembalikan'],
        ];

        foreach ($data as [$kode, $bukuId, $nim, $nama, $pinjam, $tempo, $kembali, $status]) {
            Peminjaman::create([
                'kode_pinjam'         => $kode,
                'buku_id'             => $bukuId,
                'nim_peminjam'        => $nim,
                'nama_peminjam'       => $nama,
                'tanggal_pinjam'      => $pinjam,
                'tanggal_jatuh_tempo' => $tempo,
                'tanggal_kembali'     => $kembali,
                'status'              => $status,
            ]);
        }
    }
}