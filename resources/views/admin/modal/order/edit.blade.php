<div class="modal fade" id="editOrderModal{{ $data->id }}" tabindex="-1"
    aria-labelledby="editOrderModalLabel{{ $data->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editOrderModalLabel{{ $data->id }}">Edit Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('/order/' . $data->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="produk_id" class="form-label">Produk</label>
                        <select name="produk_id" id="produk_id"
                            class="form-select @error('produk_id') is-invalid @enderror" required>
                            <option value="" disabled selected>Pilih Produk</option>
                            @foreach ($produks as $produk)
                                <option value="{{ $produk->id }}"
                                    {{ old('produk_id', $data->produk_id) == $produk->id ? 'selected' : '' }}>
                                    {{ $produk->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('produk_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah</label>
                        <input type="number" name="jumlah" id="jumlah"
                            class="form-control @error('jumlah') is-invalid @enderror"
                            value="{{ old('jumlah', $data->jumlah) }}" required>
                        @error('jumlah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_pesan" class="form-label">Tanggal Pesan</label>
                        <input type="date" name="tanggal_pesan" id="tanggal_pesan"
                            class="form-control @error('tanggal_pesan') is-invalid @enderror"
                            value="{{ old('tanggal_pesan', $data->tanggal_pesan->format('Y-m-d')) }}" required>

                        @error('tanggal_pesan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update Bahan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
