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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class CargaController extends Controller
{
    //
    public function index(Request $request){

        try {
            // Conseguir el mes
            $mes = Carbon::now()->month;
            // Pasar las data
            $data = $this->getData($request);
            // Obteneer los datos regitrados
            $dataFinal = CargaResource::collection($data)->response()->getData(true);
            // Devolver la vista con los datos
            return Inertia::render('Index',[
                'mes' => $mes,
                'fecha_actual' => Carbon::now()->format('Y-m-d'),
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
    // Ver la orden seleccionada
    public function see(carga $carga)
    {
        try {
            // Ver los datos seleccionada
            $cargaFinal = new CargaResource($carga);
            // Devolver los datos
            return Inertia::render('Partials/SeeCarga',[
                'carga' => $cargaFinal
            ]);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
    // Editar la orden
    public function edit(carga $carga, Request $request)
    {
        try {
            // Conseguir el mes
            $mes = Carbon::now()->month;
            // Conseguir la data
            $data = $this->getData($request);
            // Obteneer los datos regitrados
            $dataFinal = CargaResource::collection($data)->response()->getData(true);

           // Devolver la vista con los datos
           return Inertia::render('Index',[
            'mes' => $mes,
            'fecha_actual' => Carbon::now()->format('Y-m-d'),
            'cargas' => $dataFinal,
            'carga_edit' => $carga,
            'update' => true
        ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // Metodo para buscar la orden
    private function getData(Request $request)
    {
        // Buscar
        $suplidor = $request->suplidor;
        // Desde
        $desde = $request->desde ?? Carbon::now()->format('Y-m-d');
        // Hasta
        $hasta = $request->hasta ?? Carbon::now()->format('Y-m-d');
        // reducir un dia para el calculo
        $desdeFinal = Carbon::parse($desde)->subDay()->format('Y-m-d');
        // Agreagr un dia para el calculo
        $hastaFinal = Carbon::parse($hasta)->addDay()->format('Y-m-d');
        // Fecha
        // Buscar los datos
        $data = carga::where('suplidor','LIKE','%'.$suplidor.'%')
            ->where(function(Builder $query) use ($desdeFinal, $hastaFinal) {
                $query->whereDate('created_at','>',$desdeFinal)
                    ->whereDate('created_at','<',$hastaFinal);
            })->latest()
            ->simplePaginate(25);

        return $data;
    }
}
