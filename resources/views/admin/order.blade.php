@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            @include('admin.modal.order.create')
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
                        <th scope="col">Produk</th>
                        <th scope="col">Jumlah</th>
                        <th scope="col">Total</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Status</th>
                        <th scope="col" style=" text-align: center; vertical-align: middle;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order as $data)
                        <tr>
                            <th scope="row">
                                {{ $loop->iteration }}
                            </th>
                            <td>
                                {{ $data->produk->nama ?? 'Produk Tidak Ada' }}
                            </td>
                            <td>
                                {{ $data->jumlah }}
                            </td>
                            <td>
                                Rp. {{ $data->total_harga }}
                            </td>
                            <td>
                                {{ $data->tanggal_pesan->format('d-m-Y') }}
                            </td>
                            <td>
                                {{ $data->status }}
                            </td>
                            <td class="text-center">
                                <a class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#editOrderModal{{ $data->id }}">Edit</a>
                                <form action="{{ url('/order/' . $data->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @include('admin.modal.order.edit')
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-between  mt-4 ">
                {{ $order->links('pagination::bootstrap-5') }}
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createOrderModal">
                    Tambah Order Baru
                </button>
            </div>
        </div>
    </div>
@endsection
