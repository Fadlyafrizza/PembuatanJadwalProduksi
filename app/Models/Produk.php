<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'tproduk';

    protected $fillable = [
        'id',
        'nama',
        'harga',
        'deskripsi',
        'waktu_produk'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'produk_id');
    }

    public function bahanBaku()
    {
        return $this->belongsToMany(BahanBaku::class, 'tproduk_bahan', 'produk_id', 'bahan_id')
            ->withPivot('jumlah');
    }

}
