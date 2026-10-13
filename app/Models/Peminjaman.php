<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamans'; // wajib: tanpa ini Laravel mencari tabel "peminjamen"

    protected $fillable = [
        'kode_pinjam', 'buku_id', 'nim_peminjam', 'nama_peminjam',
        'tanggal_pinjam', 'tanggal_jatuh_tempo', 'tanggal_kembali', 'status',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_pinjam'      => 'date',
            'tanggal_jatuh_tempo' => 'date',
            'tanggal_kembali'     => 'date',
        ];
    }

    public function buku(): BelongsTo
    {
        return $this->belongsTo(Buku::class);
    }

    public function getTerlambatAttribute(): bool
    {
        return $this->status === 'dipinjam' && $this->tanggal_jatuh_tempo->lt(today());
    }

        public function peminjamans(): HasMany
    {
        return $this->hasMany(Peminjaman::class);
    }
}