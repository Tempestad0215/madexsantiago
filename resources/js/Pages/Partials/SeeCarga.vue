<script setup lang="ts">
import { PropType } from 'vue';
import { cargaResourceI } from '../../interfaces/carga';
import { Head, router } from '@inertiajs/vue3';
import DataCarga from './DataCarga.vue';
import Swal from 'sweetalert2';
import { successHttp } from '../../global/alert';
import { formatoDinero } from '../../global/helpers';

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
// Eliminr la orden seleccionada
// const eliminar = (id:number) => {
//     Swal.fire({
//         title: "Seguro desea eliminar?",
//         text: "Los cambios realizados no se pueden deshacer!",
//         icon: "warning",
//         showCancelButton: true,
//         confirmButtonColor: "#3085d6",
//         cancelButtonColor: "#d33",
//         confirmButtonText: "Si, eliminar!",
//         cancelButtonText: "Cancelar"
//     }).then((result) => {
//     if (result.isConfirmed) {
//         router.delete(route('carga.destroy',{carga: id}),{
//             onSuccess: ()=>{
//                 successHttp('Registro eliminado correctamente');
//             }
//         })
//         }
//     });
// }


</script>



<template>
    <Head title="Ver registro"/>
    <div
        class=" bg-gray-400 px-5 pb-7">
        <h4
            class="py-5 text-center font-bold text-xl text-blue-900">
            Mostrando el registro N° {{ carga.data.id }}
        </h4>
        <!-- Boton para editar la orden -->
        <div class="mb-3 space-x-3">
            <button
                @click="editar(carga.data.id)"
                class="boton-send  bg-orange-500"
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
        <!-- Suplidor -->
        <DataCarga
            label="Suplidor"
            :data="carga.data.suplidor"/>
        <!-- DEscuento -->
        <DataCarga
            label="Descuento"
            :data="formatoDinero(carga.data.desc) +' %'"/>
        <!-- DEscuento -->
        <DataCarga
            label="Material"
            :data="carga.data.material"/>
        <!-- DEscuento -->
        <DataCarga
            label="Bruto"
            :data="formatoDinero(carga.data.bruto) + ' KG.'"/>
        <!-- DEscuento -->
        <DataCarga
            label="Tara"
            :data="formatoDinero(carga.data.tara) + ' KG.'"/>
        <!-- DEscuento -->
        <DataCarga
            label="Sub total"
            :data="formatoDinero(carga.data.sub_total) + ' KG.'"/>
        <!-- DEscuento -->
        <DataCarga
            label="Descuento KG"
            :data="formatoDinero(carga.data.desc_kg) + ' KG.'"/>
        <!-- DEscuento -->
        <DataCarga
            label="Total KG"
            :data="formatoDinero(carga.data.total_kg)+ ' KG.'"/>
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
            :data="'$ ' +formatoDinero(carga.data.precio_kg)"/>
        <!-- DEscuento -->
        <DataCarga
            label="Pago Efectivo"
            :data="'$ '+ formatoDinero(carga.data.pago_efectivo)"/>
        <!-- DEscuento -->
        <DataCarga
            label="Cantidad pacas"
            :data="formatoDinero(carga.data.cant_pacas)"/>
        <!-- DEscuento -->
        <DataCarga
            label="Tipo empaquetado"
            :data="carga.data.suelto_paca"/>
        <!-- DEscuento -->
        <DataCarga
            label="Cédula"
            :data="carga.data.cedula"/>
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
        <!-- DEscuento -->
        <DataCarga
            label="Mes"
            :data="carga.data.mes"/>
        <!-- DEscuento -->
        <DataCarga
            label="Fecha de Creacion"
            :data="carga.data.creacion"/>
    </div>
</template>
