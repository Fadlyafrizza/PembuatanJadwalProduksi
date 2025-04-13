<div class="modal fade" id="createBahanModal" tabindex="-1" aria-labelledby="createBahanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createBahanModalLabel">Tambah Bahan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <form action="{{ url('/create-bahan') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_bahan" class="form-label">Nama Bahan</label>
                            <input type="text" name="nama_bahan" id="nama_bahan"
                                class="form-control @error('nama_bahan') is-invalid @enderror"
                                value="{{ old('nama_bahan') }}" required>
                            @error('nama_bahan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="stok" class="form-label">Stok</label>
                            <input type="number" name="stok" id="stok"
                                class="form-control @error('stok') is-invalid @enderror" required>
                            @error('stok')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary ">Tambah Bahan</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
