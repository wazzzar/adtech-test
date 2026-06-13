<script setup>
import {onBeforeUnmount, onMounted, ref, useTemplateRef} from 'vue';
import axios from 'axios';
import Item from "./item.vue";

let proxies = ref(null);

const _axios = axios.create({
    headers: {
        'Accept': 'application/json',
    }
});

const proxyReq = (method, url, success, data = null) => {
    _axios({
        method: method,
        url: url,
        data: data,
    }).then((response) => {
        success(response);
    }).catch((error) => {
        alert(makeErrorText(error));
    });
};

function makeErrorText(error) {
    let errors = error.response.data.errors ?? [];
    let text = error.response.data.message ?? '';
    for (let error in errors) {
        text += '\n'+ errors[error][0];
    }
    return text;
}

let interval = null;
onMounted(() => {
    proxyReq('get', '/api/proxy', (response) => { proxies.value = response.data });
    interval = setInterval(proxyReq, 5*60*1000);
});

onBeforeUnmount(() => {
    if (interval) {
        clearInterval(interval);
    }
});

let addMode = ref(false);
const addForm = useTemplateRef('add-form');
function addProxy() {
    proxyReq('post', '/api/proxy', (response) => {
        if (response.status === 200) {
            proxies.value.push(response.data);
            addForm.value.reset();
            addMode.value = false;
            return true;
        }
        alert(response.statusText);
    }, new FormData(addForm.value));
}

function delProxy(proxy) {
    if(confirm('delete?')) {
        proxyReq('delete', `/api/proxy/${proxy.id}`, (response) => {
            if (response.status === 200) {
                proxies.value.splice(proxies.value.indexOf(proxy), 1);
                return true;
            }
            alert(response.statusText);
        });
    }
}
</script>

<template>
    <table class="table table-bordered">
        <thead>
            <tr>
                <td class="col col-1"><b>ID</b></td>
                <td class="col col-4"><b>Name</b></td>
                <td class="col col-4"><b>IP Address</b></td>
                <td class="col col-1"><b>Status</b></td>
                <td class="col col-2" colspan="2"><b>Actions</b></td>
            </tr>
        </thead>
        <tbody>
            <item
                v-for="proxy in proxies"
                :proxy="proxy"
                :proxyReq="proxyReq"
                :key="proxy.id"
                @delete="delProxy"
            />
        </tbody>
        <tfoot>
            <tr>
                <td v-show="!addMode">
                    <button class="btn btn-success" @click="addMode = true">
                        <i class="bi bi-plus-circle-fill">&nbsp;Add</i>
                    </button>

                </td>
                <td v-show="addMode" colspan="6">
                    <form action="#" @submit.prevent.stop="addProxy()" ref="add-form" class="col col-3">
                        <div class="form-group">
                            <label>Name:</label>
                            <input required name="name" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>IP Address:</label>
                            <input required name="address" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" name="status" value="active">
                                <label class="form-check-label" for="flexSwitchCheckChecked">Status:</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>&nbsp;
                        <button type="button" class="btn btn-secondary" @click="addMode = false">Cancel</button>
                    </form>
                </td>
            </tr>
        </tfoot>
    </table>
</template>

<style scoped>

</style>
