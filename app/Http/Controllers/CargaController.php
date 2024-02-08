<?php

namespace App\Http\Controllers;

use App\Enums\ColorEnum;
use App\Enums\EstatusTiketEnum;
use App\Enums\MaterialEnum;
use App\Enums\MesEnum;
use App\Enums\VehiculoEnum;
use App\Http\Resources\CargaResource;
use App\Models\carga;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class CargaController extends Controller
{
    //
    public function index(Request $request){

        try {
            // Mes actuale en int
            $mes = Carbon::now()->month;
            $data = carga::latest()->simplePaginate(25);
            // Obteneer los datos regitrados
            $dataFinal = CargaResource::collection($data)->response()->getData(true);

            return Inertia::render('Index',[
                'mes' => $mes,
                'cargas' => $dataFinal
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    // Guardar los datos
    public function store(Request $request)
    {
        try {
            //code...
            $validated = $request->validate([
                'suplidor' => ['required','string','min:4','max:75'],
                'desc' => ['nullable','numeric'],
                'material' => ['required', Rule::enum(MaterialEnum::class)],
                'bruto' => ['required','numeric'],
                'tara' => ['required','numeric'],
                'sub_total' => ['required','numeric'],
                'desc_kg' => ['required','numeric'],
                'total_kg' => ['required','numeric'],
                'estatus_tiket' => ['required',Rule::enum(EstatusTiketEnum::class)],
                'fecha_pago_tiket'=> ['nullable','date'],
                'precio_kg' => ['nullable','numeric'],
                'pago_efectivo' => ['required','numeric'],
                'cant_pacas' => ['required','numeric'],
                'cedula' => ['nullable','string'],
                'vehiculo' => ['required',Rule::enum(VehiculoEnum::class)],
                'color' => ['required',Rule::enum(ColorEnum::class)],
                'placa' => ['nullable','string'],
                'mes' => ['required',Rule::enum(MesEnum::class)]
            ]);
            // Guardar los datos
            carga::create($validated);
            // Retornar hacia atras con el exito
            return back();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    // Mostra todo los datos registrados
    public function show(Request $request)
    {
        try {


        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
