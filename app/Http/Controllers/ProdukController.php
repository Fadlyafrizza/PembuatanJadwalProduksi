<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function store()
    {
        $validatedData = request()->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required',
            'deskripsi' => 'required|string',
            'waktu_produk' => 'required',
        ]);

        Produk::create($validatedData);

        return redirect()->route('dashboard.produk')->with('success', 'Product created successfully.');
    }

    public function update($id)
    {
        $validatedData = request()->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required',
            'deskripsi' => 'required|string',
            'waktu_produk' => 'required',
        ]);

        $produk = Produk::findOrFail($id);
        $produk->update($validatedData);

        return redirect()->route('dashboard.produk')->with('success', 'Product updated successfully.');
    }
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();

        return redirect()->route('dashboard.produk')->with('success', 'Product deleted successfully.');
    }
}
