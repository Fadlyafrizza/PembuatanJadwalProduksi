<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Mesin;
use App\Models\Order;
use App\Models\Jadwal;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function jadwalkan(Request $request, $id)
    {
        $request->validate([
            'mesin_id' => 'required|exists:tmesin,id',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'required|date|after:waktu_mulai',
            'orders' => 'required|string'
        ]);

        $jadwal = Jadwal::findOrFail($id);

        $jadwal->update([
            'mesin_id' => $request->mesin_id,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'status' => 'in_progress',
        ]);

        if ($request->has('all_jadwal_ids')) {
            $allJadwalIds = array_filter(explode(',', $request->input('all_jadwal_ids')), 'is_numeric');
            $allJadwalIds = array_diff($allJadwalIds, [$id]);

            if (!empty($allJadwalIds)) {
                Jadwal::whereIn('id', $allJadwalIds)->update([
                    'mesin_id' => $request->mesin_id,
                    'waktu_mulai' => $request->waktu_mulai,
                    'waktu_selesai' => $request->waktu_selesai,
                    'status' => 'in_progress',
                ]);
            }
        }

        // Update related orders
        $orderIds = array_filter(explode(',', $request->input('orders')), 'is_numeric');

        if (!empty($orderIds)) {
            Order::whereIn('id', $orderIds)->update([
                'status' => 'scheduled',
            ]);
        }

        return redirect()->route('dashboard.produksi')->with('success', 'Jadwal berhasil diperbarui!');
    }


}
