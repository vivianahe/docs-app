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
                        <h3 class="card-title">Editar documento</h3>
                    </div>
                </div>
                <form @submit.prevent="editDoc">
                    <div class="row g-3">
                        <div class="col">
                            <label for="name" class="form-label">Nombre:*</label>
                            <input type="text" v-model="docs.name" class="form-control" required>
                        </div>
                    </div>
                    <div class="row g-3 mt-2">
                        <div class="col">
                            <label for="content" class="form-label">Contenido:*</label>
                            <textarea class="form-control" v-model="docs.content" required></textarea>
                        </div>
                    </div>
                    <div class="row g-3 mt-2">
                        <div class="col">
                            <label for="type" class="form-label">Tipo de documento:*</label>
                            <select id="inputState" v-model="docs.type_document" class="form-select" required>
                                <option :value="null" selected>Selecciona una opción</option>
                                <option v-for="typeDocument in typeDocuments" :key="typeDocument.id"
                                    :value="typeDocument.id">{{ typeDocument.name }}
                                </option>
                            </select>
                        </div>
                        <div class="col">
                            <label for="content" class="form-label">Proceso:*</label>
                            <select id="inputState" v-model="docs.process" class="form-select" required>
                                <option :value="null" selected>Selecciona una opción</option>
                                <option v-for="pro in process" :key="pro.id" :value="pro.id">{{ pro.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col mt-4">
                        <button v-if="loader" type="submit" class="btn btn-success">Guardar <i
                                class="fa-solid fa-floppy-disk"></i></button>
                        <button v-else disabled type="button" class="btn btn-success">
                            <i class="fa-solid fa-spinner"></i>
                            Guardando
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import axios from 'axios';
import { useRouter, useRoute } from "vue-router";
const router = useRouter();
const route = useRoute();
const DocId = route.params.id;
const typeDocuments = ref([]);
const process = ref([]);
const loader = ref(true);
const docs = ref({
    id: "",
    name: "",
    content: "",
    type_document: null,
    process: null
});

const getDocumentId = () => {
    axios.get('/api/documents/' + DocId )
        .then(response => {
            docs.value.name = response.data.name;
            docs.value.content = response.data.content;
            docs.value.type_document = response.data.type_document_id;
            docs.value.process = response.data.process_id  ;
        })
        .catch(error => {
            console.error(error);
        });
}
const getTypeDocuments = () => {
    axios.get('/api/type_documents')
        .then(response => {
            typeDocuments.value = response.data;
        })
        .catch(error => {
            console.error(error);
        });
}
const getProcess = () => {
    axios.get('/api/process')
        .then(response => {
            process.value = response.data;
        })
        .catch(error => {
            console.error(error);
        });
}
const editDoc = () => {
    if (docs.value.type_document !== null && docs.value.process !== null) {
        loader.value = false;
        axios.put('/api/documents/'+DocId, docs.value)
            .then((response) => {
                if (response.data === 'ok') {
                    loader.value = true;
                    Swal.fire("Correcto!", 'Documento guardado correctamente!', "success");
                    router.push({ path: '/' });
                }
            })
            .catch((error) => {
                loader.value = true;
                console.error(error);
            });
    } else {
        Swal.fire(
            "Atención!",
            "Todos los campos deben ser diligenciados!",
            "warning"
        );
    }
};
onMounted(() => {
    getTypeDocuments();
    getProcess();
    getDocumentId();
});
</script>