import {createRouter, createWebHistory} from "vue-router";

const routes = [
    {
        name: 'HomePage',
        path: '/',
        component: () => import('./views/HomePage.vue')
    },
    {
        name: 'PersonalProfilePage',
        path: '/personal',
        meta: {
            requiresAuth: true,
        },
        component: () => import('./views/personal/PersonalProfilePage.vue')
    },
    {
        name: 'AuthRegPage',
        path: '/auth',
        meta: {
            onlyGuests: true,
        },
        component: () => import('./views/AuthRegPage.vue')
    },
];

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes,
});

export default router
