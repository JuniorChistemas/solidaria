<template>
    <Dialog
        :visible="isVisible"
        modal
        :header="localSupplier.id ? 'Actualizar Proveedor' : 'Crear Proveedor'"
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
                    v-model="localSupplier.name"
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
                    v-model="localSupplier.ruc"
                />
                <label for="ruc">RUC</label>
            </FloatLabel>
            <FloatLabel variant="on">
                <InputText
                    id="code"
                    type="text"
                    class="w-full"
                    v-model="localSupplier.phone"
                />
                <label for="phone">Telefono</label>
            </FloatLabel>
            <FloatLabel variant="on">
                <InputText
                    id="code"
                    type="text"
                    class="w-full"
                    v-model="localSupplier.address"
                />
                <label for="address">Dirección</label>
            </FloatLabel>
            <ToggleButton
                id="state"
                v-model="localSupplier.state"
                onLabel="Activo"
                offLabel="Inactivo"
                onIcon="pi pi-check"
                offIcon="pi pi-times"
            />
            <!-- botones para cancelar y guardar o actualizar -->
            <div class="flex justify-end gap-4">
                <Button
                    label="Guardar"
                    :icon="localSupplier.id ? 'pi pi-pencil' : 'pi pi-check'"
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
import { Supplier } from "../Interfaces/Supplier";
import { ref, watch } from "vue";

const { isVisible, supplier } = defineProps<{
    isVisible: boolean;
    supplier?: Supplier;
}>();

const localSupplier = ref<Supplier>({
    id: supplier?.id || 0,
    name: supplier?.name || "",
    ruc: supplier?.ruc || "",
    phone: supplier?.phone || "",
    address: supplier?.address || "",
    state: supplier?.state || true,
});

const emit = defineEmits<{
    (e: "emitCloseModal", state: boolean): void;
    (e: "emitSuccessCreate", dataForm: Supplier): void;
}>();

const closeModal = () => {
    emit("emitCloseModal", false);
};

const submit = () => {
    emit("emitSuccessCreate", localSupplier.value);
};
watch(
    () => supplier,
    (nuevoSupplier) => {
        if (nuevoSupplier) {
            localSupplier.value = { ...nuevoSupplier };
        }
    }
);
</script>

<style lang="css" scoped></style>
