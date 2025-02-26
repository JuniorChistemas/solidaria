<template>
    <AppLayout title="Doctor">
        <div class="mi_card flex flex-col justify-normal gap-3">
            <!-- table doctors  -->
            <TableDoctors
                :doctors-data="father.doctorsDate"
                :pagination="father.pagination"
                :loading-table="father.loadingTable"
                @loading-page="loadingPage"
                @search-doctor="searchDoctor"
                @emit-id-doctor="emitIdDoctorRegister"
                @emit-delete-doctor="emitIdDoctorDelete"
            />
            <!--modal to add and update doctor -->
            <CreateDoctors
                :is-visible="father.statusModal.register"
                :doctor="father.doctorData"
                @emit-close-modal="closeModalAll('register')"
                @emit-success-create="saveDoctor"
            />
            <!-- modal to remove doctor -->
            <DeleteDoctors
                :is-visible="father.statusModal.delete"
                :doctor="father.doctorData"
                :id-doctor="father.idDoctor"
                @emit-close-modal="closeModalAll('delete')"
                @emit-success-delete="deleteDoctor"
            />
        </div>
    </AppLayout>
</template>
<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import TableDoctors from "./Components/TableDoctors.vue";
import { useDoctors } from "@/Composable/useDoctors";
import CreateDoctors from "./Components/CreateDoctors.vue";
import DeleteDoctors from "./Components/DeleteDoctors.vue";

const {
    father,
    loadingPage,
    searchDoctor,
    emitIdDoctorRegister,
    emitIdDoctorDelete,
    closeModalAll,
    saveDoctor,
    deleteDoctor,
} = useDoctors();
</script>
<style scoped></style>
