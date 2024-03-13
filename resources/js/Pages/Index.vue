<script setup lang="ts">
import { Head, router, useForm, Link} from '@inertiajs/vue3';
import {successHttp} from '../global/alert'
import { onMounted, PropType } from 'vue';
import { paginationI,reporteGeneralI , CargaI,reporteFechaVisualizarI } from '../interfaces/carga';
import {  ref } from 'vue';
import Error from '@partials/Error.vue';
import Showindex from '@partials/ShowIndex.vue';
import { horaActual, limpiarCampo } from '@/global/helpers';



// Props de la ventana
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
    },
    reporteFecha:{
        type: Object as PropType<reporteFechaVisualizarI>,
    }
});


// Datos de la ventana
const porciento = ref(0);



// Al momento de cargar
onMounted(()=>{
    // Datos para editar
    if(props.carga_edit)
    {
        form.id = props.carga_edit.id;
        form.cliente = props.carga_edit.cliente;
        form.desc = props.carga_edit.desc;
        form.material = props.carga_edit.material;
        form.bruto = props.carga_edit.bruto;
        form.tara = props.carga_edit.tara;
        form.sub_total = props.carga_edit.sub_total;
        form.desc_kg = props.carga_edit.desc_kg;
        form.total_kg = props.carga_edit.total_kg;
        form.estatus_tiket = props.carga_edit.estatus_tiket;
        form.fecha_pago_tiket = props.carga_edit.fecha_pago_tiket;
        form.precio_kg = props.carga_edit.precio_kg;
        form.cant_pacas = props.carga_edit.cant_pacas;
        form.suelto_paca = props.carga_edit.suelto_paca;
        form.cedula = props.carga_edit.cedula;
        form.vehiculo = props.carga_edit.vehiculo;
        form.color = props.carga_edit.color;
        form.placa = props.carga_edit.placa;
        form.tipo = props.carga_edit.tipo;
        form.pago_efectivo = props.carga_edit.pago_efectivo;
    }
    form.fecha_pago_tiket = horaActual();


    // Verificar si existe el reporte
    if(props.reporteFecha)
    {
        formReport.desde = props.reporteFecha.desde;
        formReport.hasta = props.reporteFecha.hasta;
    }



});



// Datos del formulario
const form = useForm({
    id:0,
    cliente:"",
    desc: 0,
    material: 1,
    bruto: 0,
    tara: 0,
    fecha_hora: "",
    sub_total: 0,
    desc_kg: 0,
    total_kg: 0,
    estatus_tiket: 1,
    fecha_pago_tiket: "",
    precio_kg: 0,
    pago_efectivo: 0,
    cant_pacas: 0,
    suelto_paca: 1,
    cedula: "",
    vehiculo: 1,
    color: 1,
    placa: "",
    tipo: 0,
    imprimir_carga: false

});






// Formulario para reporte por fecha
const formReport = useForm({
    desde:"",
    hasta:"",
    avance: 0
});



// Funciones
const submit = () => {
    if(props.update)
    {
        form.transform((data) => ({
            ...data,
            cliente: data.cliente.toUpperCase(),
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
            cliente: data.cliente.toUpperCase(),
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
                if(!form.imprimir_carga)
                {
                    successHttp('Datos registrado correctamente');
                }
                form.reset();
            }
        })
    }

}
// Calulo de todo
const sub_total = () =>{
    // Calcular el subtotal
    form.sub_total = form.bruto - form.tara
    // Calculo del descuento
    descuento();

}

// // Decuento de material
const descuento = () =>{
    // Sacar el pocentaje en decimales
    porciento.value = form.desc / 100 || 0;
    // Calcula el sub total con el descuento
    form.desc_kg = form.sub_total * porciento.value
    // Calculcar el total de todo
    form.total_kg = form.sub_total - form.desc_kg;
}
// Calcular la cantidad a pagar
const efectivoPagar = () =>{
    // HAcer el calculo del pago por efectivo
    form.pago_efectivo = form.total_kg * form.precio_kg
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
    router.get(`/reporte?avance=${formReport.avance}&desde=${formReport.desde}&hasta=${formReport.hasta}`);
}
// Salir de la aopp
const salir = ()=>{
    router.post(route('logout'));
}


// Generar el reporte por fecha y por empresa
const generarReporte = ():void =>{

    formReport.get('/',{
        preserveScroll: true,
        preserveState: true,
        only: ['reporteFecha']
    });


}





</script>







