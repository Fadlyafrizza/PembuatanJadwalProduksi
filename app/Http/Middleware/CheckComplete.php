<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckComplete
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $expiredSchedules = Jadwal::where('waktu_selesai', '<', Carbon::now())
        ->where('status', '!=', 'completed')
        ->get();

    foreach ($expiredSchedules as $schedule) {
        // Update tjadwal status to completed
        $schedule->update(['status' => 'completed']);

        // Update corresponding torder status to completed
        $order = Order::find($schedule->order_id);
        if ($order && $order->status != 'completed') {
            $order->update(['status' => 'completed']);
        }
    }

    return $next($request);
    }
}
