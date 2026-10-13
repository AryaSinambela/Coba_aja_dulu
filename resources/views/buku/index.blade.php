<x-layout title="Peminjaman" :wide="true">
    @php
    $kartu = [
        ['label' => 'Total Judul Buku',    'nilai' => $stats['total_judul'],     'ikon' => 'bi-journal-bookmark-fill'],
        ['label' => 'Total Stok Tersedia', 'nilai' => $stats['total_stok'],      'ikon' => 'bi-stack'],
        ['label' => 'Sedang Dipinjam',     'nilai' => $stats['sedang_dipinjam'], 'ikon' => 'bi-arrow-up-right-circle-fill'],
        ['label' => 'Sudah Dikembalikan',  'nilai' => $stats['sudah_kembali'],   'ikon' => 'bi-arrow-return-left'],
    ];

@endphp
<div class="row g-3 mb-4">
    @foreach($kartu as $k)
        <div class="col-6 col-lg-3">
            <div class="stat-card" style="--d: {{ $loop->index * 70 }}ms">
                <i class="bi {{ $k['ikon'] }}"></i>
                <div>
                    <div class="stat-num">{{ number_format($k['nilai']) }}</div>
                    <div class="stat-label">{{ $k['label'] }}</div>
                </div>
            </div>
        </div>
    @endforeach
</div>

@if(session('last_search') && ! request()->filled('search'))
    <div class="small text-muted mb-3">
        Pencarian terakhir Anda:
        <a href="{{ route('buku.index', ['search' => session('last_search')]) }}">{{ session('last_search') }}</a>
    </div>
@endif

    <div class="d-flex gap-2 align-items-center flex-wrap">
    <form method="GET" action="{{ route('buku.index') }}" class="d-flex gap-2 align-items-center flex-wrap">
        <div class="search-box">
            <i class="bi bi-search"></i>
            <input type="search" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari judul, penulis, ISBN...">
        </div>
        <select name="kategori" class="form-select w-auto" onchange="this.form.submit()">
            <option value="">Semua kategori</option>
            @foreach($kategoris as $kat)
                <option value="{{ $kat->id }}" @selected(request('kategori') == $kat->id)>{{ $kat->nama_kategori }}</option>
            @endforeach
        </select>
        <button class="btn btn-outline-del"><i class="bi bi-funnel me-1"></i>Cari</button>
        @if(request()->hasAny(['search', 'kategori']))
            <a href="{{ route('buku.index') }}" class="btn btn-outline-del">Reset</a>
        @endif
    </form>
    <a href="{{ route('buku.create') }}" class="btn btn-del"><i class="bi bi-plus-lg me-1"></i>Tambah Buku</a>
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
                                <div class="small text-muted">Dipinjam {{ $buku->peminjamans_count }}× sepanjang riwayat</div>
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