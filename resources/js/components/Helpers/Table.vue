<template>
    <div class="container">
        <div class="table-responsive mt-3">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Código</th>
                        <th scope="col">Contenido</th>
                        <th scope="col">Tipo documento</th>
                        <th scope="col">Proceso</th>
                        <th scope="col">Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <template v-if="currentPageData.length > 0">
                        <tr v-for="(dataDoc, index) in currentPageData" :key="dataDoc.key">
                            <td>{{ index + 1 }}</td>
                            <td>{{ dataDoc.name }}</td>
                            <td>{{ dataDoc.pref_doc + '-' + dataDoc.pre_process + '-' + dataDoc.code }}</td>
                            <td>{{ dataDoc.content }}</td>
                            <td>{{ dataDoc.type_doc_name }}</td>
                            <td>{{ dataDoc.process_name }}</td>
                            <td>
                                <button type="button" @click="$emit('download', dataDoc.id)" class="btn btn-secondary"
                                    title="Descargar">
                                    <i class="fa-solid fa-file-arrow-down"></i>
                                </button>
                                <button type="button" @click="$emit('edit', dataDoc.id)" class="btn btn-dark"
                                    title="Editar">
                                    <i class="fa-solid fa-pen-to-square mr-2"></i>
                                </button>
                                <button type="button" @click="confirmDelete(dataDoc.id)" class="btn btn-danger"
                                    title="Eliminar">
                                    <i class="fa-solid fa-trash-can mr-2"></i>
                                </button>
                            </td>
                        </tr>
                    </template>
                    <template v-else>
                        <tr>
                            <td colspan="7">No hay documentos registrados.</td>
                        </tr>
                    </template>
                </tbody>
            </table>
            <nav aria-label="...">
                <ul class="pagination justify-content-end">
                    <li class="page-item" :class="{ disabled: currentPage === 1 }">
                        <span class="page-link" @click="goToPage(currentPage - 1)">Anterior</span>
                    </li>

                    <li class="page-item" v-for="page in totalPageCount" :key="page"
                        :class="{ active: currentPage === page }">
                        <a class="page-link" @click="goToPage(page)">{{ page }}</a>
                    </li>

                    <li class="page-item" :class="{ disabled: currentPage === totalPageCount }">
                        <a class="page-link" @click="goToPage(currentPage + 1)">Siguiente</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
const props = defineProps({
    dataDocuments: Array,
});
const emit = defineEmits(["download", "edit", "deteleDoc"]);
const itemsPerPage = ref(10);
const currentPage = ref(1);

const totalPageCount = computed(() => {
    return Math.ceil(props.dataDocuments.length / itemsPerPage.value);
});

const currentPageData = computed(() => {
    const startIndex = (currentPage.value - 1) * itemsPerPage.value;
    const endIndex = startIndex + itemsPerPage.value;
    return props.dataDocuments.slice(startIndex, endIndex);
});

const goToPage = (page) => {
    if (page >= 1 && page <= totalPageCount.value) {
        currentPage.value = page;
    }
};
const confirmDelete = (id) => {
    Swal.fire({
        title: '¿Estás Seguro?',
        text: "No podrás revertirlo.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, bórralo!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            emit('deleteDoc', id);
        }
    })
}
</script>
