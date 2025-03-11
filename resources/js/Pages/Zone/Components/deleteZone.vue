<template>
    <Dialog
        v-model:visible="showModal"
        header="Confirmar Eliminación"
        :modal="true"
    >
        <div class="p-4">
            <p>
                ¿Estás seguro de que deseas eliminar la zona
                <strong>{{ zone.name }}</strong
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
                @click="deleteZone"
            />
        </template>
    </Dialog>
</template>

<script setup>
import { ref, watch } from "vue";
import Dialog from "primevue/dialog";
import Button from "primevue/button";

const emit = defineEmits(["delete", "refreshList", "closeDeleteModal"]);

const props = defineProps({
    zone: Object,
    visible: Boolean,
});

const showModal = ref(props.visible);

watch(
    () => props.visible,
    (val) => {
        showModal.value = val;
    }
);

function closeModal() {
    showModal.value = false;
    emit("closeDeleteModal");
}

async function deleteZone() {
    try {
        emit("delete", props.zone.id);
        emit("refreshList");
        closeModal();
    } catch (error) {
        console.error("Error al eliminar la zona:", error);
    }
}
</script>
