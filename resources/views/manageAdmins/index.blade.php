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
        <h5 class="card-title">
            Daftar Admin
        </h5>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahAdmin">Tambah Admin</button>
    </div>
    <div class="card-body">
        <table class="table table-striped" id="table1">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Tanggal dibuat</th>
                    <th>Level</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td>{{ $user->level }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">No admins found</td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>
@endsection