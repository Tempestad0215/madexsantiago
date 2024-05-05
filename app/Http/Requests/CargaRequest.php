<?php

namespace App\Http\Requests;

use App\Enums\ColorEnum;
use App\Enums\EstatusTiketEnum;
use App\Enums\MaterialEnum;
use App\Enums\VehiculoEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CargaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cliente' => ['required','string','min:4','max:75'],
            'desc' => ['nullable','numeric'],
            'material' => ['required', Rule::enum(MaterialEnum::class)],
            'bruto' => ['required','numeric', Rule::notIn('0.00')],
            'tara' => ['required','numeric', Rule::notIn('0.00')],
            'sub_total' => ['required','numeric', Rule::notIn('0.00')],
            'desc_kg' => ['required','numeric'],
            'total_kg' => ['required','numeric', Rule::notIn('0.00')],
            'estatus_tiket' => ['required',Rule::enum(EstatusTiketEnum::class)],
            'fecha_pago_tiket'=> ['nullable','date'],
            'precio_kg' => ['required','numeric', Rule::notIn('0.00')],
            'pago_efectivo' => ['required','numeric', Rule::notIn('0.00')],
            'cant_pacas' => ['nullable','numeric'],
            'cedula' => ['nullable','string'],
            'vehiculo' => ['required',Rule::enum(VehiculoEnum::class)],
            'color' => ['required',Rule::enum(ColorEnum::class)],
            'placa' => ['nullable','string'],
            'tipo' => ['required','boolean'],
            'imprimir_carga' => ['nullable','boolean']
        ];
    }
}
