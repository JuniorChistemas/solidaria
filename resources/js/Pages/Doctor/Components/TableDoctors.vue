<template>
    <DataTable
        :value="doctorsData"
        :lazy="true"
        :paginator="true"
        :rows="pagination.per_page"
        :total-records="pagination.total"
        @page="nextPage"
        size="small"
        scrollable
        scroll-height="35rem"
        data-key="id"
        show-gridlines
        :loading="loadingTable"
    >
        <template #paginatorstart>
            <!-- details of the pages and amount of data that exists -->
            <span>
                Doctores {{ pagination.from }} a {{ pagination.to }} de
                {{ pagination.total }}</span
            >
        </template>
        <template #header>
            <div class="flex justify-between gap-2">
                <div class="mr-auto flex items-center gap-2">
                    <InputText
                        id="search"
                        placeholder="Buscar"
                        type="text"
                        v-model="nameDoctor"
                        class="w-32 sm:w-auto"
                        @input="handleSearchInput"
                    />
                </div>
                <div>
                    <Button label="Nuevo" @click="emitIdDoctorCreate(0)" />
                </div>
            </div>
        </template>
        <template #empty>
            <h3>No existen datos</h3>
        </template>
        <Column header="№">
            <template #body="slotProps">
                <Badge
                    :value="slotProps.data.id.toString()"
                    severity="secondary"
                />
            </template>
        </Column>
        <Column field="code" header="Codigo"></Column>
        <Column field="name" header="Nombre"></Column>
        <Column field="start_date" header="Fecha de inicio"></Column>
        <Column header="Estado" align-frozen="left">
            <template #body="slotProps">
                <Tag
                    :severity="colorTag(slotProps.data.state)"
                    :value="textTag(slotProps.data.state)"
                />
            </template>
        </Column>
        <Column>
            <template #body="slotProps">
                <div class="flex gap-2">
                    <Button
                        icon="pi pi-pencil"
                        outlined
                        rounded
                        class="p-button-sm"
                        tooltip="Editar"
                        @click="emitIdDoctorCreate(slotProps.data.id)"
                    />
                    <Button
                        icon="pi pi-trash"
                        outlined
                        rounded
                        class="p-button-sm"
                        severity="danger"
                        tooltip="Eliminar"
                        @click="emitIdDoctorDelete(slotProps.data.id)"
                    />
                </div>
            </template>
        </Column>
    </DataTable>
</template>
<script setup lang="ts">
import { Pagination } from "@/Interfaces/Pagination";
import { ref } from "vue";
import { Badge, Button, Column, DataTable, InputText, Tag } from "primevue";
import { colorTag, textTag } from "@/Utils/state";
import debounce from "lodash.debounce";
import { DoctorDTO } from "../Interfaces/DoctorDTO";

const { doctorsData, pagination, loadingTable } = defineProps<{
    doctorsData: DoctorDTO[];
    pagination: Pagination;
    loadingTable: boolean;
}>();

const emit = defineEmits<{
    (e: "loadingPage", page: number): void;
    (e: "emitIdDoctor", id: number): void;
    (e: "emitDeleteDoctor", id: number): void;
    (e: "searchDoctor", name: string): void;
}>();

const nameDoctor = ref<string>("");

function nextPage(event: any) {
    const newPage = event.page + 1;
    emit("loadingPage", newPage);
}

const debounceSearchDoctor = debounce((value: string) => {
    emit("searchDoctor", value);
}, 400);

function handleSearchInput(event: Event) {
    const value = (event.target as HTMLInputElement).value;
    debounceSearchDoctor(value);
}

function emitIdDoctorCreate(id: number) {
    emit("emitIdDoctor", id);
}

function emitIdDoctorDelete(id: number) {
    emit("emitDeleteDoctor", id);
}
</script>
<style scoped></style>
