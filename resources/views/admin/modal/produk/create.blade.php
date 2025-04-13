<div class="modal fade" id="createProdukModal" tabindex="-1" aria-labelledby="createProdukModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createProdukModalLabel">Tambah Produk Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <form action="{{ url('/create-produk') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" name="nama" id="nama"
                                class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}"
                                required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga</label>
                            <input type="text" name="harga" id="harga"
                                class="form-control @error('harga') is-invalid @enderror" value="{{ old('harga') }}"
                                required>
                            @error('harga')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror"
                                required>{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="waktu_produk" class="form-label">Rata" Kadaluarsa</label>
                            <input type="number" name="waktu_produk" id="waktu_produk"
                                class="form-control @error('waktu_produk') is-invalid @enderror"
                                value="{{ old('waktu_produk') }}" required>
                            @error('waktu_produk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Bahan Baku Section -->
                        <div class="mb-3">
                            <label class="form-label">Bahan Baku</label>
                            <div class="card">
                                <div class="card-body">
                                    <p class="text-muted small">Pilih maksimal 5 bahan baku yang digunakan.</p>

                                    @foreach($bahanBaku as $index => $bahan)
                                    <div class="row mb-2 align-items-center">
                                        <div class="col-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="bahan_baku[{{ $index }}][id]"
                                                    id="bahan{{ $bahan->id }}"
                                                    value="{{ $bahan->id }}">
                                                <label class="form-check-label" for="bahan{{ $bahan->id }}">
                                                    {{ $bahan->nama_bahan }} (Stok: {{ $bahan->stok }})
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <input type="number"
                                                name="bahan_baku[{{ $index }}][jumlah]"
                                                class="form-control form-control-sm"
                                                placeholder="Jumlah"
                                                min="1">
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
                            <button type="submit" class="btn btn-primary">Tambah Produk</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
