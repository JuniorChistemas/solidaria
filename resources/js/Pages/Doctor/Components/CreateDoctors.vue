<template>
    <Dialog
        :visible="isVisible"
        modal
        :header="localDoctor.id ? 'Actualizar Doctor' : 'Crear Doctor'"
        :style="{ width: '40vw' }"
        :breakpoints="{ '960px': '75vw', '640px': '100vw' }"
        @update:visible="closeModal"
    >
        <form
            @submit.prevent="submit"
            class="flex flex-col gap-4 w-full sm:W-40 pt-3"
        >
            <FloatLabel variant="on">
                <InputText
                    v-model="localDoctor.name"
                    id="name"
                    type="text"
                    class="w-full"
                    name="name"
                />
                <label for="name">Nombre</label>
            </FloatLabel>
            <FloatLabel variant="on">
                <InputText
                    id="code"
                    type="text"
                    class="w-full"
                    v-model="localDoctor.code"
                />
                <label for="code">Codigo</label>
            </FloatLabel>
            <FloatLabel variant="on">
                <DatePicker
                    id="fecha"
                    class="w-full"
                    v-model="localDoctor.start_date"
                    input-id="fecha"
                    icon-display="input"
                />
                <label for="fecha">Fecha</label>
            </FloatLabel>
            <ToggleButton
                id="state"
                v-model="localDoctor.state"
                onLabel="Activo"
                offLabel="Inactivo"
                onIcon="pi pi-check"
                offIcon="pi pi-times"
            />
            <!-- buttons to cancel and save or update -->
            <div class="flex justify-end gap-4">
                <Button
                    label="Guardar"
                    :icon="localDoctor.id ? 'pi pi-pencil' : 'pi pi-check'"
                    @click="submit"
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
import { ref, watch } from "vue";

const { isVisible, doctor } = defineProps<{
    isVisible: boolean;
    doctor?: Doctor;
}>();

const localDoctor = ref<Doctor>({
    id: doctor?.id || 0,
    name: doctor?.name || "",
    code: doctor?.code || "",
    start_date: doctor?.start_date || null,

    state: doctor?.state || true,
});

const emit = defineEmits<{
    (e: "emitCloseModal", state: boolean): void;

    (e: "emitSuccessCreate", dataForm: Doctor): void;
}>();

const closeModal = () => {
    emit("emitCloseModal", false);
};

const submit = () => {
    emit("emitSuccessCreate", localDoctor.value);
};
watch(
    () => doctor,
    (nuevoDoctor) => {
        if (nuevoDoctor) {
            localDoctor.value = { ...nuevoDoctor };
        }
    }
);
</script>

<style lang="css" scoped></style>
