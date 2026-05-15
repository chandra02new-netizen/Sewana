@extends('layouts.admin')

@section('content')
    <div class="admin-page">
        <div class="admin-page-header">
            <div>
                <span class="admin-page-eyebrow">Akun</span>
                <h1 class="admin-page-title">Profil Saya</h1>
                <p class="admin-page-subtitle">Perbarui informasi akun, password, atau hapus akun jika diperlukan.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-dark rounded-pill px-4">
                <i class="bi bi-arrow-left me-1"></i> Dashboard
            </a>
        </div>

        <div class="row g-4">
            <div class="col-lg-7">
                <div class="admin-card h-100">
                    <div class="admin-card-header">
                        <span class="admin-page-eyebrow">Informasi Profil</span>
                        <h5 class="fw-bold text-dark mb-0 mt-1">Data Akun</h5>
                    </div>
                    <div class="admin-card-body">
                        @if (session('status') === 'profile-updated')
                            <div class="alert alert-success border-0 rounded-4">
                                <i class="bi bi-check-circle me-2"></i> Profil berhasil diperbarui.
                            </div>
                        @endif

                        <form method="POST" action="{{ route('profile.update') }}">
                            @csrf
                            @method('PATCH')

                            <div class="mb-3">
                                <label for="name" class="form-label admin-form-label">Nama</label>
                                <input id="name" name="name" type="text"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label admin-form-label">Email</label>
                                <input id="email" name="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $user->email) }}" required autocomplete="username">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                    <div class="admin-form-help mt-2">
                                        Email belum terverifikasi.
                                        <button form="send-verification" class="btn btn-link btn-sm p-0 align-baseline">
                                            Kirim ulang email verifikasi
                                        </button>
                                    </div>

                                    @if (session('status') === 'verification-link-sent')
                                        <div class="text-success small mt-2">Link verifikasi baru sudah dikirim.</div>
                                    @endif
                                @endif
                            </div>

                            <div class="admin-form-actions">
                                <button type="submit" class="btn btn-dark rounded-pill px-4">
                                    <i class="bi bi-save me-1"></i> Simpan Profil
                                </button>
                            </div>
                        </form>

                        <form id="send-verification" method="POST" action="{{ route('verification.send') }}">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="admin-card mb-4">
                    <div class="admin-card-header">
                        <span class="admin-page-eyebrow">Keamanan</span>
                        <h5 class="fw-bold text-dark mb-0 mt-1">Ubah Password</h5>
                    </div>
                    <div class="admin-card-body">
                        @if (session('status') === 'password-updated')
                            <div class="alert alert-success border-0 rounded-4">
                                <i class="bi bi-check-circle me-2"></i> Password berhasil diperbarui.
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="current_password" class="form-label admin-form-label">Password Saat Ini</label>
                                <input id="current_password" name="current_password" type="password"
                                    class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                                    autocomplete="current-password">
                                @error('current_password', 'updatePassword')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label admin-form-label">Password Baru</label>
                                <input id="password" name="password" type="password"
                                    class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                                    autocomplete="new-password">
                                @error('password', 'updatePassword')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label admin-form-label">Konfirmasi Password</label>
                                <input id="password_confirmation" name="password_confirmation" type="password"
                                    class="form-control" autocomplete="new-password">
                            </div>

                            <div class="admin-form-actions">
                                <button type="submit" class="btn btn-dark rounded-pill px-4">
                                    <i class="bi bi-shield-lock me-1"></i> Perbarui Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="admin-card border-danger border-opacity-25">
                    <div class="admin-card-header">
                        <span class="admin-page-eyebrow text-danger">Zona Berbahaya</span>
                        <h5 class="fw-bold text-dark mb-0 mt-1">Hapus Akun</h5>
                    </div>
                    <div class="admin-card-body">
                        <p class="text-muted small">
                            Setelah akun dihapus, semua data yang terkait dengan akun ini akan ikut terhapus permanen.
                        </p>

                        <form method="POST" action="{{ route('profile.destroy') }}"
                            onsubmit="return confirm('Yakin ingin menghapus akun ini secara permanen?')">
                            @csrf
                            @method('DELETE')

                            <div class="mb-3">
                                <label for="delete_password" class="form-label admin-form-label">Konfirmasi Password</label>
                                <input id="delete_password" name="password" type="password"
                                    class="form-control @error('password', 'userDeletion') is-invalid @enderror">
                                @error('password', 'userDeletion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-outline-danger rounded-pill px-4">
                                <i class="bi bi-trash me-1"></i> Hapus Akun
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
