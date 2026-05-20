@extends('layouts.masterAdmin')

@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-start mb-3">
        <a href="{{ route('hakakses.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-1"></i> Tambah Hak Akses
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0 text-dark font-weight-bold">Manajemen Hak Akses</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th width="40%">Role</th>
                            <th width="35%">Memiliki Menu?</th>
                            <th width="25%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                   <tbody>
    @foreach($roles as $role)
    <tr>
        <td>{{ $role->name }}</td>
        
        <td>
            <span class="badge bg-info text-dark text-capitalize">{{ $role->role }}</span>
        </td>
        
        <td>
            <a href="{{ route('hakakses.view', $role->id) }}" class="btn btn-success btn-sm">
                <i class="fas fa-eye"></i> View
            </a>
            <a href="{{ route('hakakses.edit', $role->id) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Edit
            </a>
        </td>
    </tr>
    @endforeach
</tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection