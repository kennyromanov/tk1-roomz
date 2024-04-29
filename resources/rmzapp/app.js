import {createApp} from 'vue';
import {createRouter, createWebHistory} from 'vue-router';
import App from './App.vue';
import HomePage from './components/HomePage.vue';

const history = createWebHistory();
const routes = [
    {path: '/', component: HomePage},
    {path: '/about', component: HomePage},
    {path: '/users/:id', component: HomePage},
];
const router = createRouter({history, routes});

createApp(App).use(router).mount('#rmz_app');
