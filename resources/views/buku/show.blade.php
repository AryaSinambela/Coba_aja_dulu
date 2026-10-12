<x-layout :title="$buku->judul">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('buku.index') }}" class="btn btn-outline-del">
            <i class="bi bi-arrow-left me-1"></i>Kembali
        </a>
        <div class="d-flex gap-2">
            <a href="{{ route('buku.edit', $buku) }}" class="btn btn-del">
                <i class="bi bi-pencil me-1"></i>Edit
            </a>
            <form action="{{ route('buku.destroy', $buku) }}" method="POST"
                  onsubmit="return confirm('Hapus buku ini?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-outline-danger"><i class="bi bi-trash me-1"></i>Hapus</button>
            </form>
        </div>
    </div>

    <div class="card card-modern overflow-hidden detail-card">
        <div class="detail-head">
            <span class="badge badge-light-del mb-3">
                <i class="bi bi-tag me-1"></i>{{ $buku->kategori->nama_kategori }}
            </span>
            <h1 class="h3 hero-title mb-1">{{ $buku->judul }}</h1>
            <p class="mb-0 detail-sub">{{ $buku->penulis }}</p>
        </div>

        <div class="card-body p-4">
            <div class="row g-3 mb-4">
                <div class="col-6 col-md-3">
                    <div class="info-tile" style="--d: 0ms">
                        <div class="info-label"><i class="bi bi-upc-scan me-1"></i>ISBN</div>
                        <div class="info-value">{{ $buku->isbn }}</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="info-tile" style="--d: 70ms">
                        <div class="info-label"><i class="bi bi-building me-1"></i>Penerbit</div>
                        <div class="info-value">{{ $buku->penerbit }}</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="info-tile" style="--d: 140ms">
                        <div class="info-label"><i class="bi bi-calendar3 me-1"></i>Tahun Terbit</div>
                        <div class="info-value">{{ $buku->tahun_terbit }}</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="info-tile" style="--d: 210ms">
                        <div class="info-label"><i class="bi bi-stack me-1"></i>Stok</div>
                        <div class="info-value">
                            @if($buku->stok == 0)
                                <span class="stok stok-habis">Habis</span>
                            @elseif($buku->stok <= 5)
                                <span class="stok stok-tipis">{{ $buku->stok }} · Menipis</span>
                            @else
                                <span class="stok stok-ok">{{ $buku->stok }} · Tersedia</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <h2 class="h6 fw-bold text-del mb-2"><i class="bi bi-card-text me-1"></i>Sinopsis</h2>
            <p class="mb-0 sinopsis">{{ $buku->sinopsis ?: 'Belum ada sinopsis untuk buku ini.' }}</p>
        </div>
    </div>

    <style>
        .detail-card { animation: pageIn .5s ease both; }
        .detail-head {
            background: linear-gradient(135deg, #4C1D95, #3B0764);
            color: #fff; padding: 2rem 1.75rem;
        }
        .detail-head .hero-title { color: #fff; }
        .detail-sub { color: #DDD0FF; }
        .badge-light-del {
            background: rgba(255,255,255,.18); color: #fff; font-weight: 600;
            border: 1px solid rgba(255,255,255,.3); border-radius: 2rem; padding: .45em .9em;
        }
        .info-tile {
            background: #F8F5FF; border: 1px solid #E8DEFF; border-radius: .9rem;
            padding: .9rem 1rem; height: 100%;
            animation: rowIn .45s ease both; animation-delay: var(--d);
            transition: transform .2s, box-shadow .2s, border-color .2s;
        }
        .info-tile:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(76,29,149,.15); border-color: #A78BFA; }
        .info-label { font-size: .75rem; text-transform: uppercase; letter-spacing: .05em; color: #6b6485; margin-bottom: .3rem; }
        .info-value { font-weight: 600; word-break: break-word; }
        .sinopsis { line-height: 1.75; color: #3a3452; }
    </style>
</x-layout>