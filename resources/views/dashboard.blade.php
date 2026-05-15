@extends('layouts.admin')

@section('title', 'Dashboard - Sewana')
@section('meta_description', 'Dashboard Sewana untuk membuka fitur sesuai hak akses akun.')

@section('content')
    <div class="admin-page">
        <div class="admin-page-header">
            <div>
                <span class="admin-page-eyebrow">Dashboard</span>
                <h1 class="admin-page-title">Selamat Datang di Sewana</h1>
                <p class="admin-page-subtitle">
                    Gunakan menu di sidebar untuk membuka fitur sesuai hak akses akun Anda.
                </p>
            </div>
            <a href="{{ route('profile.edit') }}" class="btn btn-dark rounded-pill px-4">
                <i class="bi bi-person-circle me-1"></i> Profil Saya
            </a>
        </div>

        <div class="admin-card">
            <div class="admin-card-body">
                <div class="d-flex align-items-center gap-3">
                    <div class="admin-icon-box bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-grid-1x2-fill"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-1">Akun aktif</h5>
                        <p class="text-muted mb-0">Anda sudah login. Halaman ini menjadi cadangan jika dashboard peran tidak tersedia.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
