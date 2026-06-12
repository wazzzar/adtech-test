import { createApp } from 'vue';
import App from './vue/app.vue';

console.log('Vue app starting...');
const app = createApp(App);
app.mount('#app');
app.config.errorHandler = (err) => {
    console.error(err);
}
console.log('Vue app mounted');
