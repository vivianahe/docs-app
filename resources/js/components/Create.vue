<template>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="col">
                    <a type="button" class="btn btn-secondary" href="/"> <i class="fa-solid fa-arrow-left"></i>
                        Volver</a>
                </div>
                <div class="row">
                    <div class="col text-center">
                        <h3 class="card-title">Agregar documento</h3>
                    </div>
                </div>
                <form @submit.prevent="createDoc">
                    <div class="row g-3">
                        <div class="col">
                            <label for="name" class="form-label">Nombre:</label>
                            <input type="text" v-model="docs.name" class="form-control" required>
                        </div>
                        <div class="col">
                            <label for="content" class="form-label">Contenido:</label>
                            <input type="text" v-model="docs.content" class="form-control" required>
                        </div>
                    </div>
                    <div class="row g-3 mt-2">
                        <div class="col">
                            <label for="type" class="form-label">Tipo de documento:</label>
                            <select id="inputState" v-model="docs.type_document" class="form-select" required>
                                <option :value="null" selected>Selecciona una opción</option>
                                <option v-for="typeDocument in typeDocuments" :key="typeDocument.id"
                                    :value="typeDocument.id">{{ typeDocument.name }}
                                </option>
                            </select>
                        </div>
                        <div class="col">
                            <label for="content" class="form-label">Proceso:</label>
                            <select id="inputState" v-model="docs.process" class="form-select" required>
                                <option :value="null" selected>Selecciona una opción</option>
                                <option v-for="pro in process" :key="pro.id" :value="pro.id">{{ pro.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col mt-4">
                        <button type="submit" class="btn btn-success">Guardar <i
                                class="fa-solid fa-floppy-disk"></i></button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import axios from 'axios';
const docs = ref({
    name: "",
    content: "",
    type_document: null,
    process: null,
    doc_file: null
});
const typeDocuments = ref([]);
const process = ref([]);

const getTypeDocuments = () => {
    axios.get('api/type_documents')
        .then(response => {
            typeDocuments.value = response.data;
        })
        .catch(error => {
            console.error(error);
        });
}
const getProcess = () => {
    axios.get('api/process')
        .then(response => {
            process.value = response.data;
        })
        .catch(error => {
            console.error(error);
        });
}

const createDoc = () => {
    
};

onMounted(() => {
    getTypeDocuments();
    getProcess();
});


</script>
