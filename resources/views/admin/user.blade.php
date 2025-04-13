@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            @include('admin.modal.user.create')
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col" style=" text-align: center; vertical-align: middle;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $data)
                        <tr>
                            <th scope="row">
                                {{ $loop->iteration }}
                            </th>
                            <td>
                                {{ $data->name }}
                            </td>
                            <td>
                                {{ $data->email }}
                            </td>
                            <td>
                                {{ $data->role }}
                            </td>
                            <td class="text-center">
                                <a class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#editUserModal{{ $data->id }}">Edit</a>
                                <form action="{{ url('/user/' . $data->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @include('admin.modal.user.edit')
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-between  mt-4 ">
                {{ $users->links('pagination::bootstrap-5') }}

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">
                    Tambah User Baru
                </button>
            </div>
        </div>
    </div>
@endsection
