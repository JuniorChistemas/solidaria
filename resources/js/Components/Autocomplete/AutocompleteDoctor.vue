<template>
    <div class="container">
        <AutoComplete
            v-model="doctor_selected"
            :suggestions="doctor_suggested"
            option-label="name"
            @complete="searchDoctor"
            @item-select="selectDoctor"
        />
    </div>
</template>
<script setup lang="ts">
import axios from "axios";
import { AutoComplete } from "primevue";
import { ref } from "vue";

const emit = defineEmits<{
    (e: "update:modelValue", value: number): void;
}>();

interface Doctor {
    id: number;
    name: string;
    code: string;
}

const doctor_suggested = ref<Doctor[]>([]);
const doctor_selected = ref<Doctor | null>(null);

const searchDoctor = async (event: { query: string }) => {
    try {
        const { data } = await axios.get(
            `/modulo/search/doctor?code=${event.query}`
        );
        doctor_suggested.value = data.data;
    } catch (e) {
        console.log(e);
    }
};

const selectDoctor = (event: { value: Doctor }) => {
    doctor_selected.value = event.value;
    emit("update:modelValue", event.value.id);
};
</script>
<style scoped lang="css"></style>
