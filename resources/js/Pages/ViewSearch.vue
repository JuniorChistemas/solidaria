<template>
    <AppLayout>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex items-center justify-between">
                <h2
                    class="text-2xl font-semibold text-gray-700 dark:text-gray-200"
                >
                    Search
                </h2>
            </div>
            <div class="flex flex-col mt-4">
                <AutocompleteDoctor @update:model-value="doctorSelected" />
            </div>
            <div class="flex flex-col mt-4">
                <PermissionsSelect />
            </div>
        </div>
    </AppLayout>
</template>
<script setup lang="ts">
import AutocompleteDoctor from "@/Components/Autocomplete/AutocompleteDoctor.vue";
import PermissionsSelect from "@/Components/Selects/PermissionsSelect.vue";
import AppLayout from "@/Layouts/AppLayout.vue";

const doctorSelected = (id: number) => {
    console.log(id);
};
</script>
<style scoped lang="css"></style>
