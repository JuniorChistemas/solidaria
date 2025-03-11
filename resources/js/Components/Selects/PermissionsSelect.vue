<template>
    <!-- http://127.0.0.1:8000/modulo/permissions -->
    <div class="flex flex-col gap-1 w-1/4">
        <Select
            v-model="selectedPermissions"
            :options="Permissions"
            option-label="name"
            option-value="id"
            placeholder="seleccionar el permiso"
            fluid
            class="w-3/4"
        />
    </div>
</template>
<script setup lang="ts">
import axios from "axios";
import { Select } from "primevue";
import { onMounted, ref } from "vue";

const Permissions = ref([]);
const selectedPermissions = ref();

// get permissions
const getPermissions = async () => {
    try {
        const { data } = await axios.get("/modulo/permissions");
        Permissions.value = data;
    } catch (e) {
        console.log(e);
    }
};

// onMounted
onMounted(() => {
    getPermissions();
});
</script>
<style scoped lang="css"></style>
