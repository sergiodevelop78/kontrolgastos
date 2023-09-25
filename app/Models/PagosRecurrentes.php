<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagosRecurrentes extends Model
{
    use HasFactory;
    protected $table = 'pagos_recurrentes';
    public $timestamps = false;
    protected $primaryKey = 'idpago_recurrente';
    protected $fillable = ['idpago_recurrente', 'dia_pago', 'monto', 'mes'];
}
