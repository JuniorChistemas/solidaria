<template>
    <DataTable
        :value="rolesData"
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
                Roles {{ pagination.from }} a {{ pagination.to }} de
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
                        v-model="nameRole"
                        class="w-32 sm:w-auto"
                        @input="handleSearchInput"
                    />
                </div>
                <div>
                    <Button label="Nuevo" @click="emitIdRoleCreate(0)" />
                </div>
            </div>
        </template>
        <template #empty>
            <h3>No existen datos</h3>
        </template>
        <Column header="#">
            <template #body="slotProps">
                <Badge
                    :value="slotProps.data.id.toString()"
                    severity="secondary"
                />
            </template>
        </Column>
        <Column field="name" header="Nombre"></Column>
        <Column header="Estado" align-frozen="left">
            <template #body="slotProps">
                <Tag
                    :severity="colorTag(slotProps.data.state)"
                    :value="textTag(slotProps.data.state)"
                />
            </template>
        </Column>
        <Column field="created_at" header="Fecha creado"></Column>
        <Column field="updated_at" header="Fecha Actalizado"></Column>
        <Column header="Acciones" align-frozen="right">
            <template #body="slotProps">
                <div class="flex flex-row gap-2">
                    <Button
                        icon="pi pi-pencil"
                        outlined
                        rounded
                        class="p-button-sm"
                        tooltip="Editar"
                        @click="emitIdRoleCreate(slotProps.data.id)"
                    />
                    <Button
                        icon="pi pi-trash"
                        outlined
                        rounded
                        class="p-button-sm"
                        severity="danger"
                        tooltip="Eliminar"
                        @click="emitIdRoleDelete(slotProps.data.id)"
                    />
                </div>
            </template>
        </Column>
    </DataTable>
</template>
<script setup lang="ts">
import { Pagination } from "@/Interfaces/Pagination";
import { RoleDTO } from "../Interfaces/RoleDTO";
import { ref } from "vue";
import debounce from "lodash.debounce";
import { Badge, Button, Column, DataTable, InputText, Tag } from "primevue";
import { colorTag, textTag } from "@/Utils/state";

const { rolesData, pagination, loadingTable } = defineProps<{
    rolesData: RoleDTO[];
    pagination: Pagination;
    loadingTable: boolean;
}>();

const emit = defineEmits<{
    (e: "loadingPage", page: number): void;
    (e: "emitIdRole", id: number): void;
    (e: "emitDeleteRole", id: number): void;
    (e: "searchRole", name: string): void;
}>();

const nameRole = ref<string>("");

function nextPage(event: any) {
    const newPage = event.page + 1;
    emit("loadingPage", newPage);
}

const debounceSearch = debounce((value: string) => {
    emit("searchRole", value);
}, 500);

function handleSearchInput(event: Event) {
    const value = (event.target as HTMLInputElement).value;
    debounceSearch(value);
}

function emitIdRoleCreate(id: number) {
    emit("emitIdRole", id);
}

function emitIdRoleDelete(id: number) {
    emit("emitDeleteRole", id);
}
</script>
<style scoped lang="css"></style>
