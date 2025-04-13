@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <h2>Jadwal Produksi</h2>

            <h4 class="mt-4">Jadwal Produksi</h4>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Total Jumlah</th>
                        <th>Mesin</th>
                        <th>Waktu Mulai</th>
                        <th>Waktu Selesai</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($groupedJadwals as $jadwal)
                        <tr>
                            <td>{{ $jadwal['produk_nama'] }}</td>
                            <td>{{ $jadwal['total_jumlah'] }}</td>
                            <td>{{ $jadwal['mesin'] }}</td>
                            <td>{{ $jadwal['waktu_mulai'] ? date('d/m/Y H:i', strtotime($jadwal['waktu_mulai'])) : '-' }}
                            </td>
                            <td>{{ $jadwal['waktu_selesai'] ? date('d/m/Y H:i', strtotime($jadwal['waktu_selesai'])) : '-' }}
                            </td>
                            <td>
                                @if ($jadwal['status'] == 'scheduled')
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#modalJadwal{{ $jadwal['produk_id'] }}">
                                        Jadwalkan
                                    </button>

                                    <div class="modal fade" id="modalJadwal{{ $jadwal['produk_id'] }}" tabindex="-1"
                                        aria-labelledby="modalLabel{{ $jadwal['produk_id'] }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form action="{{ url('/jadwalkan/' . $jadwal['jadwal_ids'][0]) }}"
                                                method="POST" class="modal-content">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="produk_id" value="{{ $jadwal['produk_id'] }}">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalLabel{{ $jadwal['produk_id'] }}">
                                                        Jadwalkan Produksi</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Tutup"></button>
                                                </div>
                                                <div class="modal-body">
                                                    @php
                                                        $orders =
                                                            $groupedOrders->firstWhere(
                                                                'produk_id',
                                                                $jadwal['produk_id'],
                                                            )['orders'] ?? [];

                                                        $mesin = \App\Models\Mesin::where('status', 'aktif')->get();
                                                    @endphp
                                                    <div>
                                                        <label for="mesin_id">Pilih Mesin</label>
                                                        <select name="mesin_id" id="mesin_id" class="form-select">
                                                            @foreach ($mesin as $m)
                                                                <option value="{{ $m->id }}">{{ $m->nama }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mt-3">
                                                        <label for="waktu_mulai">Waktu Mulai</label>
                                                        <input type="datetime-local" name="waktu_mulai" id="waktu_mulai"
                                                            class="form-control" required>
                                                    </div>
                                                    <div class="mt-3">
                                                        <label for="waktu_selesai">Waktu Selesai</label>
                                                        <input type="datetime-local" name="waktu_selesai" id="waktu_selesai"
                                                            class="form-control" required>
                                                    </div>
                                                    <input type="hidden" name="orders"
                                                        value="{{ implode(',', $orders) }}">
                                                    <input type="hidden" name="all_jadwal_ids"
                                                        value="{{ implode(',', $jadwal['jadwal_ids']) }}">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Jadwalkan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @else
                                    @if ($jadwal['status'] == 'in_progress')
                                        <span class="">Sedang Produksi</span>
                                    @elseif($jadwal['status'] == 'completed')
                                        <span class="">Selesai</span>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
