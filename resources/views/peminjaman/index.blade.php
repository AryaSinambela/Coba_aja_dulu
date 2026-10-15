<x-layout title="Sirkulasi Peminjaman" :wide="true">
    @php
        $opsiDurasi = [3 => 'Cepat', 7 => 'Standar', 14 => 'Tugas akhir'];
        $tabs = ['dipinjam' => 'Aktif', 'dikembalikan' => 'Dikembalikan', 'semua' => 'Semua'];
        $jumlah = [
            'dipinjam'     => $ringkas['aktif'],
            'dikembalikan' => $ringkas['kembali'],
            'semua'        => $ringkas['aktif'] + $ringkas['kembali'],
        ];
        $langkah = [
            ['judul' => 'DB::transaction(..., 3)', 'tag' => 'Deadlock safe',
             'uraian' => 'Dicoba ulang hingga 3 kali jika InnoDB mendeteksi deadlock.'],
            ['judul' => 'lockForUpdate()', 'tag' => 'Mutual exclusion',
             'uraian' => 'Mengunci baris buku yang dipilih. Transaksi lain untuk buku yang sama mengantre sampai commit selesai.'],
            ['judul' => 'Evaluasi stok', 'tag' => 'Guard stok < 1',
             'uraian' => 'Jika stok kurang dari 1, DomainException dilempar dan seluruh perubahan dibatalkan (rollback).'],
            ['judul' => 'Validasi NIM', 'tag' => '1 NIM = 1 buku aktif',
             'uraian' => 'NIM yang sama tidak boleh meminjam judul yang sama sebelum mengembalikannya.'],
            ['judul' => "decrement('stok')", 'tag' => 'Commit final',
             'uraian' => 'Stok berkurang dan transaksi dicatat dengan kode unik PJM-tanggal-acak.'],
        ];
    @endphp

    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <div class="mono mb-1">Katalog › Sirkulasi › Catat peminjaman baru</div>
            <h1 class="h2 hero-title mb-1">Sirkulasi Peminjaman &amp; Transaksi ACID</h1>
            <p class="text-muted mb-0">Pencatatan peminjaman dan pengembalian dengan perlindungan konkurensi tingkat baris.</p>
        </div>
        <div class="db-badge">
            <i class="bi bi-shield-check"></i>
            <div>
                <div class="mono">Database: {{ strtoupper($driver) }}</div>
                <div class="mono">Kunci baris: lockForUpdate()</div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        {{-- ===== Form transaksi ===== --}}
        <div class="col-lg-7">
            <div class="card card-modern h-100">
                <div class="card-body p-4">
                    <div class="guard-box mb-4">
                        <i class="bi bi-lock-fill"></i>
                        <div>
                            <div class="fw-semibold">Penjaga konkurensi pesimistik aktif</div>
                            <div class="small text-muted">
                                Baris buku dikunci dengan <code>lockForUpdate()</code> di dalam <code>DB::transaction()</code>
                                agar stok tidak menjadi minus saat dua permintaan masuk bersamaan.
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('peminjaman.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Pilih koleksi buku</label>
                            <select name="buku_id" class="form-select @error('buku_id') is-invalid @enderror">
                                <option value="">— Pilih buku —</option>
                                @foreach($daftarBuku as $b)
                                    <option value="{{ $b->id }}" data-stok="{{ $b->stok }}"
                                            @selected(old('buku_id', request('buku')) == $b->id)>
                                        {{ $b->judul }} · stok {{ $b->stok }}{{ $b->stok < 1 ? ' (habis)' : '' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('buku_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <div id="stokHint" class="small mt-2 d-none"></div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-5">
                                <label class="form-label fw-semibold">NIM peminjam</label>
                                <input type="text" name="nim_peminjam" placeholder="mis. 12S24017"
                                       value="{{ old('nim_peminjam', session('last_peminjam.nim')) }}"
                                       class="form-control @error('nim_peminjam') is-invalid @enderror">
                                @error('nim_peminjam')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                <div class="mono mt-1">Min. 6 · maks. 15 karakter</div>
                            </div>
                            <div class="col-md-7">
                                <label class="form-label fw-semibold">Nama lengkap mahasiswa</label>
                                <input type="text" name="nama_peminjam"
                                       value="{{ old('nama_peminjam', session('last_peminjam.nama')) }}"
                                       class="form-control @error('nama_peminjam') is-invalid @enderror">
                                @error('nama_peminjam')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <label class="form-label fw-semibold">Durasi peminjaman</label>
                        <div class="durasi-group mb-1">
                            @foreach($opsiDurasi as $hari => $ket)
                                <input type="radio" class="btn-check" name="durasi_hari" id="durasi{{ $hari }}"
                                       value="{{ $hari }}" @checked((int) old('durasi_hari', 7) === $hari)>
                                <label class="durasi-opt" for="durasi{{ $hari }}">
                                    <span class="durasi-num">{{ $hari }} Hari</span>
                                    <span class="mono">{{ $ket }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('durasi_hari')<div class="text-danger small mb-2">{{ $message }}</div>@enderror
                        <div class="mono mb-4">Durasi yang diterima server: 1–30 hari</div>

                        <button type="submit" class="btn btn-del w-100 py-3">
                            <i class="bi bi-lightning-charge-fill me-1"></i>Proses transaksi peminjaman
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- ===== Pipeline ACID dan ringkasan ===== --}}
        <div class="col-lg-5">
            <div class="card card-modern mb-4">
                <div class="card-body p-4">
                    <h2 class="h5 hero-title mb-1">Pipeline ACID SIPUS-Del</h2>
                    <div class="mono mb-3">Siklus transaksional basis data</div>

                    @foreach($langkah as $l)
                        <div class="pipe-step">
                            <span class="pipe-no">{{ $loop->iteration }}</span>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center gap-2 flex-wrap mb-1">
                                    <code class="pipe-code">{{ $l['judul'] }}</code>
                                    <span class="mono">{{ $l['tag'] }}</span>
                                </div>
                                <div class="small text-muted">{{ $l['uraian'] }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="card card-modern">
                <div class="card-body p-4">
                    <div class="mono mb-2">Ringkasan sirkulasi (dihitung dari database)</div>
                    <div class="sum-grid">
                        <div class="sum-box"><div class="sum-num">{{ $ringkas['aktif'] }}</div><div class="mono">Dipinjam</div></div>
                        <div class="sum-box {{ $ringkas['terlambat'] > 0 ? 'warn' : '' }}">
                            <div class="sum-num">{{ $ringkas['terlambat'] }}</div><div class="mono">Terlambat</div>
                        </div>
                        <div class="sum-box"><div class="sum-num">{{ $ringkas['kembali'] }}</div><div class="mono">Dikembalikan</div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== Daftar peminjaman ===== --}}
    <div class="card card-modern overflow-hidden">
        <div class="p-4 pb-3 d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h2 class="h5 hero-title mb-1"><i class="bi bi-clipboard-check me-2 text-del"></i>Daftar Pinjaman</h2>
                <div class="text-muted small">Pengembalian memperbarui stok lewat <code>increment('stok')</code> di dalam transaksi.</div>
            </div>
            <div class="d-flex flex-wrap gap-2 align-items-center">
                <div class="tabs-del">
                    @foreach($tabs as $kunci => $label)
                        <a href="{{ route('peminjaman.index', array_merge(request()->except('page'), ['status' => $kunci])) }}"
                           class="tab-del {{ $status === $kunci ? 'active' : '' }}">
                            {{ $label }} <span class="n">{{ $jumlah[$kunci] }}</span>
                        </a>
                    @endforeach
                </div>
                <form method="GET" action="{{ route('peminjaman.index') }}" class="d-flex gap-2">
                    <input type="hidden" name="status" value="{{ $status }}">
                    <div class="search-box">
                        <i class="bi bi-search"></i>
                        <input type="search" name="search" value="{{ request('search') }}" class="form-control"
                               placeholder="Cari kode, NIM, nama...">
                    </div>
                    <button class="btn btn-outline-del">Cari</button>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-books align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">ID / Ref</th>
                        <th>Peminjam</th>
                        <th>Judul buku</th>
                        <th>Pinjam &amp; deadline</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Aksi pustakawan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjamans as $p)
                        <tr style="cursor:default">
                            <td class="ps-4"><code class="isbn">{{ $p->kode_pinjam }}</code></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="avatar-nim">{{ strtoupper(substr($p->nim_peminjam, 0, 3)) }}</span>
                                    <div>
                                        <div class="fw-semibold">{{ $p->nama_peminjam }}</div>
                                        <div class="mono">{{ $p->nim_peminjam }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $p->buku->judul }}</div>
                                <div class="mono">{{ $p->buku->kategori->nama_kategori }} · ISBN {{ $p->buku->isbn }}</div>
                            </td>
                            <td class="text-nowrap">
                                <div>{{ $p->tanggal_pinjam->format('d M Y') }}</div>
                                <div class="mono {{ $p->terlambat ? 'text-danger fw-semibold' : '' }}">
                                    Jatuh tempo {{ $p->tanggal_jatuh_tempo->format('d M Y') }}
                                    @if($p->terlambat)
                                        · telat {{ abs((int) $p->tanggal_jatuh_tempo->diffInDays(today())) }} hari
                                    @endif
                                </div>
                            </td>
                            <td class="text-nowrap">
                                @if($p->status === 'dikembalikan')
                                    <span class="chip chip-selesai">Dikembalikan {{ $p->tanggal_kembali?->format('d M') }}</span>
                                @elseif($p->terlambat)
                                    <span class="chip chip-telat">Terlambat</span>
                                @else
                                    <span class="chip chip-aktif">Dipinjam</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                @if($p->status === 'dipinjam')
                                    <form action="{{ route('peminjaman.kembali', $p->id) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Tandai buku ini sudah dikembalikan?')">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-sm btn-outline-del">
                                            <i class="bi bi-arrow-return-left me-1"></i>Kembalikan buku
                                        </button>
                                    </form>
                                @else
                                    <span class="mono">Selesai</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>Tidak ada data peminjaman pada filter ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mt-4">
        <small class="text-muted">
            Menampilkan <strong>{{ $peminjamans->firstItem() ?? 0 }}</strong>–<strong>{{ $peminjamans->lastItem() ?? 0 }}</strong>
            dari <strong>{{ $peminjamans->total() }}</strong> peminjaman
        </small>
        <div class="pager-wrap">{{ $peminjamans->links('pagination::bootstrap-5') }}</div>
    </div>

    <style>
        .mono { font-family: 'JetBrains Mono', monospace; font-size: .68rem; letter-spacing: .05em; text-transform: uppercase; color: #6b6485; }
        .db-badge { display: flex; align-items: center; gap: .75rem; padding: .7rem 1rem; background: #EEF2FF; border: 1px solid #DDE3FF; border-radius: .9rem; }
        .db-badge > i { font-size: 1.4rem; color: #4C1D95; }
        .guard-box { display: flex; gap: .9rem; padding: 1rem 1.1rem; background: #F3EEFF; border: 1px solid #E3D8FF; border-radius: .9rem; }
        .guard-box > i { font-size: 1.3rem; color: #4C1D95; margin-top: .1rem; }

        .durasi-group { display: grid; grid-template-columns: repeat(3, 1fr); gap: .6rem; }
        .durasi-opt {
            display: flex; flex-direction: column; align-items: center; gap: .1rem; padding: .8rem .5rem;
            border: 1.5px solid #E8DEFF; background: #F8F5FF; border-radius: .8rem; cursor: pointer;
            transition: transform .2s, border-color .2s, background-color .2s, box-shadow .2s;
        }
        .durasi-opt:hover { border-color: #A78BFA; transform: translateY(-2px); }
        .durasi-num { font-family: 'Newsreader', Georgia, serif; font-size: 1.25rem; font-weight: 600; color: #4C1D95; }
        .btn-check:checked + .durasi-opt { background: #4C1D95; border-color: #4C1D95; box-shadow: 0 8px 18px rgba(76,29,149,.3); transform: translateY(-2px); }
        .btn-check:checked + .durasi-opt .durasi-num,
        .btn-check:checked + .durasi-opt .mono { color: #fff; }

        .pipe-step { display: flex; gap: .85rem; padding: .8rem .9rem; margin-bottom: .6rem; background: #FBFAFF; border: 1px solid #EEE7FF; border-radius: .8rem; animation: rowIn .4s ease both; }
        .pipe-no { flex: 0 0 2rem; height: 2rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; background: #4C1D95; color: #fff; font-weight: 700; font-size: .85rem; }
        .pipe-code { background: #EDE4FF; color: #4C1D95; padding: .1rem .45rem; border-radius: .4rem; font-size: .78rem; }

        .sum-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: .7rem; }
        .sum-box { text-align: center; padding: .9rem .5rem; background: #F8F5FF; border: 1px solid #E8DEFF; border-radius: .9rem; }
        .sum-box.warn { background: #FEF2F2; border-color: #FECACA; }
        .sum-num { font-family: 'Newsreader', Georgia, serif; font-size: 1.9rem; font-weight: 600; color: #4C1D95; line-height: 1.1; }
        .sum-box.warn .sum-num { color: #991b1b; }

        .tabs-del { display: inline-flex; gap: .3rem; padding: .3rem; background: #F3EEFF; border-radius: .8rem; }
        .tab-del { display: inline-flex; align-items: center; gap: .4rem; padding: .45rem .9rem; border-radius: .6rem; color: #4C1D95; font-weight: 600; font-size: .88rem; text-decoration: none; transition: background-color .2s; }
        .tab-del:hover { background: #E3D8FF; color: #4C1D95; }
        .tab-del.active { background: #4C1D95; color: #fff; }
        .tab-del .n { font-size: .72rem; opacity: .8; }

        .avatar-nim { flex: 0 0 2.4rem; width: 2.4rem; height: 2.4rem; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; background: #EDE4FF; color: #4C1D95; font-weight: 700; font-size: .72rem; }
        .chip { display: inline-flex; align-items: center; gap: .4rem; font-family: 'JetBrains Mono', monospace; font-size: .7rem; font-weight: 600; padding: .35rem .75rem; border-radius: 2rem; }
        .chip::before { content: ''; width: .45rem; height: .45rem; border-radius: 50%; background: currentColor; }
        .chip-aktif { background: #CCFBF1; color: #0f766e; }
        .chip-telat { background: #fee2e2; color: #991b1b; }
        .chip-telat::before { animation: pulseDot 1.4s ease infinite; }
        .chip-selesai { background: #EDE4FF; color: #4C1D95; }

        .pager-wrap nav .d-sm-flex > div:first-child { display: none; }
        .pager-wrap nav .d-sm-flex { justify-content: flex-end !important; }
        .pager-wrap .pagination { margin-bottom: 0; }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sel  = document.querySelector('select[name=buku_id]');
            const hint = document.getElementById('stokHint');

            function tampilHint() {
                const opt = sel.selectedOptions[0];
                if (!opt || !opt.value) { hint.classList.add('d-none'); return; }
                const stok = Number(opt.dataset.stok);
                hint.className = 'small mt-2 ' + (stok < 1 ? 'text-danger' : (stok <= 5 ? 'text-warning-emphasis' : 'text-success'));
                hint.textContent = stok < 1
                    ? 'Stok 0: server akan menolak transaksi dan membatalkan (rollback) semua perubahan.'
                    : 'Stok saat ini: ' + stok + ' eksemplar.';
            }

            sel.addEventListener('change', tampilHint);
            tampilHint();
        });
    </script>
</x-layout>