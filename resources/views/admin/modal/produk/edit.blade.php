<div class="modal fade" id="editProdukModal{{ $data->id }}" tabindex="-1"
    aria-labelledby="editProdukModalLabel{{ $data->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProdukModalLabel{{ $data->id }}">Edit Produk</h5>
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
                            value="{{ $data->waktu_produk }}" class="form-control" required>
                    </div>

                    <!-- Bahan Baku Section -->
                    <div class="mb-3">
                        <label class="form-label">Bahan Baku</label>
                        <div class="card">
                            <div class="card-body">
                                <p class="text-muted small">Pilih bahan baku yang digunakan untuk produk ini.</p>

                                @foreach($bahanBaku as $index => $bahan)
                                <div class="row mb-2 align-items-center">
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="bahan_baku[{{ $index }}][id]"
                                                id="bahan{{ $data->id }}_{{ $bahan->id }}"
                                                value="{{ $bahan->id }}"
                                                {{ $data->bahanBaku->contains('id', $bahan->id) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="bahan{{ $data->id }}_{{ $bahan->id }}">
                                                {{ $bahan->nama_bahan }} (Stok: {{ $bahan->stok }})
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <input type="number"
                                            name="bahan_baku[{{ $index }}][jumlah]"
                                            class="form-control form-control-sm"
                                            placeholder="Jumlah"
                                            min="1"
                                            value="{{ $data->bahanBaku->where('id', $bahan->id)->first() ? $data->bahanBaku->where('id', $bahan->id)->first()->pivot->jumlah : '' }}">
                                    </div>
                                </div>
                                @endforeach

                                @error('bahan_baku')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
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