<template>
    <Head title="Registro" />

    <!-- Datos de la ventana -->
    <div class="p-3 ">

        <!-- Datos dell usuarios -->
        <div class="pb-3 print:hidden">
            <h3 class=" text-blue-800 font-bold text-2xl text-center mb-3">
                Datos del usuario
            </h3>
            <div class=" flex justify-between">
                <Link
                    class="bg-blue-700 px-3 py-2 rounded-md text-white"
                    href="/user/profile">
                    Perfil de usuario
                    <i class="fa-solid fa-user"></i>
                </Link>
                <Link
                    @click="salir()"
                    class="bg-blue-700 px-3 py-2 rounded-md text-white"
                    href="#">
                    Salir
                    <i class="fa-solid fa-right-from-bracket"></i>
                </Link>

            </div>

        </div>
        <hr>


        <!-- REporte General de todo -->
        <h3 class=" text-blue-800 font-bold text-2xl text-center mb-3 print:hidden">
            Reporte General
        </h3>
        <hr>



        <!-- REporte del mes -->
        <div class=" grid grid-cols-2 gap-2 text-center mt-3 print:hidden" >
            <!-- Total Kg anual -->
            <div>
                <p class="label">Total KG. anual</p>
                <p>{{ props.reporte.total_kg_anual }}</p>
            </div>
            <!-- Total Pagado Anual -->
            <div>
                <p class="label">Total desc. anual</p>
                <p>{{ props.reporte.total_desc_anual }}</p>
            </div>
            <!-- Total Pagado Anual -->
            <div>
                <p class="label">Total pacas anual</p>
                <p>{{ props.reporte.total_cant_pacas }}</p>
            </div>
            <!-- Reporte Mensual -->
            <div>
                <p class="label">Total KG mes</p>
                <p>{{ props.reporte.total_kg_mensual }}</p>
            </div>
        </div>
        <hr>


        <!-- Botones para navegar algunos datos -->
        <div class="mt-3 print:hidden">
            <Link
                class=" bg-blue-800 px-3 py-2 text-white rounded-md"
                :href="route('carga.show')">
                Mostrar
                <i class="fa-solid fa-table-list"></i>
            </Link>
            <div class=" flex space-x-3 float-right z-20">
                <!-- Avance -->
                <div>
                    <input
                        class="hidden peer"
                        :value="0"
                        type="radio"
                        v-model="form.tipo"
                        name="avance"
                        id="avance">
                    <label
                        class=" bg-blue-400 px-3 py-1 rounded-md block text-center w-[100px] peer-checked:bg-blue-700 peer-checked:text-white select-none "
                        for="avance">
                        Avance
                    </label>
                </div>
                <!-- Madex -->
                <div>
                    <input
                        class="hidden peer"
                        type="radio"
                        :value="1"
                        v-model="form.tipo"
                        name="madex"
                        id="madex">
                    <label
                        class=" bg-blue-400 px-3 py-1 rounded-md block text-center w-[100px] peer-checked:bg-blue-700 peer-checked:text-white select-none "
                        for="madex">
                        Madex
                    </label>
                </div>
            </div>
        </div>


        <!-- Formulario de la carga -->
        <h3
            class="text-xl my-3 font-bold text-blue-800 text-center print:hidden">
            Registro de mercancia
        </h3>
        <form
            class=" grid grid-cols-2 grid-rows-3 gap-3 print:hidden"
            @submit.prevent="submit">


            <!-- Datos entrada de pesada -->
            <fieldset class="px-5 py-3 rounded-md shadow-lg border-2 border-blue-700" >
                <legend class=" font-bold text-xl">Entrada de datos de pesadas</legend>
                <!-- SUPLIDOR -->
                <div>
                    <label
                        class=" block font-bold"
                        for="cliente">
                        Cliente
                    </label>
                    <input
                        v-model="form.cliente"
                        class="input w-full"
                        type="text"
                        name="cliente"
                        id="cliente">
                    <!-- Mostrar el error -->
                    <Error :data="form.errors.cliente"/>
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
            </fieldset>



            <!-- Datos de pesada de vehiculo -->
            <fieldset class="px-5 py-3 rounded-md grid-rows-6 gap-3 shadow-lg border-2 border-blue-700 row-span-2 ">
                <legend class=" font-bold text-xl">Datos de Pesadas del Vehiculo</legend>
                <!-- Bruto -->
                <div>
                    <label
                        class="label"
                        for="bruto">
                        Bruto
                    </label>
                    <input
                        v-model="form.bruto"
                        @input="sub_total"
                        class="input w-full"
                        type="number"
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
                        @input="sub_total"
                        class="input w-full"
                        type="number"
                        name="tara"
                        id="tara">
                    <!-- Mostrar el error -->
                    <Error :data="form.errors.tara"/>
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
                        class="input w-full"
                        type="number"
                        name="desc"
                        id="desc">
                    <!-- Mostrar el error -->
                    <Error :data="form.errors.desc"/>
                </div>
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
                        class="input w-full"
                        type="text"
                        name="sub-total"
                        id="sub-total">
                    <!-- Mostrar el error -->
                    <Error :data="form.errors.sub_total"/>
                </div>
                <!-- Descuento de KG-->
                <div>
                    <label
                        class="label"
                        for="sub-total">
                        Desc. KG
                    </label>
                    <input
                        :value="form.desc_kg"
                        readonly
                        class="input w-full"
                        type="text"
                        name="sub-total"
                        id="sub-total">
                    <!-- Mostrar el error -->
                    <Error :data="form.errors.desc_kg"/>
                </div>
                <!-- Total KG-->
                <div>
                    <label
                        class="label"
                        for="total-kg">
                        Total KG
                    </label>
                    <input
                        :value="form.total_kg"
                        readonly
                        class="input w-full"
                        type="text"
                        name="total-kg"
                        id="total-kg">
                    <!-- Mostrar el error -->
                    <Error :data="form.errors.total_kg"/>
                </div>
            </fieldset>




            <!-- Datos del material recibido -->
            <fieldset class="px-5 py-3 rounded-md grid grid-cols-2 gap-3 shadow-lg border-2 border-blue-700">
                <legend class="font-bold text-xl">Datos del Material Recibidos</legend>
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
            </fieldset>




            <!-- Descripcion del vechiculo -->
            <fieldset class="px-5 py-3 rounded-md grid grid-cols-2 gap-3 shadow-lg border-2 border-blue-700">
                <legend class=" font-bold text-xl">Descripcion del Vehiculo</legend>
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
            </fieldset>




            <!-- Estus de pago de la factua -->
            <fieldset class=" px-5 py-3 rounded-md grid grid-cols-2 gap-3 shadow-lg border-2 border-blue-700">
                <legend class=" font-bold text-xl">Estatus de Pago de la Factura</legend>
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
                        type="datetime-local"
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
                        @input="efectivoPagar()"
                        class="input w-full"
                        type="number"
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
                        Cantidad a pagar
                    </label>
                    <input
                        :value="form.pago_efectivo"
                        readonly
                        class="input w-full"
                        type="text"
                        name="pago-efectivo"
                        id="pago-efectivo">
                    <!-- Mostrar el error -->
                    <Error :data="form.errors.pago_efectivo"/>
                </div>
            </fieldset>




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
                <button
                    @click="form.imprimir_carga = true"
                    class=" boton-send px-3 rounded-md font-bold w-fit"
                    type="submit">
                    {{ update ? 'Actualizar e Imprimir' : 'Guardar e Imprimir'}}
                    <i class="fa-solid fa-print"></i>
                </button>
            </div>
        </form>


        <!-- Mostrar los datos registrados -->
        <div class="mt-3 print:hidden">
            <h3 class="text-lg  text-blue-900 font-bold text-center">
                Datos registrados
            </h3>
            <Showindex
                :fecha_actual="fecha_actual"
                :cargas="cargas"/>
        </div>




        <!-- Impresion del reporte por fecha -->
        <div class="mt-3 print:hidden ">
            <!-- titulo -->
            <h3 class="text-lg text-blue-800 text-center font-bold">
                Impresion de reporte por fecha
            </h3>
            <div class=" flex justify-center space-x-3 z-20">
                <!-- Avance -->
                <div>
                    <input
                        class="hidden peer"
                        :value="0"
                        type="radio"
                        v-model="formReport.avance"
                        name="r-avance"
                        id="r-avance">
                    <label
                        class=" bg-blue-400 px-3 py-1 rounded-md block text-center w-[100px] peer-checked:bg-blue-700 peer-checked:text-white select-none "
                        for="r-avance">
                        Avance
                    </label>
                </div>
                <!-- Madex -->
                <div>
                    <input
                        class="hidden peer"
                        type="radio"
                        :value="1"
                        v-model="formReport.avance"
                        name="r-madex"
                        id="r-madex">
                    <label
                        class=" bg-blue-400 px-3 py-1 rounded-md block text-center w-[100px] peer-checked:bg-blue-700 peer-checked:text-white select-none "
                        for="r-madex">
                        Madex
                    </label>
                </div>
            </div>

            <!-- Impresion  -->
            <form
                class=" sm:grid sm:grid-cols-2 sm:gap-3"
                @submit="">
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

                <!-- Datos del reporte de venta -->
                <fieldset class=" px-5 py-3 rounded-md grid grid-cols-2 gap-3 shadow-lg border-2 border-blue-700">
                    <legend class=" font-bold text-xl">
                        Reporte Generado
                    </legend>
                    <p>
                        Total KG : {{ reporteFecha.total_kg }}
                    </p>
                    <p>
                        Total Dec. KG : {{ reporteFecha.desc_kg }}
                    </p>
                    <p>
                        Total Desc Anual : {{ reporteFecha.pago_efectivo }}
                    </p>
                    <p>
                        Total Efectivo : {{ reporteFecha.cant_pacas }}
                    </p>
                    <p>
                        Desde : {{ reporteFecha.desde }}
                    </p>
                    <p>
                        Hasta : {{ reporteFecha.hasta }}
                    </p>
                </fieldset>

                <div class="text-right sm:col-span-full mt-3 space-x-3">
                    <button
                        @click="generarReporte()"
                        class="boton-send w-fit"
                        type="button">
                        Generar Reporte
                    </button>
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
