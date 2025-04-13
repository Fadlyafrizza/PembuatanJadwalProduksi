<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mesin;
use App\Models\Order;
use App\Models\Jadwal;
use App\Models\Produk;
use App\Models\BahanBaku;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return view('admin.dashboard', compact('user'));
    }

    public function user()
    {
        $users = User::paginate(10);
        $user = auth()->user();

        return view('admin.user', compact(['user', 'users']));
    }

    public function mesin()
    {
        $user = auth()->user();

        $mesin = Mesin::paginate(10);

        return view('admin.mesin', compact(['user', 'mesin']));
    }

    public function produk()
    {
        $user = auth()->user();

        $produk = Produk::with('bahanBaku')->paginate(10);
        $bahanBaku  = BahanBaku::get();

        return view('admin.produk', compact(['user', 'produk', 'bahanBaku' ]));
    }

    public function bahanBaku()
    {
        $user = auth()->user();

        $bahan = BahanBaku::paginate(10);

        return view('admin.bahan', compact(['user', 'bahan']));
    }

    public function order()
    {
        $user = auth()->user();

        $order = Order::with('produk.bahanBaku')->paginate(10);
        $produks = Produk::with('bahanBaku')->get();
        $bahanBaku = BahanBaku::all();

        return view('admin.order', compact(['user', 'order', 'produks', 'bahanBaku']));
    }

    public function produksi()
    {
        $user = auth()->user();

        $groupedOrders = Order::where('status', 'pending')
            ->get()
            ->groupBy('produk_id')
            ->map(function ($group) {
                return [
                    'produk_id' => $group->first()->produk_id,
                    'produk_nama' => $group->first()->produk->nama,
                    'total_jumlah' => $group->sum('jumlah'),
                    'orders' => $group->pluck('id')->toArray()
                ];
            })->values();

        $jadwals = Jadwal::with(['order.produk', 'mesin'])->paginate(10);

        $groupedJadwals = [];
        foreach ($jadwals as $jadwal) {
            $produkId = $jadwal->order->produk_id;

            if (!isset($groupedJadwals[$produkId])) {
                $groupedJadwals[$produkId] = [
                    'produk_id' => $produkId,
                    'produk_nama' => $jadwal->order->produk->nama,
                    'total_jumlah' => $jadwal->order->jumlah,
                    'mesin' => $jadwal->mesin ? $jadwal->mesin->nama : 'Belum ditentukan',
                    'waktu_mulai' => $jadwal->waktu_mulai,
                    'waktu_selesai' => $jadwal->waktu_selesai,
                    'status' => $jadwal->status,
                    'jadwal_ids' => [$jadwal->id]
                ];
            } else {
                $groupedJadwals[$produkId]['total_jumlah'] += $jadwal->order->jumlah;
                $groupedJadwals[$produkId]['jadwal_ids'][] = $jadwal->id;
            }
        }

        $groupedJadwals = collect(array_values($groupedJadwals));

        return view('admin.jadwal', compact(['groupedOrders', 'groupedJadwals', 'user']));
    }

}
