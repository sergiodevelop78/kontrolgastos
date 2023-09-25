<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class consumos extends Model
{
    use HasFactory;
    protected $table = 'consumos';
    public $timestamps = false;
    protected $primaryKey = 'idconsumos';
    protected $fillable = ['idconsumos', 'concepto', 'total', 'fecha_consumo', 'idperiodo', 'iduser'];
}
