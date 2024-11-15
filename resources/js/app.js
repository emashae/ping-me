import './bootstrap';
import { createApp } from 'vue/dist/vue.esm-bundler.js';
import App from '@/chat/components/App.vue';

const app = createApp({});
app.component('App', App);
console.log('Vue app is initializing...');
app.mount('#App');
