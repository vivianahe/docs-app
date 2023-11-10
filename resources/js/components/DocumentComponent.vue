<template>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h3 class="card-title">Reporte documentos</h3>
                    </div>
                    <div class="col text-end">
                        <a type="button" class="btn btn-primary" href="/create">Agregar <i class="fa-solid fa-plus"></i></a>
                    </div>
                </div>
                <Table :dataDocuments="dataDocuments" @download="download" @edit="edit" @deleteDoc="deleteDoc" />
            </div>
        </div>
    </div>
</template>

<script setup>
import Table from './Helpers/Table.vue';
import { onMounted, ref } from 'vue';
import axios from 'axios';
import { useRouter } from "vue-router";

const router = useRouter();
const dataDocuments = ref([]);

const getDocuments = () => {
    axios.get('api/documents')
        .then(response => {
            dataDocuments.value = response.data;
        })
        .catch(error => {
            console.error('Error al realizar el pedido:', error);
        });
}
const deleteDoc = (id) => {
    axios.delete('/api/documents/' + id)
        .then((response) => {
            if (response.data === 'ok') {
                Swal.fire("Correcto!", 'Documento eliminado correctamente!', "success");
                getDocuments();
            }
        })
        .catch((error) => {
            loader.value = true;
            console.error(error);
        });

};
const edit = (id) => {
    router.push({ name: 'edit', params: { id: id } });
}
const download = (id) => {
    axios.get('/api/getDataDocument/' + id)
        .then(response => {
            window.open('/support/doc/' + response.data.pref_doc + "-" + response.data.pre_process + "-" + response.data.code + '.docx');
        })
        .catch(error => {
            console.error('Error al realizar el pedido:', error);
        });
}
onMounted(() => {
    getDocuments();
});

</script>

<style>
.card {
    background: #fff;
}
</style>