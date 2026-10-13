<x-layout title="Peminjaman" :wide="true">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h3 hero-title mb-1"><i class="bi bi-arrow-left-right me-2 text-del"></i>Sirkulasi Peminjaman</h1>
            <p class="text-muted mb-0">Riwayat peminjaman dan pengembalian buku.</p>
        </div>
        <form method="GET" action="{{ route('peminjaman.index') }}" class="d-flex gap-2 flex-wrap">
            <div class="search-box">
                <i class="bi bi-search"></i>
                <input type="search" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari kode, NIM, nama...">
            </div>
            <select name="status" class="form-select w-auto" onchange="this.form.submit()">
                <option value="">Semua status</option>
                <option value="dipinjam" @selected(request('status') === 'dipinjam')>Dipinjam</option>
                <option value="dikembalikan" @selected(request('status') === 'dikembalikan')>Dikembalikan</option>
            </select>
            <button class="btn btn-del">Cari</button>
        </form>
    </div>

    <div class="card card-modern overflow-hidden">
        <div class="table-responsive">
            <table class="table table-books align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Kode</th><th>Buku</th><th>Peminjam</th>
                        <th>Pinjam</th><th>Jatuh Tempo</th><th>Status</th><th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjamans as $p)
                        <tr style="cursor:default">
                            <td class="ps-4"><code class="isbn">{{ $p->kode_pinjam }}</code></td>
                            <td class="fw-semibold">{{ $p->buku->judul }}</td>
                            <td>
                                <div>{{ $p->nama_peminjam }}</div>
                                <div class="small text-muted">{{ $p->nim_peminjam }}</div>
                            </td>
                            <td>{{ $p->tanggal_pinjam->format('d M Y') }}</td>
                            <td>{{ $p->tanggal_jatuh_tempo->format('d M Y') }}</td>
                            <td class="text-nowrap">
                                @if($p->status === 'dikembalikan')
                                    <span class="stok stok-ok">Dikembalikan {{ $p->tanggal_kembali?->format('d M') }}</span>
                                @elseif($p->terlambat)
                                    <span class="stok stok-habis">Terlambat</span>
                                @else
                                    <span class="stok stok-tipis">Dipinjam</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                @if($p->status === 'dipinjam')
                                    <form action="{{ route('peminjaman.kembali', $p->id) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Tandai buku ini sudah dikembalikan?')">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-sm btn-del"><i class="bi bi-arrow-return-left me-1"></i>Kembalikan</button>
                                    </form>
                                @else
                                    <span class="text-muted small">Selesai</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>Belum ada data peminjaman.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $peminjamans->links('pagination::bootstrap-5') }}</div>
</x-layout>