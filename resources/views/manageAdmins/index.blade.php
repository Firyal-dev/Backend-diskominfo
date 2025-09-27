{{-- INDEX VIEW - admin-index.blade.php --}}
@extends('layouts.dashboard')

@section('content')
<div class="page-title">
    <div class="row">
        <div class="col-12">
            <h3>Manajemen Admin</h3>
            <p class="text-subtitle text-muted">Daftar semua admin yang terdaftar</p>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-3">Daftar Admin</h5>

        {{-- Search and Add Admin Section --}}
        <div class="row g-2">
            {{-- Search Form --}}
            <div class="col-12 col-lg-8">
                <form action="{{ route('manageAdmins.index') }}" method="GET" class="d-flex flex-column flex-sm-row gap-2">
                    <input type="search" name="search" value="{{ request('search') }}"
                        class="form-control" placeholder="Cari nama/email">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="bi bi-search d-sm-none"></i>
                            <span class="d-none d-sm-inline">Search</span>
                        </button>
                        @if(request('search'))
                        <a href="{{ route('manageAdmins.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle d-sm-none"></i>
                            <span class="d-none d-sm-inline">Reset</span>
                        </a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- Add Admin Button --}}
            <div class="col-12 col-lg-4">
                <a href="{{ route('manageAdmins.create') }}" class="btn btn-primary w-100 w-lg-auto">
                    <i class="bi bi-plus-circle me-1"></i>
                    Tambah Admin
                </a>
            </div>
        </div>
    </div>

    <div class="card-body p-0">
        {{-- Desktop Table View --}}
        <div class="d-none d-lg-block">
            <div class="table-responsive p-3">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Tanggal dibuat</th>
                            <th>Level</th>
                            <th width="200">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $user->level === 'Superadmin' ? 'primary' : 'secondary' }}">
                                    {{ $user->level }}
                                </span>
                            </td>
                            <td>
                                @if(Auth::id() === $user->id)
                                <span class="badge bg-success">Active User</span>
                                @else
                                <div class="btn-group" role="group">
                                    <a href="{{ route('manageAdmins.edit', $user->id) }}"
                                        class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <form action="{{ route('manageAdmins.destroy', $user->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus admin ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                Tidak ada admin ditemukan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Mobile Card View --}}
        <div class="d-lg-none">
            @forelse($users as $user)
            <div class="card border-0 border-bottom rounded-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h6 class="card-title mb-0">{{ $user->name }}</h6>
                        <span class="badge bg-{{ $user->level === 'Superadmin' ? 'primary' : 'secondary' }}">
                            {{ $user->level }}
                        </span>
                    </div>

                    <p class="card-text text-muted small mb-2">
                        <i class="bi bi-envelope me-1"></i>{{ $user->email }}
                    </p>

                    <p class="card-text text-muted small mb-3">
                        <i class="bi bi-calendar me-1"></i>{{ $user->created_at->format('d/m/Y H:i') }}
                    </p>

                    <div class="d-flex gap-2">
                        @if(Auth::id() === $user->id)
                        <span class="badge bg-success">Active User</span>
                        @else
                        <a href="{{ route('manageAdmins.edit', $user->id) }}"
                            class="btn btn-sm btn-warning flex-fill">
                            <i class="bi bi-pencil me-1"></i>Edit
                        </a>
                        <form action="{{ route('manageAdmins.destroy', $user->id) }}" method="POST"
                            class="flex-fill" onsubmit="return confirm('Apakah Anda yakin ingin menghapus admin ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger w-100">
                                <i class="bi bi-trash me-1"></i>Hapus
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-5">
                <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
                <p class="text-muted">Tidak ada admin ditemukan</p>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($users->hasPages())
        <div class="card-footer">
            <div class="d-flex justify-content-center">
                {{ $users->links() }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection