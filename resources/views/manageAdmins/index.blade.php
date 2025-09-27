@extends('layouts.dashboard')

@section('content')
<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Manajemen Admin</h3>
            <p class="text-subtitle text-muted">Daftar semua admin yang terdaftar</p>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5 class="card-title">Daftar Admin</h5>
        <div class="d-flex">
            <form action="{{ route('manageAdmins.index') }}" method="GET" class="d-flex">
                <input type="search" name="search" value="{{ request('search') }}" class="form-control me-2" placeholder="Cari nama/email">
                <button type="submit" class="btn btn-outline-primary">Search</button>
                @if(request('search'))
                <a href="{{ route('manageAdmins.index') }}" class="btn btn-outline-secondary ms-2">Reset</a>
                @endif
            </form>
            <a href="{{ route('manageAdmins.create') }}" class="btn btn-primary ms-3">Tambah Admin</a>
        </div>
    </div>

    <div class="card-body">
        <table class="table table-striped" id="table1">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Tanggal dibuat</th>
                    <th>Level</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td>{{ $user->level }}</td>
                    <td>
                        @if(Auth::id() === $user->id)
                        <span class="badge bg-success">Active</span>
                        @else
                        <a href="{{ route('manageAdmins.edit', $user->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('manageAdmins.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus admin ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">No admins found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="d-flex justify-content-center mt-3">
            {{ $users->links() }}
        </div>

    </div>
</div>
@endsection