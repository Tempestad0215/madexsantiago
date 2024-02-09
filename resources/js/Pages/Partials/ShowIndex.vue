<script setup lang="ts">
import { PropType } from 'vue';
import { paginationI } from '../../interfaces/carga';
import { router, useForm } from '@inertiajs/vue3';


const props = defineProps({
    cargas:{
        type: Object as PropType<paginationI>,
        required: true
    },
    fecha_actual:{
        type: String,
        required: true
    }
});

// Datos del formulario
const form = useForm({
    suplidor:"",
    desde: props.fecha_actual,
    hasta: props.fecha_actual
});

// Buscar los datos
const submit = () => {
    // Buscar losd atos con esto
    form.get(`?suplidor=${form.suplidor}&desde=${form.desde}&hasta=${form.hasta}`,{
        preserveScroll: true,
        preserveState: true
    });
}
// Para ver la carga
const verCarga = (id:number)=>{
    router.get(route('carga.see',{id}));
}

</script>


<template>
    <div>
        <form
            @submit.prevent="submit">
            <!-- Buscar los datos -->
            <div>
                <!-- Para buscar los datos en la tabla -->
                <input
                    v-model="form.suplidor"
                    class=" input w-full"
                    placeholder="Buscar"
                    type="text">
            </div>
            <!-- Fecha para buscar los datos -->
            <div class="my-3 space-y-1">
                <div>
                    <label
                        class="label"
                        for="desde">
                        Desde
                    </label>
                    <input
                        v-model="form.desde"
                        class="input w-full"
                        type="date"
                        name="desde"
                        id="desde">
                    <!-- Hasta -->
                </div>
                <div>
                    <label
                        class="label"
                        for="hasta">
                        Hasta
                    </label>
                    <input
                        v-model="form.hasta"
                        class="input w-full"
                        type="date"
                        name="hasta"
                        id="hasta">
                </div>
            </div>
            <!-- Boton para buscar los datos -->
            <div class=" text-right my-3">
                <button
                    class="boton-send"
                    type="submit">
                    Buscar
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>
        </form>
        <hr>

        <!-- Datos de la tabla de todo -->
        <table
            class=" table-auto w-full text-center border-2 border-blue-900 mt-3">
            <!-- Cabcecera de la tabla -->
            <thead
                class=" border-b-2 border-blue-900 ">
                <tr>
                    <th>Id</th>
                    <th >Suplidor</th>
                    <th>Material</th>
                    <th class="hidden-field-lg">Bruto</th>
                    <th class="hidden-field-lg">Tara</th>
                    <th class="hidden-field-lg" >Total KG</th>
                    <th>Estatus tiket</th>
                    <th>Act</th>
                </tr>
            </thead>
            <!-- Contenidde de la tabala -->
            <tbody>
                <tr
                    class=" odd:bg-gray-300"
                    v-for="(item, index) in props.cargas.data" :key="index">
                    <td>
                        {{ item.id }}
                    </td>
                    <td class=" truncate max-w-[75px]">
                        {{item.suplidor}}
                    </td>
                    <td>
                        {{ item.material }}
                    </td>
                    <td
                        class="hidden-field-lg">
                        {{ item.bruto }}
                    </td>
                    <td
                        class="hidden-field-lg">
                        {{ item.tara }}
                    </td>
                    <td
                        class="hidden-field-lg">
                        {{ item.total_kg }}
                    </td>
                    <td class=" truncate max-w-[75px]">
                        {{ item.estatus_tiket }}
                    </td>
                    <td>
                        <i
                            @click="verCarga(item.id)"
                            class=" text-blue-600 fa-solid fa-eye">
                        </i>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
