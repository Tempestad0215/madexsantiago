<script setup lang="ts">
import { Head, } from '@inertiajs/vue3';
import { cargaResourceI } from '../../interfaces/carga';
import { reactive, onMounted, PropType } from 'vue';
import printJS from 'print-js';
import {formatoDinero} from '../../global/helpers';


const props = defineProps({
    carga:{
        type: Object as PropType<cargaResourceI>,
        required: true
    }
});
// Sacar fecha y hora separada
const fecha = reactive({
    fecha: "",
    hora: "",
    printDate:"",
});
// Fecha de impresionm

// Al momento de cargar
onMounted(()=>{
    fecha.fecha = props.carga.data.creacion.split(" ")[0];
    fecha.hora = props.carga.data.creacion.split(" ")[1];
    fecha.printDate = new Date().toLocaleString();
    // Imprimir al momento de cargar'
    setTimeout(()=>{
        print();
    },500);
});

// Fnciond e imprimti
const print = ()=>{
    // Tomar la fecha
    // Imprimir todo
    printJS({
        printable: 'printable',
        type: 'html',
        scanStyles: true,
        font_size: '9pt',
        documentTitle: 'Avance Industrial',
        onPrintDialogClose: () =>{
            window.history.back();
        }
    });
}


</script>

<template>
    <Head title="Impresion"/>
    <div
        id="printable"
        class="contenedor" >
        <table width="100%">
            <thead class="font-size:10pt;" >
                <!-- Primeara linea -->
                <tr>
                    <th>
                        AVANCE INDUSTRIAL S.R.L
                    </th>
                    <th>
                        Fecha Impresion: {{ fecha.printDate }}
                    </th>
                </tr>
                <tr>
                    <th colspan="2">
                        SANTIAGO
                    </th>
                </tr>
                <!-- RNC de la empresa -->
                <tr>
                    <th colspan="2">
                        RNC N° 101-08329-8
                    </th>
                </tr>
                <!-- Informacion de la  -->
                <tr>
                    <th colspan="2">
                        RECIBO DE CARTON SANTIAGO
                    </th>
                </tr>
                <!-- Informacion de quien recibe y el numero de factura -->
                <tr>
                    <th >
                            Factura N° : {{ carga.data.id.toString().padStart(10,'0') }}
                    </th>
                    <th>
                        Recibido por: Jose
                    </th>
                </tr>
                <tr >
                    <th colspan="2">
                        --------------------------------------- Datos Pesada ---------------------------------------
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        Fecha...............: {{ fecha.fecha }}
                    </td>
                    <td>
                        Vehiculo...........: {{ carga.data.vehiculo }}
                    </td>
                </tr>
                <tr>
                    <td>
                        Hora.................: {{ fecha.hora }}
                    </td>
                    <td>
                        Color................: {{ carga.data.color }}
                    </td>
                </tr>
                <tr>
                    <td>
                        Cliente.............: {{ carga.data.suplidor }}
                    </td>
                    <td>
                        Placa................: {{ carga.data.placa }}
                    </td>
                </tr>
                <tr>
                    <td>
                        Cedula.............: {{ carga.data.cedula }}
                    </td>
                    <td>
                        Material...........: {{ carga.data.material }}
                    </td>
                </tr>
                <tr>
                    <td>
                        Pac/Suel..........: {{ carga.data.suelto_paca }}
                    </td>
                    <td>
                        Peso Bruto.......: {{ formatoDinero(carga.data.bruto) }} KG.
                    </td>
                </tr>
                <tr>
                    <td>
                        Tara.................: {{ formatoDinero(carga.data.tara) }} KG.
                    </td>
                    <td>
                        Peso Neto........: {{ formatoDinero(carga.data.sub_total) }} KG.
                    </td>
                </tr>
                <!-- Calculo de peso -->
                <tr>
                    <td colspan="2" align="center">
                        --------------------------------------- Calculo Pesada ---------------------------------------
                    </td>
                </tr>
                <!-- Datos del calculo -->
                <tr>
                    <td>
                        Desc. % Aplicados.....: {{ formatoDinero(carga.data.desc) }} %
                    </td>
                    <td>
                        Prec. X KG. $.......: {{ formatoDinero(carga.data.precio_kg) }}
                    </td>
                </tr>
                <tr>
                    <td>
                        KG. Descontado.........: {{ formatoDinero(carga.data.desc_kg)
                         }} KG.
                    </td>
                    <td>
                        Total KG. Neto.....: {{ formatoDinero(carga.data.total_kg) }} KG.
                    </td>
                </tr>
                <tr>
                    <td>
                        Monto Pagado............:
                        {{ formatoDinero(carga.data.pago_efectivo) }}
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        Recibido por :_________________________________
                    </td>
                    <td align="center">
                        Cedula : ________________________________
                    </td>
                </tr>
                <tr>
                    <th colspan="2" align="center" >
                        --------------------------------------------------------------------------------------------------------------------
                    </th>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<!-- Estilo de la ventanan -->
<style scoped>
.contenedor{
    max-width: 21.5cm !important;
    max-height: 14cm !important;
    font-size: 10pt !important;
    overflow: hidden !important;
    padding: 2px !important;
    margin: 2px !important;
}
</style>
