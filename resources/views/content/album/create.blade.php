{{-- CREATE VIEW - album-create.blade.php --}}
@extends('layouts.dashboard')

@section('content')
<div class="page-title">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('album.index') }}">Album</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                </ol>
            </nav>
            <h3 class="h3 d-none d-sm-block">Tambah Album Baru</h3>
            <h5 class="d-sm-none">Tambah Album Baru</h5>
        </div>
    </div>
</div>

<div class="page-content">
    <section class="section">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('album.store') }}" method="POST" enctype="multipart/form-data" id="albumForm">
                            @csrf

                            <div class="form-group mb-3">
                                <label for="nama" class="form-label">Nama Album <span class="text-danger">*</span></label>
                                <input type="text" id="nama" class="form-control @error('nama') is-invalid @enderror"
                                    name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama album" required>
                                @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label for="cover_album_url" class="form-label">Cover Album</label>
                                <input type="file" id="cover_album_url" class="form-control @error('cover_album_url') is-invalid @enderror"
                                    name="cover_album_url" accept="image/*">
                                <div class="form-text">
                                    <small>
                                        <i class="bi bi-info-circle me-1"></i>
                                        Opsional. Format: JPG, JPEG, PNG, GIF. Maksimal 2MB
                                    </small>
                                </div>
                                @error('cover_album_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                {{-- Image Preview --}}
                                <div id="imagePreview" class="mt-3" style="display: none;">
                                    <label class="form-label">Preview:</label>
                                    <div class="border rounded p-2">
                                        <img id="previewImg" class="img-fluid rounded" style="max-height: 200px; max-width: 100%;">
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex flex-column flex-sm-row justify-content-end gap-2">
                                <a href="{{ route('album.index') }}" class="btn btn-light-secondary order-2 order-sm-1">
                                    <i class="bi bi-arrow-left me-1"></i>Batal
                                </a>
                                <button type="submit" class="btn btn-primary order-1 order-sm-2" id="submitBtn">
                                    <i class="bi bi-plus-circle me-1"></i>
                                    <span class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true"></span>
                                    Simpan Album
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

{{-- JavaScript --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('cover_album_url');
        const imagePreview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');
        const form = document.getElementById('albumForm');
        const submitBtn = document.getElementById('submitBtn');

        // Image preview functionality
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];

            if (file) {
                // Validate file type
                if (!file.type.startsWith('image/')) {
                    alert('File harus berupa gambar!');
                    fileInput.value = '';
                    imagePreview.style.display = 'none';
                    return;
                }

                // Validate file size (2MB)
                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran file tidak boleh lebih dari 2MB!');
                    fileInput.value = '';
                    imagePreview.style.display = 'none';
                    return;
                }

                // Create preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    imagePreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                imagePreview.style.display = 'none';
            }
        });

        // Form submission handling
        form.addEventListener('submit', function(e) {
            const spinner = submitBtn.querySelector('.spinner-border');
            const btnText = submitBtn.querySelector('i').nextSibling;

            // Show loading state
            submitBtn.disabled = true;
            spinner.classList.remove('d-none');
            btnText.textContent = ' Menyimpan...';
        });
    });
</script>

@endsection