<div class="modal fade" id="editBahanModal{{ $data->id }}" tabindex="-1" aria-labelledby="editBahanModalLabel{{ $data->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBahanModalLabel{{ $data->id }}">Edit Bahan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('/bahan/' . $data->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nama_bahan{{ $data->id }}" class="form-label">Nama Bahan</label>
                        <input type="text" name="nama_bahan" id="nama_bahan{{ $data->id }}"
                            class="form-control" value="{{ $data->nama_bahan }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="stok{{ $data->id }}" class="form-label">Stok</label>
                        <input type="number" name="stok" id="stok{{ $data->id }}" value="{{ $data->stok }}"
                            class="form-control">
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
