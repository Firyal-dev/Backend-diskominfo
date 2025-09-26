@extends('layouts.dashboard')

@section('content')

@include('manageAdmins.header')

<section class="section">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">
                Daftar Admin
            </h5>
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

</section>
@endsection