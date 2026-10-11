<x-layout title="Tambah Buku">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 hero-title mb-1">Tambah Buku</h1>
            <p class="text-muted mb-0">Isi data buku baru untuk katalog perpustakaan.</p>
        </div>
        <a href="{{ route('buku.index') }}" class="btn btn-outline-del">
            <i class="bi bi-arrow-left me-1"></i>Kembali
        </a>
    </div>

    <div class="card card-modern">
        <div class="card-body p-4">
            <form action="{{ route('buku.store') }}" method="POST">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">ISBN</label>
                        <input type="text" name="isbn" value="{{ old('isbn') }}"
                               class="form-control @error('isbn') is-invalid @enderror">
                        @error('isbn')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Tahun Terbit</label>
                        <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit') }}"
                               class="form-control @error('tahun_terbit') is-invalid @enderror">
                        @error('tahun_terbit')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Judul</label>
                        <input type="text" name="judul" value="{{ old('judul') }}"
                               class="form-control @error('judul') is-invalid @enderror">
                        @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Penulis</label>
                        <input type="text" name="penulis" value="{{ old('penulis') }}"
                               class="form-control @error('penulis') is-invalid @enderror">
                        @error('penulis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Penerbit</label>
                        <input type="text" name="penerbit" value="{{ old('penerbit') }}"
                               class="form-control @error('penerbit') is-invalid @enderror">
                        @error('penerbit')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-8">
                        <label class="form-label fw-semibold">Kategori</label>
                        <select name="kategori_id" class="form-select @error('kategori_id') is-invalid @enderror">
                            <option value="">— Pilih kategori —</option>
                            @foreach($kategoris as $k)
                                <option value="{{ $k->id }}" @selected(old('kategori_id') == $k->id)>
                                    {{ $k->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Stok</label>
                        <input type="number" name="stok" min="0" value="{{ old('stok', 0) }}"
                               class="form-control @error('stok') is-invalid @enderror">
                        @error('stok')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Sinopsis</label>
                        <textarea name="sinopsis" rows="4"
                                  class="form-control @error('sinopsis') is-invalid @enderror">{{ old('sinopsis') }}</textarea>
                        @error('sinopsis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-del"><i class="bi bi-save me-1"></i>Simpan</button>
                    <a href="{{ route('buku.index') }}" class="btn btn-outline-del">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-layout>