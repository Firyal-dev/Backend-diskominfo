@extends('layouts.dashboard')

@section('content')
<div class="page-heading">
    <h3>Masukkan foto</h3>
</div>
<div class="page-content">
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Masukkan foto</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('album.photos.store', $album->id) }}" method="POST">
                    @csrf

                    <div class="row gallery">
                        @forelse ($galeris as $index => $galeri)
                        <div class="col-6 col-sm-6 col-lg-3 mt-2 mt-md-0 mb-md-0 mb-2 p-2">
                            <label class="position-relative d-block">
                                <input type="checkbox" name="selected_galeri[]" value="{{ $galeri->id }}"
                                    class="form-check-input position-absolute top-0 end-0 m-2" style="z-index:2;">
                                <img class="w-100" role="button" src="{{ asset('storage/' . $galeri->file_path) }}" alt="{{ $galeri->judul }}">
                            </label>
                        </div>
                        @empty
                        <div class="col-12">
                            <h5 class="text-center">Upload foto terlebih dulu di Galeri</h5>
                        </div>
                        @endforelse
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">
                            <span class="d-none d-sm-block">Simpan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection