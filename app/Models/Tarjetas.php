<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarjetas extends Model
{
    use HasFactory;

    protected $table = 'tarjetas';
    public $timestamps = false;
    protected $primaryKey = 'idtarjeta';
    protected $fillable = ['idtarjeta', 'tarjeta', 'dia_corte', 'activo'];
}
