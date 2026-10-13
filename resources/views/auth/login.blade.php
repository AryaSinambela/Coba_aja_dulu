<x-layout title="Login Pustakawan">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card card-modern">
                <div class="card-body p-4 p-lg-5">
                    <div class="text-center mb-4">
                        <i class="bi bi-person-badge-fill text-del" style="font-size:2.5rem"></i>
                        <h1 class="h4 hero-title mt-2 mb-1">Login Pustakawan</h1>
                        <p class="text-muted small mb-0">Masuk untuk mengelola buku dan peminjaman.</p>
                    </div>

                    <form action="{{ route('login.attempt') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" autofocus
                                   value="{{ old('email', request()->cookie('del_last_user_email')) }}"
                                   class="form-control @error('email') is-invalid @enderror">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Password</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-check mb-4">
                            <input type="checkbox" name="remember" id="remember" class="form-check-input">
                            <label for="remember" class="form-check-label">Ingat saya</label>
                        </div>
                        <button class="btn btn-del w-100 py-2"><i class="bi bi-box-arrow-in-right me-1"></i>Masuk</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layout>