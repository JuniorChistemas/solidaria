<template>
    <Dialog
        :visible="isVisible"
        modal
        header="Eliminar proveedor"
        :style="{ width: '40vw' }"
        :breakpoints="{ '960px': '75vw', '640px': '100vw' }"
        @update:visible="closeModal"
    >
    <form class="flex flex-col gap-4 w-full sm:W-40 pt-3">
            <FloatLabel variant="on">
                <InputText
                    v-model="supplier.name"
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
                    v-model="supplier.ruc"
                    disabled
                />
                <label for="ruc">RUC</label>
            </FloatLabel>
            <FloatLabel variant="on">
                <InputText
                    id="code"
                    type="text"
                    class="w-full"
                    v-model="supplier.phone"
                    disabled
                />
                <label for="phone">Telefono</label>
            </FloatLabel>
            <FloatLabel variant="on">
                <InputText
                    id="code"
                    type="text"
                    class="w-full"
                    v-model="supplier.address"
                    disabled
                />
                <label for="address">Dircción</label>
            </FloatLabel>
            <ToggleButton
                id="state"
                v-model="supplier.state"
                onLabel="Activo"
                offLabel="Inactivo"
                onIcon="pi pi-check"
                offIcon="pi pi-times"
                disabled
            />
            <!-- Confirmation message -->
            <p class="text-red-500 text-sm">
                ¿Estás seguro de que deseas eliminar este proveedor? Esta acción no
                se puede deshacer.
            </p>
            <!-- Buttons to cancel or confirm deletion -->
            <div class="flex justify-end gap-4">
                <Button
                    label="Eliminar"
                    icon="pi pi-trash"
                    class="p-button-danger"
                    @click="emitIdSupplierDelete(idSupplier)"
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
import { Button, Dialog, FloatLabel, InputText, ToggleButton } from "primevue";
import { Supplier } from "../Interfaces/Supplier";

const { isVisible, supplier } = defineProps<{
    isVisible: boolean;
    idSupplier: number;
    supplier: Supplier;
}>();

const emit = defineEmits<{
    (e: "emitCloseModal", state: boolean): void;
    (e: "emitConfirmDelete", supplierId: number): void;
    (e: "emitSuccessDelete", idSupplier: number): void;
}>();

const closeModal = () => {
    emit("emitCloseModal", false);
};

const emitIdSupplierDelete = (idSupplier: number) => {
    emit("emitSuccessDelete", idSupplier);
};

const confirmDelete = () => {
    emit("emitConfirmDelete", supplier.id);
};
</script>
<style scoped lang="css"></style>