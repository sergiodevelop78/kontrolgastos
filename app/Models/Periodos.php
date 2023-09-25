<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periodos extends Model
{
    use HasFactory;
    protected $table = 'periodos';
    public $timestamps = false;
    protected $primaryKey = 'idperiodo';
    protected $fillable = ['idperiodo', 'idtarjeta', 'periodo', 'mesIni', 'diaIni', 'mesFin', 'diaFin'];
}
