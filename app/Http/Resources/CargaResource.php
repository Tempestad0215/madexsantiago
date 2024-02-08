<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CargaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'suplidor' => $this->suplidor,
            'desc' => $this->desc,
            'material' => $this->material->name,
            'bruto' => $this->bruto,
            'tara' => $this->tara,
            'sub_total' => $this->sub_total,
            'desc_kg' => $this->desc_kg,
            'total_kg' => $this->total_kg,
            'estatus_tiket' => $this->estatus_tiket->name,
            'fecha_pago_tiket' => $this->fecha_pago_tiket,
            'precio_kg' => $this->precio_kg,
            'pago_efectivo' => $this->pago_efectivo,
            'cant_pacas' => $this->cant_pacas,
            'suelto_paca' => $this->suelto_paca->name,
            'cedula' => $this->cedula,
            'vehiculo' => $this->vehiculo->name,
            'color' => $this->color->name,
            'placa' => $this->placa,
            'mes' => $this->mes->name,
            'creacion' => $this->created_at->format('d/m/Y h:i:s')

        ];
    }
}
