<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagosRecurrentesLogs extends Model
{
    use HasFactory;

    protected $table = 'pagos_recurrentes_logs';
    public $timestamps = false;
    protected $primaryKey = 'idlog';
    protected $fillable = ['idlog', 'idpago_recurrente', 'fechamov'];
}
