<?php

namespace App\Http\Controllers;

use App\Models\Mesin;
use Illuminate\Http\Request;

class MesinController extends Controller
{
    public function store()
    {
        $data = request()->validate([
            'nama' => 'required',
            'tipe' => 'required',
            'kapasitas' => 'required|integer',
            'status' => 'required|in:aktif,nonaktif,perawatan',
        ]);

        Mesin::create($data);

        return redirect()->back()->with('success', 'Mesin berhasil ditambahkan');
    }

    public function update($id)
    {
        $data = request()->validate([
            'nama' => 'required',
            'tipe' => 'required',
            'kapasitas' => 'required|integer',
            'status' => 'required|in:aktif,nonaktif,perawatan',
        ]);

        $mesin = Mesin::findOrFail($id);
        $mesin->update($data);

        return redirect()->back()->with('success', 'Mesin berhasil diupdate');
    }

    public function destroy($id)
    {
        $mesin = Mesin::findOrFail($id);
        $mesin->delete();

        return redirect()->back()->with('success', 'Mesin berhasil dihapus');
    }
}
