import { createRouter, createWebHistory } from "vue-router"
import DocumentComponentVue from "./components/DocumentComponent.vue";
import CreateVue from "./Pages/Create.vue";
import EditVue from "./Pages/Edit.vue";
const routes = [
    {
        path: '/',
        component: DocumentComponentVue
    },
    {
        path: '/create',
        name: 'create',
        component: CreateVue
    },
    {
        path: '/edit/:id',
        name: 'edit',
        component: EditVue
    },
];
const router = createRouter({
    history: createWebHistory(),
    routes
})
export default router;