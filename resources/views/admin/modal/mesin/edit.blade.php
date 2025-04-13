<div class="modal fade" id="editMesinModal{{ $data->id }}" tabindex="-1" aria-labelledby="editMesinModalLabel{{ $data->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMesinModalLabel{{ $data->id }}">Edit Mesin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('/mesin/' . $data->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nama{{ $data->id }}" class="form-label">Nama</label>
                        <input type="text" name="nama" id="nama{{ $data->id }}"
                            class="form-control" value="{{ $data->nama }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="tipe{{ $data->id }}" class="form-label">Tipe</label>
                        <input type="text" name="tipe" id="tipe{{ $data->id }}"
                            class="form-control" value="{{ $data->tipe }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="kapasitas{{ $data->id }}" class="form-label">Kapasitas</label>
                        <input type="number" name="kapasitas" id="kapasitas{{ $data->id }}" value="{{ $data->kapasitas }}"
                            class="form-control">
                    </div>

                    <div class="mb-4">
                        <label for="status{{ $data->id }}" class="form-label">Status</label>
                        <select name="status" id="status{{ $data->id }}" class="form-select" required>
                            <option value="aktif" {{ $data->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ $data->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            <option value="perawatan" {{ $data->status == 'perawatan' ? 'selected' : '' }}>Perawatan</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update Mesin</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
