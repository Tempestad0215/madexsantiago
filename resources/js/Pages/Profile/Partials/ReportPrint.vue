<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import { reactive } from 'vue';
import {reporteFechaI} from '@interfaces/carga';
import { PropType } from 'vue';
import { formatoDinero } from '@global/helpers';

const props = defineProps({
    reporte:{
        type: Object as PropType<reporteFechaI>,
        required: true
    }
});

// Data ded la imrepsion
const info = reactive({
    fechaImpresion: ""
});

// Al momento de cargar
onMounted(()=>{
    info.fechaImpresion = new Date().toLocaleString();
    // Llamar los datos
    setTimeout(()=>{
        printReport();
    },200);
});

window.addEventListener("afterprint",()=>{
    window.history.back();
});

// funciond e imprimir
const printReport = ():void =>{
    // Imprimir el reporte
    window.print();
    // Retroceder a la ventana principal
    window.location.href = "/";
}




</script>

<!-- vista de la ventan -->
<template>
    <Head title="Reporte"/>
    <div id="printable">
        <table width="100%">
            <thead>
                <tr>
                    <!-- Informacion de la empresa -->
                    <th>
                        {{ reporte.isAvance ? 'AVANCE INDUSTRIAL SRL' : 'MADEX RECYCLING SRL' }}
                    </th>
                    <!-- Fecha de impresion -->
                    <th>
                        Fecha Impresion : {{ info.fechaImpresion }}
                    </th>
                </tr>
                <tr>
                    <!-- Informacion del reporte -->
                    <th colspan="2">
                        Reporte General
                    </th>

                </tr>

                <!-- Desde -->
                <tr>
                    <th>
                        Reporte Desde : {{ reporte.desde }}
                    </th>
                </tr>
                <!-- Hasta -->
                <tr>
                    <th>
                        Reporte Hasta : {{ reporte.hasta }}
                    </th>
                </tr>
                <!-- LLinea Divisora -->
                <tr>
                    <th colspan="2" align="center">
                        ------------------------------------------------------------------------------------------------
                    </th>
                </tr>
            </thead>
            <!-- Informacion de la orden -->
            <tbody>
                <tr align="center">
                    <td>
                        Total KG. {{ formatoDinero(reporte.total_kg) }}
                    </td>
                    <td>
                        Desc KG. {{ formatoDinero(reporte.total_kg) }}
                    </td>
                </tr>
                <tr align="center">
                    <td>
                        Cantidad Pacas {{ formatoDinero(reporte.cant_pacas) }}
                    </td>
                    <td>
                        Pago efectivo $ {{ formatoDinero(reporte.total_kg) }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
