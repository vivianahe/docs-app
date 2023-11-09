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
                    <tr v-for="(dataDoc, index) in dataDocuments" :key="dataDoc.key">
                        <td>{{ index + 1 }}</td>
                        <td>{{ dataDoc.name }}</td>
                        <td>{{ dataDoc.code }}</td>
                        <td>{{ dataDoc.content }}</td>
                        <td>{{ dataDoc.type_doc_name }}</td>
                        <td>{{ dataDoc.document_na }}</td>
                        <td>
                            <button type="button" @click="$emit('editar', dataDoc.id)" class="btn btn-dark">
                                <i class="fa-solid fa-pen-to-square mr-2"></i>
                                Editar
                            </button>
                            <button type="button" @click="confirmarEliminar(dataDoc.id)" class="btn btn-danger">
                                <i class="fa-solid fa-trash-can mr-2"></i>
                                Eliminar
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    dataDocuments: Array,
});
</script>
