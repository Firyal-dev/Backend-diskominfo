@extends('layouts.dashboard')

@section('content')
<div class="page-heading">
    <h3>Tambah Album Baru</h3>
</div>
<div class="page-content">
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Tambah Album baru</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('album.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-12">
                                <label for="first-judul-vertical">Nama Album</label>
                                <input type="text" id="first-judul-vertical" class="form-control"
                                    name="nama" placeholder="Nama Album" required>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="email-id-vertical">Cover Album</label>
                                    <input type="file" id="foto-id-vertical" class="form-control"
                                        name="cover_album_url" placeholder="Cover Album">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary me-1 mb-1">Simpan</button>
                            <a href="{{ route('content.index') }}" class="btn btn-light-secondary me-1 mb-1">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection