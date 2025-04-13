<div class="modal fade" id="editUserModal{{ $data->id }}" tabindex="-1" aria-labelledby="editUserModalLabel{{ $data->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel{{ $data->id }}">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('/user/' . $data->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name{{ $data->id }}" class="form-label">Nama</label>
                        <input type="text" name="name" id="name{{ $data->id }}"
                            class="form-control" value="{{ $data->name }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="email{{ $data->id }}" class="form-label">Email</label>
                        <input type="email" name="email" id="email{{ $data->id }}"
                            class="form-control" value="{{ $data->email }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="password{{ $data->id }}" class="form-label">Password (biarkan kosong jika tidak diubah)</label>
                        <input type="password" name="password" id="password{{ $data->id }}"
                            class="form-control">
                    </div>

                    <div class="mb-4">
                        <label for="role{{ $data->id }}" class="form-label">Role</label>
                        <select name="role" id="role{{ $data->id }}" class="form-select" required>
                            <option value="admin" {{ $data->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="produksi" {{ $data->role == 'produksi' ? 'selected' : '' }}>Produksi</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update User</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
