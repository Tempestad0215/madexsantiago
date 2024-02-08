<script setup lang="ts">
import { Head, useForm, usePage } from '@inertiajs/vue3';
import ShowIndex from './Partials/ShowIndex.vue';
import {successHttp} from '../global/alert'
import { onMounted, PropType } from 'vue';
import { paginationI } from '../interfaces/carga';

const page = usePage();

const props = defineProps({
    mes:{
        type: Number,
        required: true
    },
    cargas:{
        type: Object as PropType<paginationI>,
        required: true
    }
});

onMounted(()=>{
});


const form = useForm({
    suplidor:"",
    desc: 0,
    material: 1,
    bruto: 0,
    tara: 0,
    sub_total: 0,
    desc_kg: 0,
    total_kg: 0,
    estatus_tiket: 1,
    fecha_pago_tiket: null,
    precio_kg: 0,
    pago_efectivo: 0,
    cant_pacas: 0,
    suelto_paca: 1,
    cedula: "",
    vehiculo: 1,
    color: 1,
    placa: "",
    mes: props.mes


});


// Funciones
const submit = () => {
    form.post(route('carga.store'),{
        onSuccess:()=>{
            successHttp('Datos registrado correctamente');
        }
    })
}
</script>


<template>
    <Head title="Registro" />
    <div class="p-3 bg-gray-400">
        <form
            class=" mb-3"
            @submit.prevent="submit">
            <h3
                class="text-xl my-3 font-bold text-center">
                Registro de mercancia
            </h3>
            <hr>
            <!-- SUPLIDOR -->
            <div>
                <label
                    class=" block font-bold"
                    for="suplidor">
                    Suplidor
                </label>
                <input
                    v-model="form.suplidor"
                    class="input w-full"
                    type="text"
                    name="suplidor"
                    id="suplidor">
            </div>
            <!-- DESC. -->
            <div>
                <label
                    class="label"
                    for="desc">
                    Desc.
                </label>
                <input
                    v-model="form.desc"
                    class="input w-full"
                    type="number"
                    name="desc"
                    id="desc">
            </div>
            <!-- Material -->
            <div>
                <label
                    class="label"
                    for="material">
                    Material
                </label>
                <select
                    class="input w-full"
                    name="material"
                    id="material">
                    <option
                        :value="1">
                        Carton
                    </option>
                    <option
                        :value="2">
                        Papel
                    </option>
                    <option
                        :value="3">
                        Otros
                    </option>
                </select>
            </div>
            <!-- Bruto -->
            <div>
                <label
                    class="label"
                    for="bruto">
                    Bruto
                </label>
                <input
                    v-model="form.bruto"
                    class="input w-full"
                    type="number"
                    name="bruto"
                    id="bruto">
            </div>
            <!-- Tara-->
            <div>
                <label
                    class="label"
                    for="tara">
                    Tara
                </label>
                <input
                    v-model="form.tara"
                    class="input w-full"
                    type="number"
                    name="tara"
                    id="tara">
            </div>
            <!-- TODO: Restar el bruto - tara para el subtotal -->
            <!-- Sub total-->
            <div>
                <label
                    class="label"
                    for="sub-total">
                    Sub total
                </label>
                <input
                    v-model="form.sub_total"
                    class="input w-full"
                    type="number"
                    name="sub-total"
                    id="sub-total">
            </div>
            <!-- TODO: Calcular el descuento haciel sel sub total para pasar a total KG -->
            <!-- Descuento de KG-->
            <div>
                <label
                    class="label"
                    for="sub-total">
                    Desc. KG
                </label>
                <input
                    v-model="form.desc_kg"
                    class="input w-full"
                    type="number"
                    name="sub-total"
                    id="sub-total">
            </div>
            <!-- Total KG-->
            <div>
                <label
                    class="label"
                    for="total-kg">
                    Total KG
                </label>
                <input
                    v-model="form.total_kg"
                    class="input w-full"
                    type="number"
                    name="total-kg"
                    id="total-kg">
            </div>
            <!-- Estatus del ticket-->
            <div>
                <label
                    class="label"
                    for="estatus-tiket">
                    Estatus tiket
                </label>
                <select
                    v-model="form.estatus_tiket"
                    class="input w-full"
                    name="estatus-tiket"
                    id="estatus-tiket">
                    <option
                        :value="1">
                        Pagado
                    </option>
                    <option
                        :value="2">
                        Pen. de pago
                    </option>
                </select>
            </div>
            <!-- Fecha pago del tiket-->
            <div>
                <label
                    class="label"
                    for="fecha-pago-tiket">
                    Fecha pago tiket
                </label>
                <input
                    v-model="form.fecha_pago_tiket"
                    class="input w-full"
                    type="date"
                    name="fecha-pago-tiket"
                    id="fecha-pago-tiket">
            </div>
            <!-- PRecio KG-->
            <div>
                <label
                    class="label"
                    for="precio-kg">
                    Precio X KG
                </label>
                <input
                    v-model="form.precio_kg"
                    class="input w-full"
                    type="number"
                    name="precio-kg"
                    id="precio-kg">
            </div>
            <!-- PAgo efectiuvo-->
            <div>
                <label
                    class="label"
                    for="pago-efectivo">
                    Pago efectivo
                </label>
                <input
                    v-model="form.pago_efectivo"
                    class="input w-full"
                    type="number"
                    name="pago-efectivo"
                    id="pago-efectivo">
            </div>
            <!-- Cantidad de pacas-->
            <div>
                <label
                    class="label"
                    for="cant-paca">
                    Cant. Pacas
                </label>
                <input
                    v-model="form.cant_pacas"
                    class="input w-full"
                    type="number"
                    name="cant-paca"
                    id="cant-paca">
            </div>
            <!-- suelkta o empacada-->
            <div>
                <label
                    class="label"
                    for="suel-paca">
                    Suel/Pac
                </label>
                <select
                    v-model="form.suelto_paca"
                    class="input w-full"
                    name="suel-paca"
                    id="suel-paca">
                    <option
                        :value="1">
                        Suelto
                    </option>
                    <option
                        :value="2">
                        Pacas
                    </option>
                </select>
            </div>
            <!-- Cedula-->
            <div>
                <label
                    class="label"
                    for="cedula">
                    Cédula
                </label>
                <input
                    v-model="form.cedula"
                    class="input w-full"
                    type="text"
                    name="cedula"
                    id="cedula">
            </div>
            <!-- Vehiculo-->
            <div>
                <label
                    class="label"
                    for="vehiculo">
                    Vehiculo
                </label>
                <select
                    v-model="form.vehiculo"
                    class="input w-full"
                    name="vehiculo"
                    id="vehiculo">
                    <option
                        :value="1">
                        Camioneta
                    </option>
                    <option
                        :value="2">
                        Camion
                    </option>
                    <option
                        :value="3">
                        Compactador
                    </option>
                    <option
                        :value="4">
                        Guaguita
                    </option>
                    <option
                        :value="5">
                        Camion Daihatsu
                    </option>
                    <option
                        :value="6">
                        Faldo
                    </option>
                    <option
                        :value="7">
                        Motor
                    </option>
                </select>
            </div>
             <!-- Vehiculo-->
             <div>
                <label
                    class="label"
                    for="color">
                    Color
                </label>
                <select
                    v-model="form.color"
                    class="input w-full"
                    name="color"
                    id="color">
                    <option
                        :value="1">
                        Blanco
                    </option>
                    <option
                        :value="2">
                        Rojo
                    </option>
                    <option
                        :value="3">
                        Negro
                    </option>
                    <option
                        :value="4">
                        Azul
                    </option>
                    <option
                        :value="5">
                        Amarillo
                    </option>
                    <option
                        :value="6">
                        Verde
                    </option>
                    <option
                        :value="7">
                        Gris
                    </option>
                </select>
            </div>
            <!-- Cedula-->
            <div>
                <label
                    class="label"
                    for="placa">
                    #Placa
                </label>
                <input
                    v-model="form.placa"
                    class="input w-full"
                    type="text"
                    name="placa"
                    id="placa">
            </div>
            <!-- MEs-->
            <div>
                <label
                    class="label"
                    for="mes">
                    Mes
                </label>
                <select
                    v-model="form.mes"
                    class="input w-full"
                    name="mes"
                    id="mes">
                    <option
                        :value="1">
                        Enero
                    </option>
                    <option
                        :value="2">
                        Febrero
                    </option>
                    <option
                        :value="3">
                        Marzo
                    </option>
                    <option
                        :value="4">
                        Abril
                    </option>
                    <option
                        :value="5">
                        Mayo
                    </option>
                    <option
                        :value="6">
                        Junio
                    </option>
                    <option
                        :value="7">
                        Julio
                    </option>
                    <option
                        :value="8">
                        Agosto
                    </option>
                    <option
                        :value="9">
                        Septiembre
                    </option>
                    <option
                        :value="10">
                        Octubre
                    </option>
                    <option
                        :value="11">
                        Noviembre
                    </option>
                    <option
                        :value="12">
                        Diciembre
                    </option>
                </select>
            </div>
            <!-- Boton para Registrar los datos -->
            <div class="mt-3 text-right space-x-3">
                <button
                    class=" bg-red-500 px-3 rounded-md font-bold"
                    type="reset">
                    Limpiar
                </button>
                <button
                    class=" bg-green-500 px-3 rounded-md font-bold"
                    type="submit">
                    Guardar
                </button>

            </div>

        </form>
        <hr>
        <!-- Mostrar los datos registrados -->
        <div class="mt-3">
            <h3 class="text-lg  text-blue-900 font-bold text-center">
                Datos registrados
            </h3>
            <ShowIndex
                :cargas="cargas"/>
        </div>
    </div>
</template>
