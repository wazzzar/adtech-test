import { createApp } from 'vue';
import proxyComponent from './components/test.vue';

console.log('Vue app starting...');
console.log('proxyComponent:', proxyComponent);

const app = createApp(proxyComponent);
app.mount(document.querySelector('#app'));
app.config.errorHandler = (err) => {
    console.error(err);
}
console.log('Vue app mounted');
