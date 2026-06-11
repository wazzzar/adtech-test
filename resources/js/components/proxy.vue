<script setup>
import { ref } from 'vue';
import axios from 'axios';

const proxies = ref([
    {
        "name": "test",
        "address": "test",
        "status": "test",
    },
]);

const _axios = axios.create({
    headers: {
        'Accept': 'application/json',
    }
});

_axios({
    method: 'get',
    url: '/api/proxy',
}).then((response) => {
    proxies.value = response.data.data;
}).catch((error) => {
    console.error('Axios error:', error);
});
console.log(proxies);
</script>

<template>
    <table>
        <tbody>
            <tr v-for="proxy in proxies">
                <td>{{ proxy.name }}</td>
                <td>{{ proxy.address }}</td>
                <td>{{ proxy.status }}</td>
            </tr>
        </tbody>
    </table>
</template>

<style scoped>

</style>
