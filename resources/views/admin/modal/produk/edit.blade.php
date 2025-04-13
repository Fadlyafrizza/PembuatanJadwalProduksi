<div class="modal fade" id="editProdukModal{{ $data->id }}" tabindex="-1"
    aria-labelledby="editProdukModalLabel{{ $data->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProdukModalLabel{{ $data->id }}">Edit Mesin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('/produk/' . $data->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nama{{ $data->id }}" class="form-label">Nama</label>
                        <input type="text" name="nama" id="nama{{ $data->id }}" class="form-control"
                            value="{{ $data->nama }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="harga{{ $data->id }}" class="form-label">Harga</label>
                        <input type="number" name="harga" id="harga{{ $data->id }}" class="form-control"
                            value="{{ $data->harga }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi{{ $data->id }}" class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi{{ $data->id }}" class="form-control @error('deskripsi') is-invalid @enderror" required>{{ $data->deskripsi }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="waktu_produk{{ $data->id }}" class="form-label">Rata" Kadaluarsa</label>
                        <input type="number" name="waktu_produk" id="waktu_produk{{ $data->id }}"
                            value="{{ $data->waktu_produk }}" class="form-control">
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update Produk</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
