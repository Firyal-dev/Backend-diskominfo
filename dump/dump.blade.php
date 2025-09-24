@extends('layouts.dashboard')

@section('content')
<header class="mb-3">
    <a href="#" class="burger-btn d-block d-xl-none">
        <i class="bi bi-justify fs-3"></i>
    </a>
</header>

<div
    class="page-heading"
    x-data="{ 
        view: 'gallery',
        selectedPhotos: [],
        selectAll: false,
        toggleSelectAll() {
            if (this.selectAll) {
                this.selectedPhotos = Array.from(document.querySelectorAll('.photo-checkbox')).map(cb => cb.value);
            } else {
                this.selectedPhotos = [];
            }
        },
        togglePhoto(id) {
            const index = this.selectedPhotos.indexOf(id);
            if (index > -1) {
                this.selectedPhotos.splice(index, 1);
            } else {
                this.selectedPhotos.push(id);
            }
            this.selectAll = this.selectedPhotos.length === document.querySelectorAll('.photo-checkbox').length;
        },
        deleteSelected() {
            if (this.selectedPhotos.length === 0) {
                alert('Pilih foto yang ingin dihapus terlebih dahulu.');
                return;
            }
            
            if (confirm(`Anda yakin ingin menghapus ${this.selectedPhotos.length} foto yang dipilih?`)) {
                document.getElementById('bulk-delete-form').submit();
            }
        }
    }">
    <!-- Page title & breadcrumb -->
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Photo Gallery</h3>
                <p class="text-subtitle text-muted">Super simple photo gallery with albums.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Photo Gallery</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <!-- Header tombol -->
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <!-- Tombol galeri -->
                            <template x-if="view === 'gallery'">
                                <div class="d-flex gap-2">
                                    <!-- Tambah Foto -->
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPhotoModal">
                                        Tambah Foto
                                    </button>

                                    <!-- Bulk Delete -->
                                    <button
                                        type="button"
                                        class="btn btn-danger"
                                        @click="deleteSelected()"
                                        :disabled="selectedPhotos.length === 0">
                                        <i class="bi bi-trash-fill"></i>
                                        <span x-show="selectedPhotos.length > 0" x-text="`Hapus (${selectedPhotos.length})`"></span>
                                        <span x-show="selectedPhotos.length === 0">Hapus</span>
                                    </button>

                                    <!-- Select All -->
                                    <div
                                        class="form-check align-self-center ms-2"
                                        x-show="@if($kontens->count() > 0) true @else false @endif">
                                        <input
                                            id="selectAll"
                                            type="checkbox"
                                            class="form-check-input"
                                            x-model="selectAll"
                                            @change="toggleSelectAll()">
                                        <label class="form-check-label" for="selectAll">Pilih Semua</label>
                                    </div>
                                </div>
                            </template>

                            <!-- Tombol album -->
                            <button
                                x-show="view === 'album'"
                                class="btn btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#addAlbumModal">
                                Tambah Album
                            </button>
                        </div>

                        <!-- Toggle gallery/album -->
                        <div class="btn-group" role="group">
                            <button
                                class="btn"
                                :class="view === 'gallery' ? 'btn-primary' : 'btn-light'"
                                :disabled="view === 'gallery'"
                                @click="view = 'gallery'; selectedPhotos = []; selectAll = false;">
                                <i class="bi bi-grid-3x3-gap-fill"></i>
                            </button>
                            <button
                                class="btn"
                                :class="view === 'album' ? 'btn-primary' : 'btn-light'"
                                :disabled="view === 'album'"
                                @click="view = 'album'">
                                <i class="bi bi-grid-fill"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body">

                        {{-- GALERI --}}
                        <div x-show="view === 'gallery'">
                            <div class="row g-3">
                                @forelse($kontens as $konten)
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                    <div class="card h-100 shadow-sm border-0 position-relative">

                                        <!-- Checkbox -->
                                        <div class="position-absolute top-0 end-0 p-2" style="z-index: 10;">
                                            <input
                                                type="checkbox"
                                                class="form-check-input border-2 shadow-sm photo-checkbox"
                                                value="{{ $konten->id }}"
                                                @change="togglePhoto('{{ $konten->id }}')"
                                                :checked="selectedPhotos.includes('{{ $konten->id }}')">
                                        </div>

                                        <!-- Foto -->
                                        <div class="ratio ratio-4x3">
                                            <img
                                                src="{{ $konten->file_url }}"
                                                alt="{{ $konten->judul }}"
                                                class="card-img-top object-fit-cover rounded-top">
                                        </div>

                                        <!-- Info -->
                                        <div class="card-body px-3 py-2">
                                            <h6 class="card-title mb-1 text-truncate" style="font-size: 0.9rem;">
                                                {{ $konten->judul }}
                                            </h6>
                                            <small class="text-muted" style="font-size: 0.75rem;">
                                                {{ $konten->tgl_upload }}
                                            </small>
                                        </div>

                                        <!-- Tombol -->
                                        <div class="card-footer bg-white border-0 d-flex justify-content-between px-2 py-2">
                                            <a
                                                href="{{ route('content.edit', $konten->id) }}"
                                                class="btn btn-warning btn-sm d-flex align-items-center">
                                                <i class="bi bi-pen"></i>
                                            </a>
                                            <form action="{{ route('content.destroy', $konten->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    type="submit"
                                                    class="btn btn-danger btn-sm d-flex align-items-center"
                                                    onclick="return confirm('Yakin ingin menghapus foto ini?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                                @empty
                                <div class="col-12">
                                    <div class="alert alert-secondary text-center">Belum ada foto.</div>
                                </div>
                                @endforelse
                            </div>
                        </div>

                        {{-- ALBUM --}}
                        <div x-show="view === 'album'">
                            <div class="row g-3">
                                @forelse($albums as $album)
                                <div class="col-12 col-md-6">
                                    <div class="card shadow-sm border-0 position-relative">
                                        <!-- Badge jumlah foto -->
                                        <div class="position-absolute top-0 end-0 p-2" style="z-index: 10;">
                                            <span class="badge bg-primary">{{ $album->kontens_count ?? $album->konten_count ?? 0 }} Foto</span>
                                        </div>

                                        <img
                                            src="https://picsum.photos/800/400?random={{ $album->id }}"
                                            class="card-img-top rounded-top"
                                            alt="{{ $album->nama }}">

                                        <div class="card-body">
                                            <h5 class="card-title">{{ $album->nama }}</h5>
                                            <a
                                                href="{{ route('album.show', $album->id) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                Lihat Album
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="col-12">
                                    <div class="alert alert-secondary text-center">Belum ada album.</div>
                                </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Modal Tambah Foto -->
                        <div class="modal fade" id="addPhotoModal" tabindex="-1" aria-labelledby="addPhotoModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('content.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addPhotoModalLabel">Tambah Foto</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="judul" class="form-label">Judul</label>
                                                <input type="text" class="form-control" id="judul" name="judul" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                                <input type="text" class="form-control" id="deskripsi" name="deskripsi" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="file" class="form-label">Foto</label>
                                                <input type="file" class="form-control" id="file" name="file" accept="image/*" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Tambah Album -->
                        <div class="modal fade" id="addAlbumModal" tabindex="-1" aria-labelledby="addAlbumModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('album.store') }}" method="POST">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addAlbumModalLabel">Buat Album</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="nama" class="form-label">Nama Album</label>
                                                <input type="text" class="form-control" id="nama" name="nama" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                                <input type="text" class="form-control" id="deskripsi" name="deskripsi">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div> {{-- end card-body --}}
                </div>
            </div>
        </div>
    </section>
</div>
@endsection