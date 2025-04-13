<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProdukController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'deskripsi' => 'required|string',
            'waktu_produk' => 'required|integer',
            'bahan_baku' => 'required|array',
        ]);

        // Begin transaction
        DB::beginTransaction();

        try {
            // Create the product
            $produk = Produk::create([
                'nama' => $validatedData['nama'],
                'harga' => $validatedData['harga'],
                'deskripsi' => $validatedData['deskripsi'],
                'waktu_produk' => $validatedData['waktu_produk'],
            ]);

            // Process bahan baku
            if (isset($validatedData['bahan_baku'])) {
                foreach ($validatedData['bahan_baku'] as $bahan) {
                    // Skip if id or jumlah is not set (unchecked items)
                    if (!isset($bahan['id']) || !isset($bahan['jumlah']) || empty($bahan['jumlah'])) {
                        continue;
                    }

                    // Link product with bahan baku
                    $produk->bahanBaku()->attach($bahan['id'], ['jumlah' => $bahan['jumlah']]);
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Produk berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menambahkan produk: ' . $e->getMessage())->withInput();
        }
    }

    public function update($id)
    {
        $validatedData = request()->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required',
            'deskripsi' => 'required|string',
            'waktu_produk' => 'required',
            'bahan_baku' => 'array',
        ]);

        // Begin transaction
        DB::beginTransaction();

        try {
            // Update the product
            $produk = Produk::findOrFail($id);
            $produk->update([
                'nama' => $validatedData['nama'],
                'harga' => $validatedData['harga'],
                'deskripsi' => $validatedData['deskripsi'],
                'waktu_produk' => $validatedData['waktu_produk'],
            ]);

            // Handle bahan baku (raw materials)
            // First, detach all existing relationships
            $produk->bahanBaku()->detach();

            // Then attach the new ones
            if (isset($validatedData['bahan_baku'])) {
                foreach ($validatedData['bahan_baku'] as $bahan) {
                    // Skip if id or jumlah is not set (unchecked items)
                    if (!isset($bahan['id']) || !isset($bahan['jumlah']) || empty($bahan['jumlah'])) {
                        continue;
                    }

                    // Link product with bahan baku
                    $produk->bahanBaku()->attach($bahan['id'], ['jumlah' => $bahan['jumlah']]);
                }
            }

            DB::commit();
            return redirect()->route('dashboard.produk')->with('success', 'Product updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update product: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();

        return redirect()->route('dashboard.produk')->with('success', 'Product deleted successfully.');
    }
}
