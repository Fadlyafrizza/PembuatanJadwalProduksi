<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'torder';
    protected $fillable = [
        'produk_id',
        'jumlah',
        'total_harga',
        'tanggal_pesan',
        'status'
    ];

    public $timestamps = false;

    protected $casts = [
        'tanggal_pesan' => 'date',
    ];


    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
