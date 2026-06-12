<script setup>
import {ref} from "vue";
defineEmits(['delete'])

/**
 * @props->proxy - item
 * @props->proxyReq - fn(method, url, success, failed = null, data = null)
 */
const props = defineProps(['proxy', 'proxyReq']);

function toggleStatus(proxy) {
    let status = proxy.status === 'active' ? 'inactive' : 'active';
    props.proxyReq('put', `/api/proxy/${proxy.id}`, (response) => {
        if (response.status === 200) {
            proxy.status = status;
            return true;
        }
        alert(response.statusText);
    }, (error) => {
        alert(error);
    }, { ...proxy, 'status': status });
}

let editMode = ref(false);
function edit(proxy) {
    props.proxyReq('put', `/api/proxy/${proxy.id}`, (response) => {
        if (response.status === 200) {
            proxy.value = response.data;
            editMode.value = false;
            return true;
        }
        alert(response.statusText);
    }, (error) => {
        alert(error);
    }, proxy);
}

const proxy = props.proxy;
</script>

<template>
    <tr>
        <td>{{ proxy.id }}</td>
        <td v-show="!editMode">{{ proxy.name }}</td>
        <td v-show="!editMode">{{ proxy.address }}</td>
        <td v-show="editMode">
            <input required name="name" type="text" v-model="proxy.name" class="form-control"/>
        </td>
        <td v-show="editMode">
            <input required name="name" type="text" v-model="proxy.address" class="form-control"/>
        </td>
        <td>
            <a href="#" @click.prevent.stop="toggleStatus(proxy)"
               :title="(proxy.status === 'active' ? 'от' : 'в') +'ключить '+proxy.name"
               :class="'bi bi-circle'+ (proxy.status === 'active' ? '-fill' : '')"
            ></a>
        </td>
        <td v-show="!editMode">
            <button class="btn btn-primary btn-sm" @click="editMode = true">
                <i class="bi bi-pencil-square">&nbsp;Edit</i>
            </button>
        </td>
        <td v-show="!editMode">
            <button class="btn btn-danger btn-sm" @click="$emit('delete', proxy)">
                <i class="bi bi-x-octagon-fill">&nbsp;Delete</i>
            </button>
        </td>
        <td v-show="editMode">
            <button class="btn btn-success btn-sm" @click="edit(proxy)">
                <i class="bi bi-arrow-return-left">&nbsp;Save</i>
            </button>
        </td>
        <td v-show="editMode">
            <button class="btn btn-secondary btn-sm" @click="editMode = false">
                <i class="bi bi-arrow-return-right">&nbsp;Cancel</i>
            </button>
        </td>
    </tr>
</template>

<style scoped>

</style>
