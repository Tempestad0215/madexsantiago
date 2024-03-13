<?php

namespace App\Http\Controllers;

use App\Http\Requests\CargaRequest;
use App\Http\Resources\CargaResource;
use App\Models\carga;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
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

            $reporte = [];
            if($request->desde)
            {
                $reporte = $this->fechaGeneral($request);

            }
            // Sacar el reporte por fehca

            // Devolver la vista con los datos
            return Inertia::render('Index',[
                'mes' => $mes,
                'fecha_actual' => Carbon::now()->format('Y-m-d'),
                'cargas' => $dataFinal,
                'reporte' => $this->reportGeneral(),
                'reporteFecha' => $reporte
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    // Guardar los datos
    public function store(CargaRequest $request)
    {
        try {

            // Guardar los datos
            $carga = carga::create($request->toArray());
            // Carga full de todo
            $cargaFinal = new CargaResource($carga);
            // Si desea imprir los datos de la carga
            if($request->imprimir_carga)
            {
                return redirect()->route('carga.print',[
                    'carga' => $carga->id
                ]);
            }
            // Devolverse hacia atrras
            return back();

        } catch (\Throwable $th) {
            throw $th;
        }
    }
    // Mostra todo los datos registrados
    public function show(Request $request)
    {
        try {
            // conseguir los datos
            $data = $this->getData($request);
            // Cambiar los datos en el resource
            $dataFinal = CargaResource::collection($data)->response()->getData();
            // Devovler la vista con los datos
            return Inertia::render('Profile/Partials/ShowIndex',[
                'cargas' => $dataFinal,
                'fecha_actual' => Carbon::now()->format('Y-m-d')
            ]);

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
            return Inertia::render('Profile/Partials/SeeCarga',[
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
            'update' => true,
            'reporte' => $this->reportGeneral()
        ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    // Aactualizar los datos
    public function update(carga $carga, CargaRequest $request)
    {
        try {
            // Actualzar los datos
            $carga->update($request->toArray());
            // Devolver hacia atras
            return back();

        } catch (\Throwable $th) {
            throw $th;
        }
    }


    // Elimianr el registro
    public function destroy(carga $carga)
    {
        try {
            // Eliminar el dato selecionnado
            $carga->delete();
            // Devolverse hacia atraas
            return back();


        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // Impresion de la carga
    public function print(carga $carga)
    {
        try {
            // Cambiar algunos valores devuelto
            $dataFinal = new CargaResource($carga);
            // DEvolver la vista con los datos
            return Inertia::render('Profile/Partials/WindowPrint',[
                'carga' => $dataFinal
            ]);

        } catch (\Throwable $th) {
            throw $th;
        }
    }


    //Hacer el reporte por dia para imprimir
    public function reporteFecha(Request $request)
    {
        // Datos de la fecha
        $reporte = $this->fechaGeneral($request);


        // Devolver la vista de imrpesion
        return Inertia::render('Profile/Partials/ReportPrint',[
            'reporte' => $reporte
        ]);

    }

    // Generar un reporte para visualizar
    public function generarReporte(Request $request)
    {

        // Obtener los datos del reporte
        $reporte = $this->fechaGeneral($request);
        // Devolver los datos en json para visualizar
        return redirect('/')->with('reporteFecha', [
            'funciona' => 'Sui asdasdasd'
         ]);
    }


    // Reporte de todos los datos
    private function reportGeneral(): array
    {
        // A;os
        $year = Carbon::now()->year;
        $month = Carbon::now()->month;
        $totalKgMonth = carga::whereMonth('created_at',$month)->sum('total_kg');
        $totalKgYear = carga::whereYear('created_at',$year)->sum('total_kg');
        $totalDescYear = carga::whereYear('created_at',$year)->sum('desc_kg');
        $efectivo = carga::whereYear('created_at',$year)->sum('pago_efectivo');
        $cantPacas = carga::whereYear('created_at',$year)->sum('cant_pacas');

        return [
            'total_kg_mensual' => $totalKgMonth,
            'total_kg_anual' => $totalKgYear,
            'total_desc_anual' => $totalDescYear,
            'total_efectivo' => $efectivo,
            'total_cant_pacas' => $cantPacas
        ];

    }

    // Metodo para buscar la orden
    private function getData(Request $request)
    {
        // Buscar
        $datos = $request->datos;
        // Buscar los datos
        $data = carga::where('cliente','LIKE','%'.$datos.'%')
            ->orWhere('id','LIKE','%'.$datos.'%')
            ->latest()
            ->simplePaginate(25);

        return $data;
    }

    // Reporte por fecha
    private function fechaGeneral(Request $request): array
    {
        try {


            // Desde
            $desde = $request->desde ?? Carbon::now()->format('Y-m-d');
            // Hasta
            $hasta = $request->hasta ?? Carbon::now()->format('Y-m-d');
            //  isAvance
            $isAvance = $request->avance;
            // Sacr los datos
            $data = carga::where(function(Builder $query) use ($desde, $hasta){
                $query->whereDate('created_at','>=', $desde)
                ->whereDate('created_at','<=', $hasta);
            })
            ->where('tipo', $isAvance)
            ->select('total_kg','desc_kg','pago_efectivo','cant_pacas')
            ->get();
            // Sumar todos los dtos
            $reporteFecha = [
                'total_kg' => $data->sum('total_kg'),
                'desc_kg' => $data->sum('desc_kg'),
                'pago_efectivo' => $data->sum('pago_efectivo'),
                'cant_pacas' => $data->sum('cant_pacas'),
                'desde' => $desde,
                'hasta' => $hasta,
                'isAvance'=> $isAvance === "0" ? true : false
            ];
            // Devolver los datos
            return $reporteFecha;


        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
