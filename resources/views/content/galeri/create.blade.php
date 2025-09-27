{{-- CREATE VIEW - gallery-create.blade.php --}}
@extends('layouts.dashboard')

@section('content')
<div class="page-title">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('galeri.index') }}">Galeri</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                </ol>
            </nav>
            <h3 class="h3 d-none d-sm-block">Tambah Foto Baru</h3>
            <h5 class="d-sm-none">Tambah Foto Baru</h5>
        </div>
    </div>
</div>

<div class="page-content">
    <section class="section">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('galeri.store') }}" method="POST" enctype="multipart/form-data" id="galleryForm">
                            @csrf

                            <div class="form-group mb-3">
                                <label for="judul" class="form-label">Judul <span class="text-danger">*</span></label>
                                <input type="text" id="judul" class="form-control @error('judul') is-invalid @enderror"
                                    name="judul" value="{{ old('judul') }}" placeholder="Masukkan judul foto" required>
                                @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label for="file_path" class="form-label">Foto <span class="text-danger">*</span></label>
                                <input type="file" id="file_path" class="form-control @error('file_path') is-invalid @enderror"
                                    name="file_path" accept="image/*" required>
                                <div class="form-text">
                                    <small>
                                        <i class="bi bi-info-circle me-1"></i>
                                        Format yang didukung: JPG, JPEG, PNG, GIF. Maksimal 2MB
                                    </small>
                                </div>
                                @error('file_path')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                {{-- Image Preview --}}
                                <div id="imagePreview" class="mt-3" style="display: none;">
                                    <label class="form-label">Preview:</label>
                                    <div class="border rounded p-2">
                                        <img id="previewImg" class="img-fluid rounded" style="max-height: 300px; max-width: 100%;">
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex flex-column flex-sm-row justify-content-end gap-2">
                                <a href="{{ route('galeri.index') }}" class="btn btn-light-secondary order-2 order-sm-1">
                                    <i class="bi bi-arrow-left me-1"></i>Batal
                                </a>
                                <button type="submit" class="btn btn-primary order-1 order-sm-2" id="submitBtn">
                                    <i class="bi bi-plus-circle me-1"></i>
                                    <span class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true"></span>
                                    Simpan Foto
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

{{-- JavaScript for image preview and form handling --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('file_path');
        const imagePreview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');
        const form = document.getElementById('galleryForm');
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

                // Validate file size (2MB = 2 * 1024 * 1024 bytes)
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

        // Reset form on page load if there are validation errors
        @if ($errors->any())
        // Restore old file preview if validation fails
        const oldFile = fileInput.files[0];
        if (oldFile) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                imagePreview.style.display = 'block';
            };
            reader.readAsDataURL(oldFile);
        }
        @endif
    });
</script>

<style>
    /* Custom styles for better mobile experience */
    @media (max-width: 575.98px) {
        .card-body {
            padding: 1rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .btn {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }

        #imagePreview img {
            max-height: 200px;
        }
    }

    /* Loading state styles */
    .btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }

    /* Image preview styles */
    #imagePreview {
        transition: all 0.3s ease;
    }

    #previewImg {
        object-fit: cover;
        border-radius: 0.375rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
</style>

@endsection