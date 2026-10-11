<x-layout title="Daftar Buku">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h3 hero-title mb-1">
                <i class="bi bi-journal-bookmark-fill me-2 text-del"></i>Koleksi Buku
            </h1>
            <p class="text-muted mb-0">Kelola katalog perpustakaan kampus Del.</p>
        </div>
        <div class="d-flex gap-2 align-items-center flex-wrap">
            <div class="search-box">
                <i class="bi bi-search"></i>
                <input id="cariBuku" type="search" class="form-control" placeholder="Cari judul, penulis, ISBN...">
            </div>
            <a href="{{ route('buku.create') }}" class="btn btn-del">
                <i class="bi bi-plus-lg me-1"></i>Tambah Buku
            </a>
        </div>
    </div>

    <div class="card card-modern overflow-hidden">
        <div class="table-responsive">
            <table class="table table-books align-middle mb-0" id="tabelBuku">
                <thead>
                    <tr>
                        <th class="ps-4" style="width:48px">
                            <input type="checkbox" id="checkAll" class="form-check-input" aria-label="Pilih semua">
                        </th>
                        <th>ISBN</th>
                        <th>Judul &amp; Penulis</th>
                        <th>Kategori</th>
                        <th>Tahun</th>
                        <th>Stok</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bukus as $buku)
                        <tr data-id="{{ $buku->id }}" data-stok="{{ $buku->stok }}"
                            style="animation-delay: {{ $loop->index * 40 }}ms">
                            <td class="ps-4">
                                <input type="checkbox" class="form-check-input row-check"
                                       aria-label="Pilih {{ $buku->judul }}">
                            </td>
                            <td><code class="isbn">{{ $buku->isbn }}</code></td>
                            <td>
                                <div class="fw-semibold">{{ $buku->judul }}</div>
                                <div class="small text-muted">{{ $buku->penulis }} · {{ $buku->penerbit }}</div>
                            </td>
                            <td><span class="badge badge-del">{{ $buku->kategori->nama_kategori }}</span></td>
                            <td>{{ $buku->tahun_terbit }}</td>
                            <td>
                                @if($buku->stok == 0)
                                    <span class="stok stok-habis">Habis</span>
                                @elseif($buku->stok <= 5)
                                    <span class="stok stok-tipis">{{ $buku->stok }} · Menipis</span>
                                @else
                                    <span class="stok stok-ok">{{ $buku->stok }} · Tersedia</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('buku.show', $buku) }}" class="btn btn-sm btn-outline-del" title="Detail"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('buku.edit', $buku) }}" class="btn btn-sm btn-outline-del" title="Edit"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('buku.destroy', $buku) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Hapus buku ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>Belum ada data buku.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div id="noResult" class="text-center text-muted py-4 d-none">
            <i class="bi bi-search me-1"></i>Tidak ada buku yang cocok di halaman ini.
        </div>
    </div>

    <div class="mt-4">{{ $bukus->links('pagination::bootstrap-5') }}</div>

    {{-- Bar yang muncul saat ada buku dipilih --}}
    <div id="selectionBar" class="selection-bar">
        <div class="d-flex align-items-center gap-3">
            <span class="count-pill" id="selCount">0</span>
            <div>
                <div class="fw-semibold">buku dipilih</div>
                <small id="selStok" class="opacity-75">Total stok: 0</small>
            </div>
        </div>
        <button type="button" id="clearSel" class="btn btn-sm btn-light fw-semibold">
            <i class="bi bi-x-lg me-1"></i>Batal pilih
        </button>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const rows     = [...document.querySelectorAll('#tabelBuku tbody tr[data-id]')];
            const checkAll = document.getElementById('checkAll');
            const bar      = document.getElementById('selectionBar');
            const selCount = document.getElementById('selCount');
            const selStok  = document.getElementById('selStok');
            const noResult = document.getElementById('noResult');
            const cari     = document.getElementById('cariBuku');

            const isSelected = r => r.classList.contains('is-selected');
            const isVisible  = r => !r.classList.contains('d-none');

            function setRow(row, on) {
                row.classList.toggle('is-selected', on);
                row.querySelector('.row-check').checked = on;
            }

            function update() {
                const selected = rows.filter(isSelected);
                const visible  = rows.filter(isVisible);
                selCount.textContent = selected.length;
                selStok.textContent  = 'Total stok: ' + selected.reduce((s, r) => s + Number(r.dataset.stok), 0);
                bar.classList.toggle('show', selected.length > 0);
                checkAll.checked       = visible.length > 0 && visible.every(isSelected);
                checkAll.indeterminate = selected.length > 0 && !checkAll.checked;
            }

            rows.forEach(row => {
                row.addEventListener('click', e => {
                    if (e.target.closest('a, button, form')) return;   // tombol aksi tidak ikut memilih
                    if (e.target.classList.contains('row-check')) setRow(row, e.target.checked);
                    else setRow(row, !isSelected(row));
                    update();
                });
            });

            checkAll.addEventListener('change', () => {
                rows.filter(isVisible).forEach(r => setRow(r, checkAll.checked));
                update();
            });

            document.getElementById('clearSel').addEventListener('click', () => {
                rows.forEach(r => setRow(r, false));
                update();
            });

            document.addEventListener('keydown', e => {
                if (e.key === 'Escape') { rows.forEach(r => setRow(r, false)); update(); }
            });

            cari.addEventListener('input', () => {
                const q = cari.value.trim().toLowerCase();
                rows.forEach(r => r.classList.toggle('d-none', q !== '' && !r.textContent.toLowerCase().includes(q)));
                noResult.classList.toggle('d-none', rows.some(isVisible) || rows.length === 0);
                update();
            });
        });
    </script>
</x-layout>