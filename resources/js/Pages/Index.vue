<script setup lang="ts">
import { Head, Link, router, useForm} from '@inertiajs/vue3';
import ShowIndex from './Partials/ShowIndex.vue';
import {successHttp} from '../global/alert'
import { onMounted, PropType } from 'vue';
import { paginationI,reporteGeneralI , CargaI } from '../interfaces/carga';
import { moneyConfig } from '../global/moneyConfig';
import { formatoDinero, limpiarCampo } from '../global/helpers';
import { reactive } from 'vue';
import { ref } from 'vue';
import Error from './Partials/Error.vue';


const props = defineProps({
    mes:{
        type: Number,
        required: true
    },
    cargas:{
        type: Object as PropType<paginationI>,
        required: true
    },
    fecha_actual:{
        type: String,
        required: true
    },
    carga_edit:{
        type: Object as PropType<CargaI>,
    },
    update:{
        type: Boolean,
        default: false
    },
    reporte:{
        type: Object as PropType<reporteGeneralI>,
        required: true
    }
});

const totales = reactive({
    subtotal: 0,
    total: 0,
    porciento: 0,
    descuento: 0
})
const porciento = ref(0)

onMounted(()=>{
    if(props.carga_edit)
    {
        form.id = props.carga_edit.id;
        form.suplidor = props.carga_edit.suplidor;
        form.desc = props.carga_edit.desc.toFixed(2);
        form.material = props.carga_edit.material;
        form.bruto = props.carga_edit.bruto.toFixed(2);
        form.tara = props.carga_edit.tara.toFixed(2);
        form.sub_total = props.carga_edit.sub_total.toFixed(2);
        form.desc_kg = props.carga_edit.desc_kg.toFixed(2);
        form.total_kg = props.carga_edit.total_kg.toFixed(2);
        form.estatus_tiket = props.carga_edit.estatus_tiket;
        form.fecha_pago_tiket = props.carga_edit.fecha_pago_tiket;
        form.precio_kg = props.carga_edit.precio_kg.toFixed(2);
        form.cant_pacas = props.carga_edit.cant_pacas.toFixed(2);
        form.suelto_paca = props.carga_edit.suelto_paca;
        form.cedula = props.carga_edit.cedula;
        form.vehiculo = props.carga_edit.vehiculo;
        form.color = props.carga_edit.color;
        form.placa = props.carga_edit.placa;
        form.mes = props.carga_edit.mes;
    }
});


const form = useForm({
    id:0,
    suplidor:"",
    desc: "",
    material: 1,
    bruto: "",
    tara: "",
    sub_total: "",
    desc_kg: "",
    total_kg: "",
    estatus_tiket: 1,
    fecha_pago_tiket: "",
    precio_kg: "",
    pago_efectivo: "",
    cant_pacas: "",
    suelto_paca: 1,
    cedula: "",
    vehiculo: 1,
    color: 1,
    placa: "",
    mes: props.mes


});
// Formulario para reporte por fecha
const formReport = useForm({
    desde:"",
    hasta:""
});


// Funciones
const submit = () => {
    if(props.update)
    {
        form.transform((data) => ({
            ...data,
            suplidor: data.suplidor.toUpperCase(),
            placa: data.placa.toUpperCase(),
            desc: limpiarCampo(data.desc),
            bruto: limpiarCampo(data.bruto),
            tara: limpiarCampo(data.tara),
            sub_total: limpiarCampo(data.sub_total),
            desc_kg: limpiarCampo(data.desc_kg),
            total_kg: limpiarCampo(data.total_kg),
            precio_kg: limpiarCampo(data.precio_kg),
            pago_efectivo: limpiarCampo(data.pago_efectivo),
            cant_pacas: limpiarCampo(data.cant_pacas),
        })).put(route('carga.update',{carga: form.id}),{
            onSuccess:()=>{
                successHttp('Registro actualizado correctamente');
            }
        });
    }else{

        form.transform((data) => ({
            ...data,
            suplidor: data.suplidor.toUpperCase(),
            placa: data.placa.toUpperCase(),
            desc: limpiarCampo(data.desc),
            bruto: limpiarCampo(data.bruto),
            tara: limpiarCampo(data.tara),
            sub_total: limpiarCampo(data.sub_total),
            desc_kg: limpiarCampo(data.desc_kg),
            total_kg: limpiarCampo(data.total_kg),
            precio_kg: limpiarCampo(data.precio_kg),
            pago_efectivo: limpiarCampo(data.pago_efectivo),
            cant_pacas: limpiarCampo(data.cant_pacas),
        })).post(route('carga.store'),{
            onSuccess:()=>{
                successHttp('Datos registrado correctamente');
                form.reset();
            }
        })
    }

}
// Calulo de todo
const sub_total = () =>{
    // Calcular el subtotal
    form.sub_total = (limpiarCampo(form.bruto) - limpiarCampo(form.tara) || 0).toFixed(2);
    // Calculo del descuento
    descuento();
    // Calculcar el total de todo
    form.total_kg = (limpiarCampo(form.sub_total) - limpiarCampo(form.desc_kg)).toFixed(2);

}

