<template>
    <Dialog
        :visible="isVisible"
        header="Confirmar Eliminación"
        :modal="true"
        @update:visible="closeModal"
    >
        <div class="p-4">
            <p>
                ¿Estás seguro de que deseas eliminar el rol
                <strong>{{ role.name }}</strong
                >?
            </p>
        </div>
        <template #footer>
            <Button
                label="Cancelar"
                class="p-button-text"
                @click="closeModal"
            />
            <Button
                label="Eliminar"
                class="p-button-danger"
                @click="confirmDelete"
            />
        </template>
    </Dialog>
</template>
<script setup lang="ts">
import { Button, Dialog } from "primevue";
import { Role } from "../Interfaces/Role";

const props = defineProps<{
    role: Role;
    isVisible: boolean;
}>();

const emit = defineEmits<{
    (e: "emitCloseModal", state: boolean): void;
    (e: "emitConfirmDelete", roleId: number): void;
    (e: "emitSuccessDelete", roleId: number): void;
}>();

const closeModal = () => {
    emit("emitCloseModal", false);
};

const confirmDelete = () => {
    emit("emitConfirmDelete", props.role.id);
};
</script>
<style scoped lang="css"></style>
