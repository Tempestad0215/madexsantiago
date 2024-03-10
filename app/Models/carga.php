<?php

namespace App\Models;

use App\Enums\ColorEnum;
use App\Enums\EstatusTiketEnum;
use App\Enums\MaterialEnum;
use App\Enums\MesEnum;
use App\Enums\SueltoEnum;
use App\Enums\VehiculoEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class carga extends Model
{
    use HasFactory;


    protected $table= 'cargas';

    protected $fillable = [
        'suplidor',
        'desc',
        'material',
        'bruto',
        'tara',
        'sub_total',
        'desc_kg',
        'total_kg',
        'estatus_tiket',
        'fecha_pago_tiket',
        'precio_kg',
        'pago_efectivo',
        'cant_pacas',
        'suelto_pacas',
        'cedula',
        'vehiculo',
        'color',
        'placa',
        'tipo',
    ];

    protected $casts = [
        'material' => MaterialEnum::class,
        'estatus_tiket' => EstatusTiketEnum::class,
        'suelto_paca' => SueltoEnum::class,
        'vehiculo' => VehiculoEnum::class,
        'color' => ColorEnum::class,
        'mes' => MesEnum::class,
    ];


}
