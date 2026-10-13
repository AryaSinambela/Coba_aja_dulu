<x-layout title="Kategori">

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

    <div class="card card-del overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Kode</th>
                        <th>Nama Kategori</th>
                        <th class="text-center">Jumlah Buku</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kategoris as $kategori)
                        <tr>
                            <td class="ps-4"><span class="badge badge-del">{{ $kategori->kode_kategori }}</span></td>
                            <td>
                                <a href="{{ route('kategori.show', $kategori) }}" class="fw-semibold text-decoration-none" style="color:var(--del)">
                                    {{ $kategori->nama_kategori }}
                                </a>
                            </td>
                            <td class="text-center">{{ $kategori->bukus_count }}</td>
                            <td class="text-end pe-4">
                                <a href="{{ route('kategori.edit', $kategori) }}" class="btn btn-sm btn-outline-del">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('kategori.destroy', $kategori) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Hapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 empty-state">
                                <i class="bi bi-tags d-block mb-2"></i>
                                <p class="text-muted mb-2">Belum ada kategori.</p>
                                <a href="{{ route('kategori.create') }}" class="btn btn-sm btn-del">Tambah kategori pertama</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="small text-muted">Dipinjam {{ $buku->peminjamans_count }}× sepanjang riwayat</div>
</x-layout>