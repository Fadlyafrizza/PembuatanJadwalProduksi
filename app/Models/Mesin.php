<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mesin extends Model
{
    use HasFactory;

    protected $table = 'tmesin';
    protected $fillable = [
        'id',
        'nama',
        'tipe',
        'kapasitas',
        'status',
    ];
    public $timestamps = false;
}
