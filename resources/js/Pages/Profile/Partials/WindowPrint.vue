<script setup lang="ts">
import { Head, } from '@inertiajs/vue3';
import { cargaResourceI } from '@interfaces/carga';
import { reactive, onMounted, PropType, ref } from 'vue';


const props = defineProps({
    carga:{
        type: Object as PropType<cargaResourceI> || undefined,
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
const fechaPago = ref("");
const tipo = ref(false);




// Al momento de cargar
onMounted(()=>{


    // Pasar las fechas de todo
    fecha.fecha = props.carga.data.creacion.split(" ")[0];
    fecha.hora = props.carga.data.creacion.split(" ")[1];
    fecha.printDate = new Date().toLocaleString();
    // si es de avance o madex
    tipo.value = props.carga.data.tipo ? false : true
    // Limpiar la cadena
    fechaPago.value = props.carga.data.fecha_pago_tiket.replace('T',' ');
    // Imprimir los dtos

    setTimeout(() => {
        // Imprimir la ventana
        window.print();

        // Retornar hacia atras
        window.history.back();
    }, 100);


});



</script>

<template>
    <Head title="Impresion"/>
    <div

        id="printable"
        class="contenedor " >
            <!-- Datos de la tabla -->
            <table
                v-if="carga.data"
                width="100%">
                <thead class="font-size:10pt;" >
                    <!-- Primeara linea -->
                    <tr>
                        <th>
                            {{ tipo ? 'AVANCE INDUSTRIAL SRL' : 'MADEX RECYCLING SRL' }}
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
                            RNC N°{{ tipo ? '101-08329-8' : '131-11042-8' }}
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
                            Cliente.............: {{ carga.data.cliente }}
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
                            Peso Bruto.......: {{ carga.data.bruto }} KG.
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Tara.................: {{ carga.data.tara }} KG.
                        </td>
                        <td>
                            Peso Neto........: {{ carga.data.sub_total }} KG.
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
                            Desc. % Aplicados.....:
                            {{ carga.data.desc }} %
                        </td>
                        <td>
                            Prec. X KG. $.......: {{ carga.data.precio_kg }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            KG. Descontado.........: {{ carga.data.desc_kg }} KG.
                        </td>
                        <td>
                            Total KG. Neto.....: {{ carga.data.total_kg }} KG.
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Monto Pagado $.........:
                            {{ carga.data.pago_efectivo }}
                        </td>
                        <td>
                            Fecha Pago Tiket.....:
                            {{ fechaPago }}
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

@media print{
    #nprogress{
        display: none;
    }
}


.contenedor{
    max-width: 21.5cm !important;
    max-height: 14cm !important;
    font-size: 10pt !important;
    overflow: hidden !important;
    padding: 2px !important;
    margin: 2px !important;
}
</style>
