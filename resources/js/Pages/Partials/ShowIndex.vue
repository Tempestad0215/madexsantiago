<script setup lang="ts">
import { PropType } from 'vue';
import { paginationI } from '../../interfaces/carga';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import { formatoDinero } from '../../global/helpers';
import Swal from 'sweetalert2';
import { successHttp } from '../../global/alert';


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
// Eliminar la carga
const eliminarCarga = (id:number) => {
    Swal.fire({
        title: "Desea eliminar?",
        text: "Los cambios realizados son irreversible!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, eliminar!",
        cancelButtonText: "Cancelar"
    }).then((result) => {
    if (result.isConfirmed) {
        router.delete(route('carga.destroy',{carga: id}),{
            onSuccess:()=>{
                // Mensaje de exito al eliminar
                successHttp("Registro eliminado corectamente");
            }
        });

        }
    });
}

</script>


<template>
    <Head title="Registro"/>
    <!-- Datos de la ventana -->
    <div class=" px-3 pt-5 bg-gray-400 pb-6">
        <!-- Botones para navegar algunos datos -->
        <div class="my-3">
            <Link
                class=" bg-blue-600 px-3 py-1 text-white rounded-md"
                :href="route('carga.index')">
                Registrar
                <i class="fa-solid fa-plus"></i>
            </Link>
        </div>
        <hr>
        <!-- Formulario de los datos -->
        <form
            class="mt-3"
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
                        {{ formatoDinero(item.bruto) }}
                    </td>
                    <td
                        class="hidden-field-lg">
                        {{ formatoDinero(item.tara) }}
                    </td>
                    <td
                        class="hidden-field-lg">
                        {{ formatoDinero(item.total_kg) }}
                    </td>
                    <td class=" truncate max-w-[75px]">
                        {{ item.estatus_tiket }}
                    </td>
                    <td class="space-x-3">
                        <i
                            @click="verCarga(item.id)"
                            class=" text-blue-600 fa-solid fa-eye">
                        </i>
                        <!-- Eliinar registro -->
                        <i
                            @click="eliminarCarga(item.id)"
                            class=" text-red-500 fa-solid fa-trash-can"></i>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
