<div class="modal fade" id="createOrderModal" tabindex="-1" aria-labelledby="createOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createOrderModalLabel">Tambah Order Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Show errors if any -->
                @if($errors->has('stock_error'))
                <div class="alert alert-danger">
                    {{ $errors->first('stock_error') }}
                    <ul class="mt-2">
                        @foreach($errors->get('insufficient_bahan') as $bahan)
                            <li>{{ $bahan['nama'] }} - Tersedia: {{ $bahan['available'] }}, Dibutuhkan: {{ $bahan['required'] }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="card-body">
                    <form action="{{ url('/create-order') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="produk_id" class="form-label">Produk</label>
                            <select name="produk_id" id="produk_id"
                                class="form-select @error('produk_id') is-invalid @enderror" required>
                                <option value="" disabled selected>Pilih Produk</option>
                                @foreach ($produks as $produk)
                                    <option value="{{ $produk->id }}"
                                        {{ old('produk_id') == $produk->id ? 'selected' : '' }}>
                                        {{ $produk->nama }} - Rp {{ number_format($produk->harga, 0, ',', '.') }}
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
                                class="form-control @error('jumlah') is-invalid @enderror" value="{{ old('jumlah', 1) }}"
                                min="1" required>
                            @error('jumlah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_pesan" class="form-label">Tanggal Pesan</label>
                            <input type="date" name="tanggal_pesan" id="tanggal_pesan"
                                class="form-control @error('tanggal_pesan') is-invalid @enderror"
                                value="{{ old('tanggal_pesan', date('Y-m-d')) }}" required>
                            @error('tanggal_pesan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Product Information Section -->
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Informasi Bahan Baku Produk</h6>
                            </div>
                            <div class="card-body">
                                @if(old('produk_id'))
                                    @php
                                        $selectedProduct = $produks->find(old('produk_id'));
                                        $quantity = old('jumlah', 1);
                                    @endphp
                                    @if($selectedProduct)
                                        <div class="mb-3">
                                            <h6>Informasi Produk: {{ $selectedProduct->nama }}</h6>
                                            <p><strong>Harga:</strong> Rp {{ number_format($selectedProduct->harga, 0, ',', '.') }}</p>
                                            <p><strong>Deskripsi:</strong> {{ $selectedProduct->deskripsi }}</p>
                                        </div>

                                        <h6>Kebutuhan Bahan Baku:</h6>
                                        @if($selectedProduct->bahanBaku->count() > 0)
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Nama Bahan</th>
                                                            <th>Jumlah Dibutuhkan</th>
                                                            <th>Stok Tersedia</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($selectedProduct->bahanBaku as $bahan)
                                                            @php
                                                                $requiredAmount = $bahan->pivot->jumlah * $quantity;
                                                                $isEnough = $bahan->stok >= $requiredAmount;
                                                            @endphp
                                                            <tr class="{{ !$isEnough ? 'table-danger' : '' }}">
                                                                <td>{{ $bahan->nama_bahan }}</td>
                                                                <td>{{ $requiredAmount }}</td>
                                                                <td>{{ $bahan->stok }}</td>
                                                                <td>
                                                                    @if($isEnough)
                                                                        <span class="badge bg-success">Mencukupi</span>
                                                                    @else
                                                                        <span class="badge bg-danger">Tidak Cukup</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <p class="text-muted">Tidak ada data bahan baku untuk produk ini.</p>
                                        @endif
                                    @else
                                        <p class="text-muted">Informasi produk tidak tersedia.</p>
                                    @endif
                                @else
                                    <p class="text-muted">Silakan pilih produk untuk melihat kebutuhan bahan baku.</p>
                                    <p>Setelah memilih produk, klik tombol "Cek Bahan Baku" di bawah untuk melihat informasi bahan baku.</p>
                                @endif

                                <div class="mt-3">
                                    <button type="submit" name="action" value="check" class="btn btn-secondary">Cek Bahan Baku</button>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" name="action" value="create" class="btn btn-primary">Tambah Order</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
