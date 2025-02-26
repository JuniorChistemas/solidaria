<template>
    <Dialog
        :visible="isVisible"
        modal
        header="Eliminar doctor"
        :style="{ width: '40vw' }"
        :breakpoints="{ '960px': '75vw', '640px': '100vw' }"
        @update:visible="closeModal"
    >
        <form class="flex flex-col gap-4 w-full sm:W-40 pt-3">
            <FloatLabel variant="on">
                <InputText
                    v-model="doctor.name"
                    id="name"
                    type="text"
                    class="w-full"
                    name="name"
                    disabled
                />
                <label for="name">Nombre</label>
            </FloatLabel>
            <FloatLabel variant="on">
                <InputText
                    id="code"
                    type="text"
                    class="w-full"
                    v-model="doctor.code"
                    disabled
                />
                <label for="code">Código</label>
            </FloatLabel>
            <FloatLabel variant="on">
                <DatePicker
                    id="fecha"
                    class="w-full"
                    v-model="doctor.start_date"
                    input-id="fecha"
                    icon-display="input"
                    disabled
                />
                <label for="fecha">Fecha</label>
            </FloatLabel>
            <ToggleButton
                id="state"
                v-model="doctor.state"
                onLabel="Activo"
                offLabel="Inactivo"
                onIcon="pi pi-check"
                offIcon="pi pi-times"
                disabled
            />
            <!-- Confirmation message -->
            <p class="text-red-500 text-sm">
                ¿Estás seguro de que deseas eliminar este doctor? Esta acción no se puede deshacer.
            </p>
            <!-- Buttons to cancel or confirm deletion -->
            <div class="flex justify-end gap-4">
                <Button
                    label="Eliminar"
                    icon="pi pi-trash"
                    class="p-button-danger"
                    @click="emitIdDoctorDelete(idDoctor)"
                />
                <Button
                    label="Cancelar"
                    class="p-button-secondary"
                    @click="closeModal"
                />
            </div>
        </form>
    </Dialog>
</template>

<script setup lang="ts">
import {
    Button,
    DatePicker,
    Dialog,
    FloatLabel,
    InputText,
    ToggleButton,
} from "primevue";
import { Doctor } from "../Interfaces/Doctor";
import { defineProps, defineEmits } from "vue";

const { isVisible, doctor } = defineProps<{
    isVisible: boolean;
    idDoctor: number;
    doctor: Doctor;
}>();

const emit = defineEmits<{
    (e: "emitCloseModal", state: boolean): void;
    (e: "emitConfirmDelete", doctorId: number): void;
    (e: "emitSuccessDelete", idDoctor: number): void;
}>();

const closeModal = () => {
    emit("emitCloseModal", false);
};
const emitIdDoctorDelete = (idDoctor: number) => {
    emit("emitSuccessDelete", idDoctor);
};

const confirmDelete = () => {
    emit("emitConfirmDelete", doctor.id);
};
</script>

