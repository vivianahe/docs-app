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
                <Table :dataDocuments="dataDocuments" />
            </div>
        </div>
    </div>
</template>

<script setup>
import Table from './Helpers/Table.vue';
import { onMounted, ref } from 'vue';
import axios from 'axios';

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

onMounted(() => {
    getDocuments();
});

</script>

<style>
.card {
    background: #fff;
}
</style>