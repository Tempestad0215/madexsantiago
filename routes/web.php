<?php

use App\Http\Controllers\CargaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth')->group(function(){
    Route::get('/', [CargaController::class, 'index'])->name('carga.index');
    Route::post('/',[CargaController::class,'store'])->name('carga.store');
    route::get('/show',[CargaController::class,'show'])->name('carga.show');
    Route::get('/ver/{carga}',[CargaController::class,'see'])->name('carga.see');
    Route::get('/editar/{carga}',[CargaController::class,'edit'])->name('carga.edit');
    Route::get('/print/{carga}',[CargaController::class,'print'])->name('carga.print');
    Route::delete('/eliminar/{carga}',[CargaController::class,'destroy'])->name('carga.destroy');
    Route::put('/actualizar/{carga}',[CargaController::class,'update'])->name('carga.update');
    // Pruebad e todo
    Route::get('/reporte',[CargaController::class,'ReporteFecha'])->name('carga.reporte');
});
// Auth::routes(["register" => false]);


