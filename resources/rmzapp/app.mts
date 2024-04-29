import {createApp} from 'vue';
import {createRouter, createWebHistory} from 'vue-router';
import App from './App.vue';
import HomePage from './components/HomePage.vue';
import EstatePage from './components/EstatePage.vue';

const history = createWebHistory();
const routes = [
    {path: '/', component: HomePage},
    {path: '/estate/:estateID', component: EstatePage},
];
const router = createRouter({history, routes});

createApp(App).use(router).mount('#rmz_app');
