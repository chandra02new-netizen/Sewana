@extends('layouts.admin')

@section('title', 'Form Sewa Produk - Sewana')
@section('meta_description', 'Lengkapi data penyewa, varian, tanggal sewa, dan alamat untuk membuat pesanan Sewana.')

@section('content')
    @php
        $today = now()->toDateString();
        $availableVariantCount = $product->variants->where('stock', '>', 0)->count();
        $oldStartDate = old('start_date');
        $minimumEndDate = $oldStartDate && preg_match('/^\d{4}-\d{2}-\d{2}$/', $oldStartDate) && $oldStartDate >= $today
            ? $oldStartDate
            : $today;
    @endphp

    <div class="admin-page admin-page--wide">
        <div class="admin-page-header">
            <div>
                <span class="admin-page-eyebrow">Penyewaan</span>
                <h1 class="admin-page-title">Form Sewa Produk</h1>
                <p class="admin-page-subtitle">Pilih varian, tanggal sewa, dan lengkapi data identitas untuk membuat pesanan.</p>
            </div>
            <a href="{{ route('penyewa.products.index') }}" class="btn btn-outline-dark rounded-pill px-4">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger rounded-4 shadow-sm border-0">
                <ul class="mb-0">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Card utama --}}
        <div class="card shadow-sm border-0 rounded-4 order-summary admin-card">
            <div class="card-body p-4">
                <div class="row g-4">
                    {{-- Gambar Produk --}}
                    <div class="col-md-5 mb-3">
                        @if ($product->images->count())
                            <div id="carouselOrder{{ $product->id }}"
                                class="carousel slide border rounded order-summary__image">
                                <div class="carousel-inner">
                                    @foreach ($product->images as $key => $img)
                                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                            <img src="{{ asset('storage/' . $img->image_url) }}"
                                                class="d-block w-100 rounded"
                                                alt="Foto produk {{ $product->name }}"
                                                width="640" height="420"
                                                @if ($key === 0) fetchpriority="high" @else loading="lazy" @endif
                                                decoding="async">
                                        </div>
                                    @endforeach
                                </div>

                                @if ($product->images->count() > 1)
                                    <button class="carousel-control-prev" type="button"
                                        data-bs-target="#carouselOrder{{ $product->id }}" data-bs-slide="prev"
                                        aria-label="Gambar produk sebelumnya">
                                        <span class="carousel-control-prev-icon"></span>
                                    </button>
                                    <button class="carousel-control-next" type="button"
                                        data-bs-target="#carouselOrder{{ $product->id }}" data-bs-slide="next"
                                        aria-label="Gambar produk berikutnya">
                                        <span class="carousel-control-next-icon"></span>
                                    </button>
                                @endif
                            </div>
                        @else
                            <div
                                class="border rounded d-flex align-items-center justify-content-center bg-light order-summary__fallback">
                                <span class="text-muted">Tidak ada gambar</span>
                            </div>
                        @endif
                    </div>

                            {{-- Product details and form --}}
                    <div class="col-md-7 order-form-section">
                        <h2 class="h4 fw-bold text-dark">{{ $product->name }}</h2>
                        <p class="text-muted mb-3">{{ $product->description }}</p>
                        <span class="badge {{ $product->availabilityBadgeClass() }} mb-3">
                            {{ $product->availabilityLabel() }}
                        </span>

                        {{-- Form mulai di sini --}}
                        <form method="POST" action="{{ route('penyewa.orders.store') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            {{-- Nama Penyewa --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold" for="customer-name">Nama Penyewa</label>
                                <input type="text" id="customer-name" name="customer_name" class="form-control"
                                    value="{{ old('customer_name') }}" placeholder="Masukkan nama lengkap penyewa" required>
                            </div>

                            {{-- Foto Identitas --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold" for="identity-photo">Unggah Foto Identitas (KTP / SIM)</label>
                                <input type="file" id="identity-photo" name="identity_photo" class="form-control"
                                    accept="image/*" required>
                                <small class="text-muted">Format: JPG, PNG, maks</small>
                            </div>

                            {{-- Pilih Varian --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold" for="variant-id">Pilih Varian</label>
                                <select name="variant_id" id="variant-id" class="form-select" required
                                    {{ $availableVariantCount === 0 ? 'disabled' : '' }}>
                                    <option value="">-- Pilih Varian --</option>
                                    @foreach ($product->variants as $variant)
                                        <option value="{{ $variant->id }}"
                                            {{ old('variant_id') == $variant->id ? 'selected' : '' }}
                                            {{ $variant->stock <= 0 ? 'disabled' : '' }}>
                                            {{ $variant->size }} - {{ $variant->color }} |
                                            Rp{{ number_format($variant->price, 0, ',', '.') }}/hari
                                            ({{ $variant->stock > 0 ? 'Stok: ' . $variant->stock : 'Stok habis' }})
                                        </option>
                                    @endforeach
                                </select>
                                @if ($availableVariantCount === 0)
                                    <small class="text-danger">Semua varian produk ini sedang stok habis. Silakan pilih produk lain.</small>
                                @else
                                    <small class="text-muted">Varian dengan stok habis tidak dapat dipilih.</small>
                                @endif
                            </div>

                            {{-- Rental dates --}}
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold" for="start-date">Tanggal Mulai</label>
                                    <input type="date" id="start-date" name="start_date" class="form-control"
                                        value="{{ old('start_date') }}" min="{{ $today }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold" for="end-date">Tanggal Selesai</label>
                                    <input type="date" id="end-date" name="end_date" class="form-control"
                                        value="{{ old('end_date') }}" min="{{ $minimumEndDate }}" required>
                                </div>
                            </div>

                            {{-- Alamat --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold" for="address">Alamat Pengiriman / Penjemputan</label>
                                <textarea name="address" id="address" rows="3" class="form-control" placeholder="Masukkan alamat lengkap..." required>{{ old('address') }}</textarea>
                            </div>

                            {{-- Ringkasan --}}
                            <div class="border rounded-4 p-3 bg-light mb-3">
                                <p class="fw-semibold mb-1 text-dark">Ringkasan Sewa</p>
                                <ul class="list-unstyled mb-0 small text-muted">
                                    <li>Harga per hari mengikuti varian yang dipilih</li>
                                    <li>Total harga dihitung otomatis oleh sistem saat konfirmasi</li>
                                </ul>
                            </div>

                            {{-- Buttons --}}
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-dark flex-fill fw-semibold rounded-pill"
                                    {{ $availableVariantCount === 0 ? 'disabled' : '' }}>
                                    <i class="bi bi-cart-plus me-1"></i> Konfirmasi Sewa
                                </button>
                                <a href="{{ route('penyewa.products.index') }}"
                                    class="btn btn-outline-secondary flex-fill fw-semibold rounded-pill">
                                    Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection

@section('scripts')
    <script>
        const startDateInput = document.getElementById('start-date');
        const endDateInput = document.getElementById('end-date');

        if (startDateInput && endDateInput) {
            startDateInput.addEventListener('change', function () {
                endDateInput.min = this.value || startDateInput.min;

                if (endDateInput.value && this.value && endDateInput.value < this.value) {
                    endDateInput.value = this.value;
                }
            });
        }
    </script>
@endsection