// // Decuento de material
const descuento = () =>{
    // Sacar el pocentaje en decimales
    porciento.value = limpiarCampo(form.desc) / 100 || 0;
    // Calcula el sub total con el descuento
    form.desc_kg = (limpiarCampo(form.sub_total) * porciento.value|| 0).toFixed(2);
}
// Calcular la cantidad a pagar
const efectivoPagar = () =>{
    // HAcer el calculo del pago por efectivo
    form.pago_efectivo = (limpiarCampo(form.total_kg) * limpiarCampo(form.precio_kg)).toFixed(2);
}
// Limpiar todo
const limpiar = () => {
    if(props.update)
    {
        router.get(route('carga.index'));
    }

    return false;
}
// REport Fecha
const reportDate = () => {
    router.get(`/reporte?desde=${formReport.desde}&hasta=${formReport.hasta}`);
}


</script>


<template>
    <Head title="Registro" />
    <div class="p-3 bg-gray-400">
        <!-- REporte General de todo -->
        <h3 class=" text-blue-800 font-bold text-2xl text-center mb-3">
            Reporte General
        </h3>
        <hr>
        <div class=" grid grid-cols-2 gap-2 text-center mt-3" >
            <!-- Total Kg anual -->
            <div>
                <p class="label">Total KG. anual</p>
                <p>{{ formatoDinero(props.reporte.total_kg_anual) }}</p>
            </div>
            <!-- Total Pagado Anual -->
            <div>
                <p class="label">Total desc. anual</p>
                <p>{{ formatoDinero(props.reporte.total_desc_anual) }}</p>
            </div>
            <!-- Total Pagado Anual -->
            <div>
                <p class="label">Total pacas anual</p>
                <p>{{ formatoDinero(props.reporte.total_cant_pacas) }}</p>
            </div>
            <!-- Reporte Mensual -->
            <div>
                <p class="label">Total KG mes</p>
                <p>{{ formatoDinero(props.reporte.total_kg_mensual) }}</p>
            </div>
        </div>
        <hr>
        <!-- Botones para navegar algunos datos -->
        <div class="mt-3">
            <Link
                class=" bg-blue-800 px-3 py-2 text-white rounded-md"
                :href="route('carga.show')">
                Mostrar
                <i class="fa-solid fa-table-list"></i>
            </Link>
        </div>
        <!-- Formulario de la carga -->
        <form
            class=" mb-3 sm:grid sm:grid-cols-2 sm:gap-3 lg:grid-cols-4"
            @submit.prevent="submit">
            <h3
                class="text-xl my-3 font-bold text-blue-800 text-center sm:col-span-full">
                Registro de mercancia
            </h3>
            <hr class=" sm:col-span-full">
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
                <!-- Mostrar el error -->
                <Error :data="form.errors.suplidor"/>
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
                    @input="descuento"
                    v-money="moneyConfig"
                    class="input w-full"
                    type="text"
                    name="desc"
                    id="desc">
                <!-- Mostrar el error -->
                <Error :data="form.errors.desc"/>
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
                <!-- Mostrar el error -->
                <Error :data="form.errors.material"/>
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
                    v-money="moneyConfig"
                    @input="sub_total"
                    class="input w-full"
                    type="text"
                    name="bruto"
                    id="bruto">
                <!-- Mostrar el error -->
                <Error :data="form.errors.bruto"/>
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
                    v-money="moneyConfig"
                    @input="sub_total"
                    class="input w-full"
                    type="text"
                    name="tara"
                    id="tara">
                <!-- Mostrar el error -->
                <Error :data="form.errors.tara"/>
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
                    :value="form.sub_total"
                    readonly
                    v-money="moneyConfig"
                    class="input w-full"
                    type="text"
                    name="sub-total"
                    id="sub-total">
                <!-- Mostrar el error -->
                <Error :data="form.errors.sub_total"/>
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
                    :value="form.desc_kg"
                    v-money="moneyConfig"
                    readonly
                    class="input w-full"
                    type="text"
                    name="sub-total"
                    id="sub-total">
                <!-- Mostrar el error -->
                <Error :data="form.errors.sub_total"/>
            </div>
            <!-- Total KG-->
            <div>
                <label
                    class="label"
                    for="total-kg">
                    Total KG
                </label>
                <input
                    v-money="moneyConfig"
                    :value="form.total_kg"
                    readonly
                    class="input w-full"
                    type="text"
                    name="total-kg"
                    id="total-kg">
                <!-- Mostrar el error -->
                <Error :data="form.errors.total_kg"/>
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
                <!-- Mostrar el error -->
                <Error :data="form.errors.estatus_tiket"/>
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
                <!-- Mostrar el error -->
                <Error :data="form.errors.fecha_pago_tiket"/>
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
                    v-money="moneyConfig"
                    @input="efectivoPagar()"
                    class="input w-full"
                    type="text"
                    name="precio-kg"
                    id="precio-kg">
                <!-- Mostrar el error -->
                <Error :data="form.errors.precio_kg"/>
            </div>
            <!-- PAgo efectiuvo-->
            <div>
                <label
                    class="label"
                    for="pago-efectivo">
                    Pago efectivo
                </label>
                <input
                    :value="form.pago_efectivo"
                    readonly
                    v-money="moneyConfig"
                    class="input w-full"
                    type="text"
                    name="pago-efectivo"
                    id="pago-efectivo">
                <!-- Mostrar el error -->
                <Error :data="form.errors.pago_efectivo"/>
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
                    v-money="moneyConfig"
                    class="input w-full"
                    type="text"
                    name="cant-paca"
                    id="cant-paca">
                <!-- Mostrar el error -->
                <Error :data="form.errors.cant_pacas"/>
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
                <!-- Mostrar el error -->
                <Error :data="form.errors.suelto_paca"/>
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
                    v-mask="'###-#######-#'"
                    class="input w-full"
                    type="text"
                    name="cedula"
                    id="cedula">
                <!-- Mostrar el error -->
                <Error :data="form.errors.cedula"/>
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
                <!-- Mostrar el error -->
                <Error :data="form.errors.vehiculo"/>
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
                <!-- Mostrar el error -->
                <Error :data="form.errors.color"/>
            </div>
            <!-- Placa-->
            <div>
                <label
                    class="label"
                    for="placa">
                    #Placa
                </label>
                <input
                    v-model="form.placa"
                    class="input w-full"
                    v-mask="'A ######'"
                    type="text"
                    name="placa"
                    id="placa">
                <!-- Mostrar el error -->
                <Error :data="form.errors.placa"/>
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
                <!-- Mostrar el error -->
                <Error :data="form.errors.mes"/>
            </div>
            <!-- Boton para Registrar los datos -->
            <div class="mt-3 text-right space-x-3 sm:col-span-full">
                <button
                    @click="limpiar()"
                    class=" bg-red-500 px-3 py-1 rounded-md font-bold"
                    type="reset">
                    Limpiar
                    <i class="fa-solid fa-eraser"></i>
                </button>
                <button
                    class=" boton-send px-3 rounded-md font-bold"
                    type="submit">
                    {{ update ? 'Actualizar' : 'Guardar'}}
                    <i class="fa-solid fa-floppy-disk"></i>
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
                :fecha_actual="fecha_actual"
                :cargas="cargas"/>
        </div>
        <hr>
        <!-- Impresion del reporte por fecha -->
        <div class="mt-3">
            <h3 class="text-lg text-blue-800 text-center font-bold">
                Impresion de reporte por fecha
            </h3>
            <form
                class=" sm:grid sm:grid-cols-2 sm:gap-3"
                @submit="reportDate">
                <!-- Desde -->
                <div>
                    <label
                        class=" block font-bold"
                        for="desde">
                        Desde
                    </label>
                    <input
                        v-model="formReport.desde"
                        class="input w-full"
                        type="date"
                        name="desde"
                        id="desde">
                    <!-- Error -->
                    <Error :data="formReport.errors.desde"/>
                </div>
                <!-- Hasta -->
                <div>
                    <label
                        class=" block font-bold"
                        for="Hasta">
                        Hasta
                    </label>
                    <input
                        v-model="formReport.hasta"
                        class="input w-full"
                        type="date"
                        name="hasta"
                        id="hasta">
                    <!-- Error -->
                    <Error :data="formReport.errors.hasta"/>
                </div>
                <!-- Boton para enviar los datos -->
                <div class="text-right sm:col-span-full mt-3">
                    <button
                        @click="reportDate"
                        class="boton-send w-[175px]"
                        type="button">
                        Imprimir Reporte
                        <i class="fa-solid fa-print"></i>
                    </button>
                </div>


            </form>
        </div>
    </div>
</template>
