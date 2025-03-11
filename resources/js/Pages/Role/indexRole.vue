<template>
    <AppLayout title="Role">
        <div class="mi_card flex flex-col justify-normal gap-3">
            <TableRoles
                :roles-data="father.rolesData"
                :pagination="father.pagination"
                :loading-table="father.loadingTable"
                @loading-page="loandingPage"
                @search-role="searchRole"
                @emit-id-role="emitIdRoleRegister"
                @emit-delete-role="emitIdRoleDelete"
            />
            <CreateRoles
                :is-visible="father.statusModal.register"
                :role="father.roleData"
                @emit-close-modal="closeModalAll('register')"
                @emit-success-create="saveRole"
            />
            <DeleteRoles
                :role="father.roleData"
                :is-visible="father.statusModal.delete"
                @emit-close-modal="closeModalAll('delete')"
                @emit-confirm-delete="deleteRole"
            />
        </div>
    </AppLayout>
</template>
<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import TableRoles from "./Components/TableRoles.vue";
import { useRoles } from "@/Composables/useRoles";
import CreateRoles from "./Components/CreateRoles.vue";
import DeleteRoles from "./Components/DeleteRoles.vue";
const {
    father,
    loandingPage,
    searchRole,
    emitIdRoleRegister,
    emitIdRoleDelete,
    closeModalAll,
    saveRole,
    deleteRole,
} = useRoles();
</script>
<style scoped></style>
