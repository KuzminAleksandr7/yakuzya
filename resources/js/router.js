import { createRouter, createWebHistory } from "vue-router";

const routes = [
    {
        path: "/",
        name: "home",
        component: () => import('./Pages/Home.vue')
    },
    {
        path: "/users:count?:page?",
        name: "user.index",
        component: () => import('./Pages/User/Index.vue')
    },
    {
        path: "/users/create",
        name: "user.create",
        component: () => import('./Pages/User/Create.vue')
    },
    {
        path: "/users/:userId",
        name: "user.show",
        component: () => import('./Pages/User/Show.vue')
    },
    {
        path: "/positions",
        name: "positions.index",
        component: () => import('./Pages/Positions/Index.vue')
    },
    {
        path: '/:catchAll(.*)',
        name: "not_found",
        component: () => import('./Pages/NotFound.vue')
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
