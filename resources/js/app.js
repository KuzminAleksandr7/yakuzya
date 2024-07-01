import './bootstrap';
import { createApp } from 'vue';
import Index from '@/layouts/Index.vue'
import router from "./router";

createApp(Index).use(router).mount('#app');
