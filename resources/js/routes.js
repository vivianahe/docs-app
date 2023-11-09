import { createRouter, createWebHistory } from "vue-router"
import DocumentComponentVue from "./components/DocumentComponent.vue";
import CreateVue from "./components/Create.vue";
const routes = [
    {
        path: '/',
        component: DocumentComponentVue
    },
    {
        path: '/create',
        component: CreateVue
    },
];
const router = createRouter({
    history: createWebHistory(),
    routes
})
export default router;