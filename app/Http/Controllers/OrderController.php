<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Jadwal;
use App\Models\Produk;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:tproduk,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_pesan' => 'required',
        ]);

        $produk = Produk::find($request->produk_id);

        $order = Order::create([
            'produk_id' => $request->produk_id,
            'jumlah' => $request->jumlah,
            'total_harga' => $request->jumlah * $produk->harga,
            'tanggal_pesan' => $request->tanggal_pesan,
            'status' => 'pending',
        ]);

        Jadwal::create([
            'order_id' => $order->id,
            'mesin_id' => null,
            'waktu_mulai' => null,
            'waktu_selesai' => null,
            'status' => 'scheduled',
        ]);

        return redirect()->route('dashboard.order')->with('success', 'Order berhasil dibuat dan dimasukkan ke jadwal');
    }

    public function update(Request $request, $id)
    {
        $order = Order::with('produk')->findOrFail($id);

        $request->validate([
            'jumlah' => 'required|integer|min:1',
            'produk_id' => 'required|exists:tproduk,id',
            'tanggal_pesan' => 'required|date',
        ]);

        if (!$order->produk) {
            return redirect()->back()->withErrors('Produk tidak ditemukan untuk order ini.');
        }

        $order->update([
            'produk_id' => $request->produk_id,
            'jumlah' => $request->jumlah,
            'total_harga' => $request->jumlah * $order->produk->harga,
            'tanggal_pesan' => $request->tanggal_pesan,
        ]);

        return redirect()->route('dashboard.order')
            ->with('success', 'Order berhasil diperbarui');
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('dashboard.order')
            ->with('success', 'Order berhasil dihapus');
    }
}
