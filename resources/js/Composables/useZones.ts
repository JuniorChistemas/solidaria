import { ref, onMounted } from "vue";
import { getZones, createZone, updateZone, deleteZone } from "@/Services/ZoneService";
import { Zone, ZoneResponse } from "@/Pages/Zone/Interfaces/ZoneResponse";

export default function useZones(toast) {
    const zonesData = ref<Zone[]>([]);
    const loadingTable = ref<boolean>(true);
    const pagination = ref<ZoneResponse["pagination"]>({
        total: 0,
        current_page: 1,
        per_page: 10,
        last_page: 1,
        from: 0,
        to: 0
    });

    const nameZone = ref<string>("");
    const showCreateModal = ref<boolean>(false);
    const showDeleteModal = ref<boolean>(false);
    const selectedZone = ref<Zone | null>(null);

    const fetchZones = async (page: number = pagination.value.current_page, name: string = nameZone.value) => {
        loadingTable.value = true;
        try {
            const data = await getZones(page, name);
            console.log("Zonas cargadas:", data);  // <---- Agregado para depuración
            zonesData.value = data.data;
            pagination.value = data.pagination;
        } catch (error) {
            console.error("Error al obtener las zonas:", error.response?.data || error);
            toast.add({
                severity: "error",
                summary: "Error",
                detail: "No se pudieron cargar las zonas",
                life: 3000
            });
        } finally {
            loadingTable.value = false;
        }
    };
    

const searchZone = (name: string) => {
        nameZone.value = name;
        fetchZones(1, name);
    };

    const openCreateModal = () => {
        selectedZone.value = null;
        showCreateModal.value = true;
    };

    const openEditModal = (zone: Zone) => {
        console.log("Abriendo modal de edición para:", zone); // ✅ Verificar valores
        selectedZone.value = zone;
        showCreateModal.value = true;
    };

    const openDeleteModal = (zone: Zone) => {
        selectedZone.value = zone;
        showDeleteModal.value = true;
    };

    const closeCreateModal = () => {
        showCreateModal.value = false;
    };

    const closeDeleteModal = () => {
        showDeleteModal.value = false;
    };

    const handleCreateZone = async (zoneData: { name: string }) => {
        try {
            await createZone(zoneData);
            toast.add({ severity: "success", summary: "Éxito", detail: "Zona creada correctamente", life: 3000 });
            fetchZones(1, nameZone.value); // ✅ Recargar lista
        } catch (error) {
            toast.add({ severity: "error", summary: "Error", detail: error.response?.data?.message || "No se pudo crear la Zona", life: 3000 });
        } finally {
            closeCreateModal();
        }
    };
    
    const handleUpdateZone = async (zoneId: number, zoneData: { name: string }) => {
        try {
            console.log("Zona a actualizar:", zoneId, zoneData); // ✅ Verificar valores
            await updateZone(zoneId, zoneData);
            toast.add({
                severity: "success",
                summary: "Éxito",
                detail: "Zona actualizada correctamente",
                life: 3000
            });
            fetchZones(pagination.value.current_page, nameZone.value);
        } catch (error) {
            console.error("Error al actualizar zona:", error.response?.data);
            toast.add({
                severity: "error",
                summary: "Error",
                detail: "No se pudo actualizar la zona",
                life: 3000
            });
        } finally {
            closeCreateModal();
        }
    };
    const handleDeleteZone = async (zoneId: number) => {
        try {
            await deleteZone(zoneId);
            toast.add({ severity: "success", summary: "Éxito", detail: "Zona eliminada correctamente", life: 3000 });
            fetchZones(1, nameZone.value); // ✅ Recargar lista
        } catch (error) {
            toast.add({ severity: "error", summary: "Error", detail: "No se pudo eliminar la zona", life: 3000 });
        } finally {
            closeDeleteModal();
        }
    };    

    onMounted(() => fetchZones());

    return {
        zonesData,
        loadingTable,
        pagination,
        nameZone,
        showCreateModal,
        showDeleteModal,
        selectedZone,
        fetchZones,
        searchZone,
        openCreateModal,
        openEditModal,
        openDeleteModal,
        closeCreateModal,
        closeDeleteModal,
        handleCreateZone,
        handleUpdateZone,
        handleDeleteZone
    };
}
