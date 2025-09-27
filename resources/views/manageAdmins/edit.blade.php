@extends('layouts.dashboard')

@section('content')
<div class="page-heading">
    <h3>Edit Data Admin</h3>
</div>
<div class="page-content">
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Perbarui data admin</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('manageAdmins.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT') {{-- penting untuk update --}}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name', $user->name) }}" placeholder="Nama" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email"
                                    value="{{ old('email', $user->email) }}" placeholder="Email" required>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password">Password <small>(Kosongkan jika tidak ingin ganti)</small></label>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Password baru (opsional)" minlength="8">
                            </div>
                            <fieldset class="form-group">
                                <label for="level">Level</label>
                                <select class="form-select" id="level" name="level">
                                    <option value="Admin" {{ old('level', $user->level) == 'Admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="Superadmin" {{ old('level', $user->level) == 'Superadmin' ? 'selected' : '' }}>Superadmin</option>
                                </select>
                            </fieldset>
                        </div>
                        <div class="col-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary me-1 mb-1">Simpan</button>
                            <a href="{{ route('manageAdmins.index') }}" class="btn btn-light-secondary me-1 mb-1">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection