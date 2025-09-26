<div class="card-header d-flex border-bottom align-items-center">
    <div class="d-flex flex-column flex-md-row justify-content-between w-100 gap-2">
        <div>
            <!-- Button galeri -->
            <div x-show="view === 'galeri'">
                <div class="d-flex gap-2">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#galeri">Tambah Foto</button>
                    <form id="deleteGaleriForm" action="{{ route('content.deleteGaleri') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" id="deleteGaleriBtn" disabled>
                            <i class="bi bi-trash-fill"></i> Hapus Foto
                            <span id="selectedCountGaleri" class="badge bg-light text-dark ms-1" style="display:none;">0</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Button album -->
            <div x-show="view === 'album'">
                <div class="d-flex gap-2">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#album">Buat Album</button>
                    <form id="deleteAlbumForm" action="{{ route('content.deleteAlbum') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" id="deleteAlbumBtn"><i class="bi bi-trash-fill"></i> Hapus Album
                            <span id="selectedCountAlbum" class="badge bg-light text-dark ms-1" style="display:none;">0</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Back button in photos album -->
            <div x-show="view === 'album-photos'">
                <button class="btn btn-secondary" @click="view = 'album'">
                    <i class="bi bi-arrow-left"></i> Kembali ke Album
                </button>
            </div>

            <!-- Button photos in album -->
            <div x-show="view === 'album-photos'">
                <div class="d-flex gap-2">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#photos-album">Masukkan Foto</button>
                    <form id="deletePhotosAlbumForm" action="{{ route('content.deleteAlbumPhotos') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" id="deletePhotosAlbumBtn">
                            <i class="bi bi-trash-fill"></i> Hapus Foto
                            <span id="selectedCountPhotosAlbum" class="badge bg-light text-dark ms-1" style="display:none;">0</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- toggle gallery/album -->
        <div x-show="view !== 'album-photos'" class="btn-group" role="group" aria-label="Basic outlined example">
            <button type="button" @click="view = 'galeri'"
                :class="view === 'galeri' ? 'btn btn-outline-primary active' : 'btn btn-outline-primary'">
                Galeri
            </button>
            <button type="button" @click="view = 'album'"
                :class="view === 'album' ? 'btn btn-outline-primary active' : 'btn btn-outline-primary'">
                Album
            </button>
        </div>
    </div>
</div>