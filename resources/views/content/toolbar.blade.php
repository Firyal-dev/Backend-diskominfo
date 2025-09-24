<div class="card-header d-flex border-bottom align-items-center">
    <div class="d-flex justify-content-between w-100">
        <!-- Button yang muncul sesuai view -->
        <div>
            <div x-show="view === 'galeri'">
                <div class="d-flex gap-2">
                    <form action="" method="post">
                        @csrf
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#default">Tambah Foto</button>
                    </form>
                    <form action="" method="post">
                        @csrf
                        <button class="btn btn-danger"><i class="bi bi-trash-fill"></i> Hapus Foto</button>
                    </form>
                </div>
            </div>

            <div x-show="view === 'album'">
                <div class="d-flex gap-2">
                    <form action="" method="post">
                        @csrf
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#">Buat Album</button>
                    </form>
                    <form action="" method="post">
                        @csrf
                        <button class="btn btn-danger"><i class="bi bi-trash-fill"></i> Hapus Album</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- toggle gallery/album -->
        <div class="btn-group" role="group" aria-label="Basic outlined example">
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