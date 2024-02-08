<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cargas', function (Blueprint $table) {
            $table->id();
            $table->string('suplidor',75)->nullable();
            $table->float('desc')->nullable();
            $table->enum('material',[1,2,3]);
            $table->float('bruto');
            $table->float('tara');
            $table->float('sub_total');
            $table->float('desc_kg')->nullable();
            $table->float('total_kg')->nullable();
            $table->enum('estatus_tiket',[1,2]);
            $table->date('fecha_pago_tiket');
            $table->float('precio_kg');
            $table->float('pago_efectivo');
            $table->float('cant_pacas');
            $table->enum('suelto_paca',[1,2]);
            $table->string('cedula',20);
            $table->enum('vehiculo',[1,2,3,4,5,6,7]);
            $table->enum('color',[1,2,3,4,5,6,7]);
            $table->string('placa',20)->nullable();
            $table->enum('mes',[1,2,3,4,5,6,7,8,9,10,11,12]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cargas');
    }
};
