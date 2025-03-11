<template>
    <Dialog
        :visible="isVisible"
        modal
        :header="role.id ? 'Actualizar Doctor' : 'Crear Doctor'"
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
                    v-model="roleLocal.name"
                    id="name"
                    type="text"
                    class="w-full"
                    name="name"
                />
                <label for="name">Nombre</label>
            </FloatLabel>
            <ToggleButton
                id="state"
                v-model="roleLocal.state"
                onLabel="Activo"
                offLabel="Inactivo"
                onIcon="pi pi-check"
                offIcon="pi pi-times"
            />
            <div class="flex justify-end gap-4">
                <Button
                    label="Guardar"
                    :icon="roleLocal.id ? 'pi pi-pencil' : 'pi pi-check'"
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
import { ref, watch } from "vue";
import { Role } from "../Interfaces/Role";
import { Button, Dialog, FloatLabel, InputText, ToggleButton } from "primevue";

const { isVisible, role } = defineProps<{
    isVisible: boolean;
    role?: Role;
}>();

const roleLocal = ref<Role>({
    id: role?.id || 0,
    name: role?.name || "",
    state: role?.state || true,
    created_at: role?.created_at || null,
    updated_at: role?.updated_at || null,
});

const emit = defineEmits<{
    (e: "emitCloseModal", state: boolean): void;
    (e: "emitSuccessCreate", dataForm: Role): void;
}>();

const closeModal = () => {
    emit("emitCloseModal", false);
};

const submit = () => {
    emit("emitSuccessCreate", roleLocal.value);
};

watch(
    () => role,
    (nuewRole) => {
        if (nuewRole) {
            roleLocal.value = { ...nuewRole };
        }
    }
);
</script>
<style scoped lang="css"></style>
