<script setup lang="ts">
import { PropType } from 'vue';
import { paginationI } from '../../interfaces/carga';


const props = defineProps({
    cargas:{
        type: Object as PropType<paginationI>,
        required: true
    }
});

</script>


<template>
    <div>
        <div class="relative">
            <!-- Para buscar los datos en la tabla -->
            <input
                class=" input w-full"
                type="text">
            <!-- Icono para buscar los datos -->
            <i
                class=" absolute inset-y-0 flex items-center rounded-tr-md rounded-br-md right-0 px-3 bg-red-300 border-gray-500 border-[1px] fa-solid fa-magnifying-glass">
            </i>
        </div>
        <!-- Datos de la tabla de todo -->
        <table
            class=" table-auto w-full text-center border-2 border-blue-900 mt-3">
            <!-- Cabcecera de la tabla -->
            <thead
                class=" border-b-2 border-blue-900 ">
                <tr>
                    <th>Id</th>
                    <th>Suplidor</th>
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
                    <td>
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
                    <td>{{ item.estatus_tiket }}</td>
                    <td>
                        see
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
