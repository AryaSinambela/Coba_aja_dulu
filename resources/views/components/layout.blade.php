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

        :root {
            --del-purple: #4C1D95;
            --del-purple-dark: #3B0764;
            --del-purple-soft: #F3EEFF;
            --del-purple-light: #A78BFA;
        }

        body { font-family: 'Inter', sans-serif; color: #1f1937; background: #2e1065; }

        /* ===== Latar rak buku ===== */
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

        /* ===== Navbar ===== */
        .navbar-del {
            background: linear-gradient(135deg, #4C1D95, #3B0764);
            box-shadow: 0 4px 20px rgba(0,0,0,.35);
        }
        .navbar-del .nav-link {
            color: rgba(255,255,255,.8); font-weight: 500;
            border-radius: .6rem; padding: .5rem .9rem;
            transition: background-color .2s, color .2s, transform .2s;
        }
        .navbar-del .nav-link:hover { color: #fff; background: rgba(255,255,255,.12); transform: translateY(-1px); }
        .navbar-del .nav-link.active { color: #fff; background: rgba(255,255,255,.2); }

        /* ===== Konten ===== */
        main.container {
            background: rgba(255,255,255,.95);
            border-radius: 1.25rem; padding: 1.75rem; margin-bottom: 2rem;
            box-shadow: 0 20px 50px rgba(0,0,0,.35);
            animation: pageIn .5s ease both;
        }
        footer.footer-del { color: rgba(255,255,255,.75); }
        .hero-title { font-weight: 700; letter-spacing: -.02em; }
        .text-del { color: #4C1D95; }
        .card-modern { border: 0; border-radius: 1rem; box-shadow: 0 4px 24px rgba(76,29,149,.1); }

        /* ===== Tombol & badge ===== */
        .btn-del {
            background: #4C1D95; color: #fff; border: 0; border-radius: .6rem;
            font-weight: 600; padding: .55rem 1.1rem;
            transition: transform .2s, box-shadow .2s, background-color .2s;
        }
        .btn-del:hover { background: #3B0764; color: #fff; transform: translateY(-2px); box-shadow: 0 8px 18px rgba(76,29,149,.35); }
        .btn-del:active { transform: translateY(0) scale(.97); }
        .btn-outline-del {
            border: 1.5px solid #4C1D95; color: #4C1D95; background: transparent;
            border-radius: .6rem; font-weight: 600;
            transition: background-color .2s, color .2s, transform .2s;
        }
        .btn-outline-del:hover { background: #4C1D95; color: #fff; transform: translateY(-1px); }
        .badge-del {
            background: #F3EEFF; color: #4C1D95; font-weight: 600;
            border: 1px solid #ddd0ff; border-radius: 2rem; padding: .4em .8em;
        }

        /* ===== Form ===== */
        .form-control, .form-select { border-radius: .6rem; padding: .6rem .9rem; }
        .form-control:focus, .form-select:focus { border-color: #4C1D95; box-shadow: 0 0 0 .25rem rgba(76,29,149,.15); }

        /* ===== Checkbox: ungu saat dicentang, centang putih ===== */
        .form-check-input {
            width: 1.2rem; height: 1.2rem; cursor: pointer;
            border: 2px solid #A78BFA; background-color: #fff;
            transition: background-color .15s, border-color .15s, box-shadow .15s;
        }
        .form-check-input:hover { border-color: #4C1D95; }
        .form-check-input:checked,
        .form-check-input:indeterminate { background-color: #4C1D95; border-color: #4C1D95; }
        .form-check-input:checked { animation: checkPop .3s cubic-bezier(.2,.9,.3,1.5); }
        .form-check-input:focus { border-color: #4C1D95; box-shadow: 0 0 0 .25rem rgba(76,29,149,.2); }

        /* ===== Tabel ===== */
        .table-books thead th {
            background: #F3EEFF; color: #4C1D95; border: 0;
            font-size: .78rem; text-transform: uppercase; letter-spacing: .05em;
        }
        .table-books td, .table-books th { padding: .95rem .75rem; }
        .table-books tbody tr { cursor: pointer; animation: rowIn .4s ease both; }
        .table-books tbody td { background-color: #fff; transition: background-color .25s ease; }
        .table-books tbody tr:hover > td { background-color: #FAF8FF; }
        .table-books tbody tr.is-selected > td { background-color: #EDE4FF; animation: selFlash .5s ease; }
        .table-books tbody tr.is-selected:hover > td { background-color: #E4D7FF; }

        /* garis ungu di kiri yang "tumbuh" saat baris dipilih */
        .table-books tbody td:first-child { position: relative; }
        .table-books tbody td:first-child::before {
            content: ""; position: absolute; left: 0; top: 0; bottom: 0; width: 4px;
            background: #4C1D95; transform: scaleY(0); transition: transform .25s ease;
        }
        .table-books tbody tr.is-selected td:first-child::before { transform: scaleY(1); }

        .isbn { color: #6b6485; background: #F6F3FF; padding: .2rem .45rem; border-radius: .4rem; font-size: .8rem; }

        .stok { display: inline-flex; align-items: center; gap: .4rem; font-weight: 600; font-size: .8rem; padding: .3rem .7rem; border-radius: 2rem; }
        .stok::before { content: ""; width: .5rem; height: .5rem; border-radius: 50%; background: currentColor; }
        .stok-ok    { background: #dcfce7; color: #166534; }
        .stok-tipis { background: #fef3c7; color: #92400e; }
        .stok-habis { background: #fee2e2; color: #991b1b; }
        .stok-habis::before { animation: pulseDot 1.4s ease infinite; }

        .search-box { position: relative; }
        .search-box i { position: absolute; left: .9rem; top: 50%; transform: translateY(-50%); color: #8b82a8; }
        .search-box input { padding-left: 2.4rem; min-width: 260px; }

        /* ===== Pagination ungu ===== */
        .pagination {
            --bs-pagination-color: #4C1D95;
            --bs-pagination-hover-color: #3B0764;
            --bs-pagination-hover-bg: #F3EEFF;
            --bs-pagination-focus-color: #3B0764;
            --bs-pagination-focus-bg: #F3EEFF;
            --bs-pagination-focus-box-shadow: 0 0 0 .2rem rgba(76,29,149,.2);
            --bs-pagination-active-bg: #4C1D95;
            --bs-pagination-active-border-color: #4C1D95;
            --bs-pagination-active-color: #fff;
        }

        /* ===== Bar aksi saat ada buku dipilih ===== */
        .selection-bar {
            position: fixed; left: 50%; bottom: 1.5rem; z-index: 1050;
            transform: translate(-50%, 160%) scale(.9); opacity: 0; pointer-events: none;
            display: flex; align-items: center; gap: 2rem;
            background: linear-gradient(135deg, #4C1D95, #3B0764);
            color: #fff; padding: .85rem 1.25rem; border-radius: 1rem;
            border: 1px solid rgba(255,255,255,.18);
            box-shadow: 0 16px 40px rgba(20,5,50,.55);
            transition: transform .45s cubic-bezier(.2,.9,.3,1.25), opacity .25s ease;
        }
        .selection-bar.show { transform: translate(-50%, 0) scale(1); opacity: 1; pointer-events: auto; }
        .selection-bar .label  { color: #fff; font-weight: 600; line-height: 1.2; }
        .selection-bar .sublabel { color: #DDD0FF; font-size: .8rem; }
        .count-pill {
            min-width: 2.5rem; height: 2.5rem; border-radius: 50%;
            display: inline-flex; align-items: center; justify-content: center;
            background: #fff; color: #4C1D95; font-weight: 700; font-size: 1.05rem;
        }
        .count-pill.bump { animation: bump .4s cubic-bezier(.2,.9,.3,1.6); }
        .btn-bar {
            background: #fff; color: #4C1D95; border: 0; border-radius: .6rem;
            font-weight: 600; padding: .45rem .9rem;
            transition: transform .2s, box-shadow .2s;
        }
        .btn-bar:hover { transform: translateY(-2px); box-shadow: 0 6px 14px rgba(0,0,0,.25); }

        .alert { animation: alertIn .4s ease both; }

        /* ===== Animasi ===== */
        @keyframes pageIn   { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: none; } }
        @keyframes rowIn    { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: none; } }
        @keyframes alertIn  { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: none; } }
        @keyframes checkPop { 0% { transform: scale(.7); } 60% { transform: scale(1.25); } 100% { transform: scale(1); } }
        @keyframes selFlash { from { background-color: #C4B5FD; } to { background-color: #EDE4FF; } }
        @keyframes bump     { 0% { transform: scale(1); } 40% { transform: scale(1.35); } 100% { transform: scale(1); } }
        @keyframes pulseDot { 0%, 100% { opacity: 1; } 50% { opacity: .25; } }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration: .01ms !important; transition-duration: .01ms !important; }
        }

                /* ===== Mode lebar: tabel besar, latar hanya tersisa sedikit di kiri-kanan ===== */
        body.wide .container {
            width: calc(100% - 4rem);
            max-width: 1700px !important;
            margin-inline: auto;
        }
        @media (max-width: 767.98px) {
            body.wide .container { width: 100%; }
        }
        body.wide main.container { padding: 2rem 2.25rem; }
        body.wide h1.hero-title { font-size: 1.9rem; }

        /* tabel lebih besar dan lega */
        body.wide .table-books { font-size: 1rem; }
        body.wide .table-books thead th { font-size: .85rem; padding: 1.1rem .9rem; }
        body.wide .table-books td { padding: 1.2rem .9rem; }
        body.wide .table-books .small { font-size: .88rem; }
        body.wide .col-no { width: 120px; }
        body.wide .no-num { font-size: 1.05rem; }
        body.wide .isbn { font-size: .9rem; padding: .3rem .6rem; }
        body.wide .badge-del { font-size: .85rem; padding: .5em .95em; }
        body.wide .stok { font-size: .9rem; padding: .4rem .85rem; }
        body.wide .form-check-input { width: 1.35rem; height: 1.35rem; }
        body.wide .aksi { gap: .5rem; }
        body.wide .aksi .btn {
            width: 2.5rem; height: 2.5rem; padding: 0; font-size: 1.05rem;
            display: inline-flex; align-items: center; justify-content: center;
        }
        body.wide .search-box input { min-width: 320px; padding-top: .7rem; padding-bottom: .7rem; }
        body.wide .btn-del { padding: .7rem 1.3rem; }

                .stat-card {
            display: flex; align-items: center; gap: 1rem; padding: 1rem 1.2rem;
            background: linear-gradient(135deg, #F8F5FF, #fff); border: 1px solid #E8DEFF; border-radius: 1rem;
            animation: rowIn .45s ease both; animation-delay: var(--d, 0ms);
            transition: transform .2s, box-shadow .2s;
        }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(76,29,149,.15); }
        .stat-card > i {
            font-size: 1.5rem; color: #4C1D95; background: #EDE4FF;
            width: 3rem; height: 3rem; display: flex; align-items: center; justify-content: center; border-radius: .8rem;
        }
        .stat-num { font-size: 1.5rem; font-weight: 700; line-height: 1.1; }
        .stat-label { font-size: .8rem; color: #6b6485; }

        </style>
</head>
<body class="{{ ($wide ?? false) ? 'wide' : '' }}">
    <nav class="navbar navbar-expand-lg navbar-dark navbar-del mb-4 sticky-top">
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

    <main class="container">
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-4 alert-dismissible fade show">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger border-0 shadow-sm rounded-4 alert-dismissible fade show">
                <i class="bi bi-x-circle-fill me-2"></i>{{ session('error') }}
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

    <footer class="footer-del text-center small pb-4">
        © {{ date('Y') }} SIPUS-Del · Institut Teknologi Del
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>