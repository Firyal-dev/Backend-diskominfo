<!-- Album View -->
<div x-show="view === 'album'">
    <form id="bulk-delete-form" method="POST" action="{{ route('album.bulk-delete') }}">
        @csrf
        <div class="row">
            @forelse($albums as $album)
            <div class="col-12 col-md-6 mb-4">
                <div class="card h-100 border" :class="selectedAlbums.includes('{{ $album->id }}') ? 'border-primary' : 'border-light'">
                    <!-- checkbox -->
                    <div class="form-check position-absolute top-0 start-0 m-2">
                        <input
                            type="checkbox"
                            class="form-check-input album-checkbox"
                            value="{{ $album->id }}"
                            :value="{{ $album->id }}"
                            x-model="selectedAlbums"
                            @click.stop>
                    </div>
                    <img
                        class="card-img-top"
                        style="height: 300px; object-fit: cover;"
                        src="{{ $album->cover_url ?? asset('img/placeholder.webp') }}"
                        alt="{{ $album->nama }}">

                    <div class="card-body mb-0">
                        <div class="d-flex justify-content-between align-items-start">
                            <h5 class="card-title mb-0">{{ $album->nama }}</h5>
                            <span class="badge bg-primary">{{ $album->kontens_count ?? 0 }} Foto</span>
                        </div>
                        <p class="card-text text-muted">
                            {{ $album->deskripsi ?? 'Tidak ada deskripsi' }}
                        </p>
                    </div>
                    <div class="card-footer pt-0">
                        <a href="#" class="btn btn-outline-primary w-100">Lihat Album</a>
                    </div>

                </div>
            </div>

            @empty
            <div class="col-12 text-center">
                <p class="text-muted">Belum ada album.</p>
            </div>
            @endforelse

            <!-- hidden input buat submit ke server -->
            <template x-for="id in selectedAlbums" :key="id">
                <input type="hidden" name="selected_albums[]" :value="id">
            </template>
        </div>
    </form>
</div>