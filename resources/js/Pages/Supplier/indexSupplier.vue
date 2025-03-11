<template>
    <AppLayout title="Proveedor">
        <div class="mi_card flex flex-col justify-normal gap-3">
            <!-- table suppliers  -->
            <TableSupplier
                :suppliers-data="father.supplierDate"
                :pagination="father.pagination"
                :loading-table="father.loadingTable"
                @loading-page="loadingPage"
                @search-supplier="searchSupplier"
                @emit-id-supplier="emitIdSupplierRegister"
                @emit-delete-supplier="emitIdSupplierDelete"
            />
            <!--modal to add and update supplier -->
            <CreateSupplier
                :is-visible="father.statusModal.register"
                :supplier="father.supplierData"
                @emit-close-modal="closeModalAll('register')"
                @emit-success-create="saveSupplier"
            />
            <!-- modal to remove supplier -->
             <DeleteSupplier
                :is-visible="father.statusModal.delete"
                :supplier="father.supplierData"
                :id-supplier="father.idSupplier"
                @emit-close-modal="closeModalAll('delete')"
                @emit-success-delete="deleteSupplier"
             />
        </div>
    </AppLayout>
</template>
<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import TableSupplier from "./Components/TableSupplier.vue";
import { useSuppliers } from "@/Composables/useSuppliers";
import CreateSupplier from "./Components/CreateSupplier.vue";
import DeleteSupplier from "./Components/DeleteSupplier.vue";


const {
    father,
    loadingPage,
    searchSupplier,
    emitIdSupplierRegister,
    emitIdSupplierDelete,
    closeModalAll,
    saveSupplier,
    deleteSupplier,
} = useSuppliers();
</script>
<style scoped></style>
