<x-layout :title="$kategori->nama_kategori">
    <a href="{{ route('kategori.index') }}" class="text-decoration-none small">
        <i class="bi bi-arrow-left"></i> Kembali ke kategori
    </a>

    <div class="d-flex justify-content-between align-items-center mt-3 mb-4">
        <div>
            <span class="badge badge-del mb-1">{{ $kategori->kode_kategori }}</span>
            <h1 class="h3 fw-bold page-title mb-0">{{ $kategori->nama_kategori }}</h1>
        </div>
        <span class="text-muted">{{ $bukus->total() }} buku</span>
    </div>

   <div class="card card-modern mt-4">
    <div class="card-body p-4">
        <h2 class="h6 fw-bold text-del mb-3"><i class="bi bi-arrow-up-right-circle me-1"></i>Peminjaman Buku</h2>

            @if($buku->stok < 1)
                <div class="alert alert-warning mb-0">Stok habis. Buku ini belum bisa dipinjam.</div>
            @else
                <form action="{{ route('buku.pinjam', $buku->id) }}" method="POST" class="row g-3">
                    @csrf
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">NIM</label>
                        <input type="text" name="nim_peminjam" value="{{ old('nim_peminjam', session('last_peminjam.nim')) }}"
                            class="form-control @error('nim_peminjam') is-invalid @enderror">
                        @error('nim_peminjam')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Nama Peminjam</label>
                        <input type="text" name="nama_peminjam" value="{{ old('nama_peminjam', session('last_peminjam.nama')) }}"
                            class="form-control @error('nama_peminjam') is-invalid @enderror">
                        @error('nama_peminjam')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Durasi (hari)</label>
                        <input type="number" name="durasi_hari" min="1" max="30" value="{{ old('durasi_hari', 7) }}"
                            class="form-control @error('durasi_hari') is-invalid @enderror">
                        @error('durasi_hari')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-del w-100"><i class="bi bi-check2-circle me-1"></i>Pinjam</button>
                    </div>
                </form>
            @endif
        </div>
    </div>

    <div class="mt-4 d-flex justify-content-center">{{ $bukus->links() }}</div>
</x-layout>