@extends('layouts.dashboard')

@section('title', 'Tambah Menu Baru')

@section('content')
    <div class="page-heading">
        <h3>Tambah Menu Baru</h3>
    </div>
    <div class="page-content">
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Formulir Menu</h4>
                </div>
                <div class="card-body">
                    {{-- Menampilkan pesan error validasi jika ada --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('menu.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">

                                {{-- Input Nama Menu --}}
                                <div class="form-group mb-3">
                                    <label for="nama" class="form-label">Nama Menu</label>
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        value="{{ old('nama') }}" required>
                                </div>

                                {{-- Input Urutan --}}
                                <div class="form-group mb-3">
                                    <label for="urutan" class="form-label">Urutan</label>
                                    <input type="number" class="form-control" id="urutan" name="urutan"
                                        value="{{ old('urutan', 0) }}" required>
                                </div>

                                {{-- Pilihan Kategori --}}
                                <div class="form-group mb-3">
                                    <label for="kategori" class="form-label">Kategori</label>
                                    <select class="form-select" id="kategori" name="kategori" required>
                                        <option value="statis" {{ old('kategori') == 'statis' ? 'selected' : '' }}>Statis
                                        </option>
                                        <option value="dinamis" {{ old('kategori') == 'dinamis' ? 'selected' : '' }}>Dinamis
                                        </option>
                                        <option value="dinamis-tabel"
                                            {{ old('kategori') == 'dinamis-tabel' ? 'selected' : '' }}>Dinamis (Tabel)
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="tipe_tampilan" class="form-label">Tipe Tampilan (untuk Kategori
                                        Dinamis)</label>
                                    <select class="form-select" id="tipe_tampilan" name="tipe_tampilan" required>
                                        <option value="card" {{ old('tipe_tampilan') == 'card' ? 'selected' : '' }}>Card
                                        </option>
                                        <option value="list" {{ old('tipe_tampilan') == 'list' ? 'selected' : '' }}>List
                                        </option>
                                        <option value="tabel" {{ old('tipe_tampilan') == 'tabel' ? 'selected' : '' }}>Tabel
                                        </option>
                                    </select>
                                </div>

                                {{-- Pilihan Menu Induk (Parent) --}}
                                <div class="form-group mb-3">
                                    <label for="parent_id" class="form-label">Menu Induk (Parent)</label>
                                    <select class="form-select" id="parent_id" name="parent_id">
                                        <option value="">-- Tidak Ada --</option>
                                        @foreach ($parentMenus as $parent)
                                            <option value="{{ $parent->id }}"
                                                {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                                {{ $parent->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="col-12 d-flex justify-content-end gap-2">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="{{ route('menu.index') }}" class="btn btn-light-secondary">Batal</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
