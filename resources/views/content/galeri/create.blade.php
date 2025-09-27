@extends('layouts.dashboard')

@section('content')
<div class="page-heading">
    <h3>Tambah Foto Baru</h3>
</div>
<div class="page-content">
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Tambah foto baru ke dalam Galeri</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('galeri.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="first-judul-vertical">Judul</label>
                                <input type="text" id="first-judul-vertical" class="form-control"
                                    name="judul" placeholder="judul" required>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="email-id-vertical">Foto</label>
                                    <input type="file" id="foto-id-vertical" class="form-control"
                                        name="file_path" placeholder="Foto" required>
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