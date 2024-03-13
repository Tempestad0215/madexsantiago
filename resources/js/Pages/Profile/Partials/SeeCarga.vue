<script setup lang="ts">
import { PropType } from 'vue';
import { cargaResourceI } from '@interfaces/carga';
import { Head, Link, router } from '@inertiajs/vue3';
import DataCarga from './DataCarga.vue';
import { formatoDinero } from '@global/helpers';

// Propiedades
const props = defineProps({
    carga: {
        type: Object as PropType<cargaResourceI>,
        required: true
    }
});

// Editar la orden seleccionada
const editar = (id:number) =>{
    router.get(route('carga.edit',{carga:id}));
}
// Imprimir la orden seleccionada
const imprimir = (id:number) => {
    router.get(route('carga.print',{carga: id}));
}
// Retornar hacia atras
const atras = () => {
    window.history.back();
}


</script>



<template>
    <Head title="Ver registro"/>
    <div
        class=" px-5 pb-7">
        <h4
            class="py-5 text-center font-bold text-xl text-blue-800">
            Mostrando el registro N° {{ carga.data.id }}
        </h4>
        <!-- Boton para editar la orden -->
        <div class="mb-3 space-x-3">
            <button
                @click="atras()"
                class="boton-send "
                type="button">
                Atras
                <i class="fa-solid fa-arrow-left-long"></i>
            </button>
            <button
                @click="editar(carga.data.id)"
                class="boton-send  bg-orange-800"
                type="button">
                Editar
                <i
                    class="fa-solid fa-pen-to-square">
                </i>
            </button>
            <button
                @click="imprimir(carga.data.id)"
                class="boton-send"
                type="button">
                Imprimir
                <i
                    class="fa-solid fa-pen-to-square">
                </i>
            </button>
        </div>


        <!-- DEscuento -->
        <DataCarga
            class=" float-right"
            label="Fecha de Creacion"
            :data="carga.data.creacion"/>

        <div class=" grid grid-cols-2 grid-rows-3 gap-3 clear-both">
            <!-- Datos del cliente -->

            <fieldset class="px-5 py-3 rounded-md grid grid-cols-2 gap-3 shadow-lg border-2 border-blue-700">
                <legend class="font-bold text-xl" >Entrada de datos de pesadas Cliente</legend>
                <!-- Suplidor -->
                <DataCarga
                    label="Cliente"
                    :data="carga.data.cliente"/>
                <!-- DEscuento -->
                <DataCarga
                    label="Cédula"
                    :data="carga.data.cedula"/>
            </fieldset>

            <!-- Datos pesada del vehiculo -->
            <fieldset class="px-5 py-3 rounded-md grid grid-cols-2 gap-3 shadow-lg border-2 border-blue-700" >
                <legend class="font-bold text-xl" >Datos Pesada del Vehiculo</legend>
                <!-- Bruto -->
                <DataCarga
                    label="Bruto"
                    :data="carga.data.bruto + ' KG.'"/>
                <!-- DEscuento -->
                <DataCarga
                    label="Tara"
                    :data="carga.data.tara + ' KG.'"/>
                <!-- DEscuento -->
                <DataCarga
                    label="Descuento"
                    :data="carga.data.desc +' %'"/>
                <!-- DEscuento -->
                <DataCarga
                    label="Sub total"
                    :data="carga.data.sub_total + ' KG.'"/>
                <!-- DEscuento -->
                <DataCarga
                    label="Descuento KG"
                    :data="carga.data.desc_kg + ' KG.'"/>
                <!-- DEscuento -->
                <DataCarga
                    label="Total KG"
                    :data="carga.data.total_kg + ' KG.'"/>
            </fieldset>



            <!-- Datos del material recibido -->
            <fieldset class="px-5 py-3 rounded-md grid grid-cols-2 gap-3 shadow-lg border-2 border-blue-700">
                <legend class="font-bold text-xl" >Datos del Material Recibidos</legend>
                <!-- DEscuento -->
                <DataCarga
                    label="Material"
                    :data="carga.data.material"/>
                <!-- DEscuento -->
                <DataCarga
                    label="Cantidad pacas"
                    :data="carga.data.cant_pacas"/>
                <!-- DEscuento -->
                <DataCarga
                    label="Tipo empaquetado"
                    :data="carga.data.suelto_paca"/>
            </fieldset>


            <!-- Descripcion del vehiculo -->
            <fieldset class="px-5 py-3 rounded-md grid grid-cols-2 gap-3 shadow-lg border-2 border-blue-700">
                <legend class="font-bold text-xl" >Descripcion del Vehiculo</legend>
                <!-- DEscuento -->
                <DataCarga
                    label="Vehiculo"
                    :data="carga.data.vehiculo"/>
                <!-- DEscuento -->
                <DataCarga
                    label="Color"
                    :data="carga.data.color"/>
                <!-- DEscuento -->
                <DataCarga
                    label="# Placa"
                    :data="carga.data.placa"/>
            </fieldset>



            <!-- Estatus de la factura -->
            <fieldset class="px-5 py-3 rounded-md grid grid-cols-2 gap-3 shadow-lg border-2 border-blue-700">
                <legend class="font-bold text-xl" >Estatus de Pago de la Factura</legend>
                <!-- DEscuento -->
                <DataCarga
                    label="Estatus tiket"
                    :data="carga.data.estatus_tiket"/>
                <!-- DEscuento -->
                <DataCarga
                    label="Fecha pago tiket"
                    :data="carga.data.fecha_pago_tiket"/>
                <!-- DEscuento -->
                <DataCarga
                    label="Precio x KG"
                    :data="'$ ' + carga.data.precio_kg"/>
                <!-- DEscuento -->
                <DataCarga
                    label="Pago Efectivo"
                    :data="'$ '+ carga.data.pago_efectivo"/>
            </fieldset>


        </div>
    </div>
</template>
