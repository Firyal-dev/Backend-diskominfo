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
        <template x-if="view === 'album'">
            <div class="d-flex gap-2">
                <!-- Tambah Foto -->
                <button
                    class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#addAlbumModal">
                    Tambah Album
                </button>

                <!-- Bulk Delete -->
                <button
                    type="button"
                    class="btn btn-danger"
                    @click="deleteSelectedAlbums()"
                    :disabled="selectedAlbums.length === 0">
                    <i class="bi bi-trash-fill"></i>
                    <span x-show="selectedAlbums.length > 0" x-text="`Hapus (${selectedAlbums.length})`"></span>
                    <span x-show="selectedAlbums.length === 0">Hapus</span>
                </button>

                <!-- Checkbox pilih semua -->
                <div class="form-check align-self-center ms-2"
                    x-show="@if($albums->count() > 0) true @else false @endif">
                    <input
                        id="selectAllAlbums"
                        type="checkbox"
                        class="form-check-input"
                        x-model="selectAllAlbums"
                        @change="toggleSelectAllAlbums()">
                    <label class="form-check-label" for="selectAllAlbums">Pilih Semua</label>
                </div>
            </div>
        </template>
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