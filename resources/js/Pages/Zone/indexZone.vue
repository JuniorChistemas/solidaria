<template>
    <AppLayout title="Zonas">
            <Toast position="bottom-right" />

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Lista de Zonas
            </h2>
        </template>
    <div class="p-4">
            <h3 class="text-lg font-bold mb-4">Lista de Zonas</h3>
            <TableZones
                :zonesData="zonesData"
                :pagination="pagination"
                :loadingTable="loadingTable"
                @loadingPage="fetchZones"
                @searchZone="searchZone"
                @open-create="openCreateModal"
                @open-edit="openEditModal"
                @open-delete="openDeleteModal"
            />

            <CreateZone
                v-if="showCreateModal"
                :visible="showCreateModal"
                :zone="selectedZone"
                @save="handleCreateZone"
                @update="handleUpdateZone"
                @refreshList="fetchZones" 
                @closeCreateModal="closeCreateModal"
            />

            <DeleteZone
                v-if="showDeleteModal"
                :visible="showDeleteModal"
                :zone="selectedZone"
                @delete="handleDeleteZone"
                @closeDeleteModal="closeDeleteModal"
            />
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import TableZones from "./Components/tableZone.vue";
import CreateZone from "./Components/createZone.vue";
import DeleteZone from "./Components/deleteZone.vue";
import useZones from "@/Composables/useZones";
import { useToast } from "primevue/usetoast";
import Toast from "primevue/toast";
const toast = useToast();

const {
    zonesData,
    loadingTable,
    pagination,
    showCreateModal,
    showDeleteModal,
    selectedZone,
    fetchZones,
    searchZone,
    openCreateModal,
    openEditModal,
    openDeleteModal,
    closeCreateModal,
    closeDeleteModal,
    handleCreateZone,
    handleUpdateZone,
    handleDeleteZone
} = useZones(useToast()); 


</script>
