<!-- Gallery View -->
<div x-show="view === 'gallery'">
    <form id="bulk-delete-form" method="POST" action="{{ route('content.bulk-delete') }}">
        @csrf

        <div class="row">
            @forelse($kontens as $konten)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                <div
                    class="card h-100 border"
                    :class="selectedPhotos.includes('{{ $konten->id }}') ? 'border-primary' : 'border-light'"
                    @click="togglePhoto('{{ $konten->id }}')"
                    style="cursor: pointer;">
                    <img class="card-img-top" src="{{ $konten->file_url }}" alt="{{ $konten->judul }}">

                    <div class="card-body p-2">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="card-title mb-1">{{ $konten->judul }}</h6>
                                <small class="text-muted">{{ $konten->created_at->format('d M Y') }}</small>
                            </div>
                        </div>
                        <!-- update btn -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updatePhotoModal" data-id="{{ $konten->id }}" data-judul="{{ $konten->judul }}"
                            data-deskripsi="{{ $konten->deskripsi }}"
                            data-foto="{{ asset('storage/'.$konten->foto) }}" @click.stop>
                            <i class=" bi bi-pen"></i>
                        </button>
                    </div>

                    <!-- Checkbox -->
                    <div class="form-check position-absolute top-0 start-0 m-2">
                        <input
                            type="checkbox"
                            class="form-check-input photo-checkbox"
                            value="{{ $konten->id }}"
                            x-model="selectedPhotos"
                            @click.stop>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <p class="text-muted">Belum ada foto.</p>
            </div>
            @endforelse
        </div>

        <!-- Hidden input untuk submit selected -->
        <template x-for="id in selectedPhotos" :key="id">
            <input type="hidden" name="selected_photos[]" :value="id">
        </template>
    </form>
</div>