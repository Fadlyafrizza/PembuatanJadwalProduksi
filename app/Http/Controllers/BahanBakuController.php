<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use Illuminate\Http\Request;

class BahanBakuController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama_bahan' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
        ]);

        BahanBaku::create($request->all());

        return redirect()->route('dashboard.bahan')
            ->with('success', 'Bahan baku berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $bahan = BahanBaku::findOrFail($id);

        $request->validate([
            'nama_bahan' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
        ]);

        $bahan->update($request->all());

        return redirect()->route('dashboard.bahan')
            ->with('success', 'Bahan baku berhasil diperbarui');
    }

    public function destroy(BahanBaku $bahan, $id)
    {
        $bahan = BahanBaku::findOrFail($id);
        $bahan->delete();

        return redirect()->route('dashboard.bahan')
            ->with('success', 'Bahan baku berhasil dihapus');
    }

}
