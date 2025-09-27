<div class="card-header d-flex border-bottom align-items-center">
    <div class="d-flex flex-column flex-md-row justify-content-between w-100 gap-2">
        <div>
            <!-- Button galeri -->
            

            <!-- Button album -->
            

            <!-- Back button in photos album -->


            <!-- Button photos in album -->
            
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