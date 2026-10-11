<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'SIPUS-Del' }} — Institut Teknologi Del</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
                    /* ===== Latar perpustakaan (rak buku) ===== */
            body { background: #2e1065; }
            body::before {
                content: ""; position: fixed; inset: 0; z-index: -2;
                background-color: #2e1065;
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='260' height='200'%3E%3Crect x='0' y='68' width='22' height='120' fill='%236d28d9'/%3E%3Crect x='22' y='38' width='16' height='150' fill='%23a78bfa'/%3E%3Crect x='38' y='83' width='26' height='105' fill='%234c1d95'/%3E%3Crect x='64' y='53' width='18' height='135' fill='%23c4b5fd'/%3E%3Crect x='82' y='28' width='24' height='160' fill='%235b21b6'/%3E%3Crect x='106' y='78' width='14' height='110' fill='%238b5cf6'/%3E%3Crect x='120' y='48' width='28' height='140' fill='%233b0764'/%3E%3Crect x='148' y='63' width='18' height='125' fill='%237c3aed'/%3E%3Crect x='166' y='33' width='22' height='155' fill='%234c1d95'/%3E%3Crect x='188' y='73' width='16' height='115' fill='%23a78bfa'/%3E%3Crect x='204' y='43' width='26' height='145' fill='%236d28d9'/%3E%3Crect x='230' y='58' width='30' height='130' fill='%23581c87'/%3E%3Crect y='188' width='260' height='12' fill='%233b2a1a'/%3E%3Crect y='188' width='260' height='3' fill='%235a4128'/%3E%3C/svg%3E");
                background-size: 260px 200px;
            }
            body::after {
                content: ""; position: fixed; inset: 0; z-index: -1;
                background: linear-gradient(180deg, rgba(46,16,101,.55), rgba(46,16,101,.88));
            }
            main.container {
                background: rgba(255,255,255,.94);
                border-radius: 1.25rem;
                padding: 1.75rem;
                margin-bottom: 2rem;
                box-shadow: 0 20px 50px rgba(0,0,0,.35);
            }
            footer.text-muted { color: rgba(255,255,255,.75) !important; }
            .text-del { color: var(--del-purple); }
            .form-check-input:checked { background-color: var(--del-purple); border-color: var(--del-purple); }
            .form-check-input:focus { box-shadow: 0 0 0 .25rem rgba(76,29,149,.2); border-color: var(--del-purple); }

            /* ===== Tabel buku ===== */
            .table-books td, .table-books th { padding: .95rem .75rem; }
            .table-books td { transition: background-color .2s ease; }
            .table-books tbody tr { cursor: pointer; animation: rowIn .35s ease both; }
            .table-books tbody tr:hover { --bs-table-bg: #faf8ff; }
            .table-books tbody tr.is-selected { --bs-table-bg: #efe7ff; }
            .table-books tbody tr.is-selected > td:first-child { box-shadow: inset 4px 0 0 var(--del-purple); }
            .table-books .row-check { width: 1.15rem; height: 1.15rem; cursor: pointer; }
            .table-books .row-check:checked { animation: checkPop .25s ease; }
            .isbn { color: #6b6485; background: #f6f3ff; padding: .2rem .45rem; border-radius: .4rem; font-size: .8rem; }

            .stok { display: inline-flex; align-items: center; gap: .4rem; font-weight: 600; font-size: .8rem; padding: .3rem .7rem; border-radius: 2rem; }
            .stok::before { content: ""; width: .5rem; height: .5rem; border-radius: 50%; background: currentColor; }
            .stok-ok    { background: #dcfce7; color: #166534; }
            .stok-tipis { background: #fef3c7; color: #92400e; }
            .stok-habis { background: #fee2e2; color: #991b1b; }

            .search-box { position: relative; }
            .search-box i { position: absolute; left: .9rem; top: 50%; transform: translateY(-50%); color: #8b82a8; }
            .search-box input { padding-left: 2.4rem; min-width: 260px; }

            /* ===== Bar aksi saat ada yang dipilih ===== */
            .selection-bar {
                position: fixed; left: 50%; bottom: 1.5rem; z-index: 1050;
                transform: translate(-50%, 150%); opacity: 0; pointer-events: none;
                display: flex; align-items: center; gap: 2rem;
                background: linear-gradient(135deg, var(--del-purple), var(--del-purple-dark));
                color: #fff; padding: .85rem 1.25rem; border-radius: 1rem;
                box-shadow: 0 12px 32px rgba(46,16,101,.5);
                transition: transform .3s cubic-bezier(.2,.9,.3,1.2), opacity .2s;
            }
            .selection-bar.show { transform: translate(-50%, 0); opacity: 1; pointer-events: auto; }
            .count-pill {
                min-width: 2.4rem; height: 2.4rem; border-radius: 50%;
                display: inline-flex; align-items: center; justify-content: center;
                background: #fff; color: var(--del-purple); font-weight: 700;
            }

            @keyframes rowIn { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: none; } }
            @keyframes checkPop { 50% { transform: scale(1.3); } }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark navbar-del shadow-sm mb-4 sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('buku.index') }}">
                <i class="bi bi-book-half me-2"></i>SIPUS-Del
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="nav">
                <ul class="navbar-nav ms-auto gap-1">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('buku.*') ? 'active' : '' }}" href="{{ route('buku.index') }}">
                            <i class="bi bi-journal-bookmark me-1"></i>Buku
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('kategori.*') ? 'active' : '' }}" href="{{ route('kategori.index') }}">
                            <i class="bi bi-tags me-1"></i>Kategori
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container pb-5">
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-4 alert-dismissible fade show">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger border-0 shadow-sm rounded-4">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>Periksa kembali isian formulir.
            </div>
        @endif

        {{ $slot }}
    </main>

    <footer class="text-center text-muted small pb-4">
        © {{ date('Y') }} SIPUS-Del · Institut Teknologi Del
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    
</body>
</html>