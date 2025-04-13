<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Jadwal;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:tproduk,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_pesan' => 'required|date',
        ]);

        // Check if this is just a check request
        if ($request->input('action') === 'check') {
            return redirect()->back()->withInput();
        }

        $produk = Produk::with('bahanBaku')->find($request->produk_id);

        // Check if all required ingredients have sufficient stock
        $insufficientBahan = [];
        foreach ($produk->bahanBaku as $bahan) {
            $requiredAmount = $bahan->pivot->jumlah * $request->jumlah;
            if ($bahan->stok < $requiredAmount) {
                $insufficientBahan[] = [
                    'nama' => $bahan->nama_bahan,
                    'available' => $bahan->stok,
                    'required' => $requiredAmount
                ];
            }
        }

        if (!empty($insufficientBahan)) {
            return redirect()->back()->withInput()->withErrors([
                'stock_error' => 'Stok bahan baku tidak mencukupi untuk pesanan ini.',
                'insufficient_bahan' => $insufficientBahan
            ]);
        }

        // Begin transaction
        DB::beginTransaction();

        try {
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

            // Reduce stock of ingredients
            foreach ($produk->bahanBaku as $bahan) {
                $requiredAmount = $bahan->pivot->jumlah * $request->jumlah;
                $bahan->stok -= $requiredAmount;
                $bahan->save();
            }

            DB::commit();
            return redirect()->route('dashboard.order')->with('success', 'Order berhasil dibuat dan dimasukkan ke jadwal');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        $order = Order::with('produk.bahanBaku')->findOrFail($id);
        $oldJumlah = $order->jumlah;
        $oldProdukId = $order->produk_id;

        $request->validate([
            'jumlah' => 'required|integer|min:1',
            'produk_id' => 'required|exists:tproduk,id',
            'tanggal_pesan' => 'required|date',
        ]);

        if ($request->input('action') === 'check') {
            return redirect()->back()->withInput();
        }

        $newProduk = Produk::with('bahanBaku')->find($request->produk_id);

        if (!$newProduk) {
            return redirect()->back()->withErrors('Produk tidak ditemukan.');
        }

        DB::beginTransaction();

        try {
            if ($oldProdukId != $request->produk_id || $oldJumlah < $request->jumlah) {
                if ($order->produk) {
                    foreach ($order->produk->bahanBaku as $bahan) {
                        $returnAmount = $bahan->pivot->jumlah * $oldJumlah;
                        $bahan->stok += $returnAmount;
                        $bahan->save();
                    }
                }

                $insufficientBahan = [];
                foreach ($newProduk->bahanBaku as $bahan) {
                    $requiredAmount = $bahan->pivot->jumlah * $request->jumlah;
                    if ($bahan->stok < $requiredAmount) {
                        $insufficientBahan[] = [
                            'nama' => $bahan->nama_bahan,
                            'available' => $bahan->stok,
                            'required' => $requiredAmount
                        ];
                    }
                }

                if (!empty($insufficientBahan)) {
                    DB::rollBack();
                    return redirect()->back()->withInput()->withErrors([
                        'stock_error' => 'Stok bahan baku tidak mencukupi untuk pesanan ini.',
                        'insufficient_bahan' => $insufficientBahan
                    ]);
                }

                foreach ($newProduk->bahanBaku as $bahan) {
                    $requiredAmount = $bahan->pivot->jumlah * $request->jumlah;
                    $bahan->stok -= $requiredAmount;
                    $bahan->save();
                }
            } else if ($oldJumlah > $request->jumlah && $oldProdukId == $request->produk_id) {
                $difference = $oldJumlah - $request->jumlah;
                foreach ($order->produk->bahanBaku as $bahan) {
                    $returnAmount = $bahan->pivot->jumlah * $difference;
                    $bahan->stok += $returnAmount;
                    $bahan->save();
                }
            }

            $order->update([
                'produk_id' => $request->produk_id,
                'jumlah' => $request->jumlah,
                'total_harga' => $request->jumlah * $newProduk->harga,
                'tanggal_pesan' => $request->tanggal_pesan,
            ]);

            DB::commit();
            return redirect()->route('dashboard.order')
                ->with('success', 'Order berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $order = Order::with('produk.bahanBaku')->findOrFail($id);

        DB::beginTransaction();

        try {
            if ($order->produk) {
                foreach ($order->produk->bahanBaku as $bahan) {
                    $returnAmount = $bahan->pivot->jumlah * $order->jumlah;
                    $bahan->stok += $returnAmount;
                    $bahan->save();
                }
            }

            $order->delete();

            DB::commit();
            return redirect()->route('dashboard.order')
                ->with('success', 'Order berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
}
