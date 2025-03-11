<template>
    <DataTable
        :value="suppliersData"
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
            <!-- detalle de las paginas y cantidad de datos que existen -->
            <span>
                proveedores {{ pagination.from }} a {{ pagination.to }} de
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
                        v-model="nameSupplier"
                        class="w-32 sm:w-auto"
                        @input="handleSearchInput"
                    />
                </div>
                <div>
                    <Button label="Nuevo" @click="emitIdSupplierCreate(0)" />
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
        <Column field="name" header="Nombre"></Column>
        <Column field="ruc" header="Ruc"></Column>
        <Column field="phone" header="Telefono"></Column>
        <Column field="address" header="Dirección"></Column>
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
                        @click="emitIdSupplierCreate(slotProps.data.id)"
                    />
                    <Button
                        icon="pi pi-trash"
                        outlined
                        rounded
                        class="p-button-sm"
                        severity="danger"
                        tooltip="Eliminar"
                        @click="emitIdSupplierDelete(slotProps.data.id)"
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
import { SupplierDTO } from "../Interfaces/SupplierDTO";

const { suppliersData, pagination, loadingTable } = defineProps<{
    suppliersData: SupplierDTO[];
    pagination: Pagination;
    loadingTable: boolean;
}>();

const emit = defineEmits<{
    (e: "loadingPage", page: number): void;
    (e: "emitIdSupplier", id: number): void;
    (e: "emitDeleteSupplier", id: number): void;
    (e: "searchSupplier", name: string): void;
}>();

const nameSupplier = ref<string>("");

function nextPage(event: any) {
    const newPage = event.page + 1;
    emit("loadingPage", newPage);
}

const debounceSearchSupplier = debounce((value: string) => {
    emit("searchSupplier", value);
}, 400);

function handleSearchInput(event: Event) {
    const value = (event.target as HTMLInputElement).value;
    debounceSearchSupplier(value);
}

function emitIdSupplierCreate(id: number) {
    emit("emitIdSupplier", id);
}

function emitIdSupplierDelete(id: number) {
    emit("emitDeleteSupplier", id);
}
</script>
<style scoped></style>