import { ref, onMounted } from 'vue';
import { Laboratory, LaboratoryResponse } from '@/Pages/Laboratory/Interfaces/LaboratoryResponse';
import { getLaboratories, createLaboratory, updateLaboratory, deleteLaboratory } from '@/Services/LaboratoryService';

export default function useLaboratories(toast: any) {
    const laboratoriesData = ref<Laboratory[]>([]);
    const loadingTable = ref<boolean>(true);
    const pagination = ref({
        total: 0,
        current_page: 1,
        per_page: 20,
        last_page: 0,
        from: 0,
        to: 0
    });
    const showCreateModal = ref<boolean>(false);
    const showDeleteModal = ref<boolean>(false);
    const selectedLaboratory = ref<Laboratory | null>(null);

    const fetchLaboratories = async (page = 1, name = '') => {
        loadingTable.value = true;
        try {
            const response = await getLaboratories(page, name);
            laboratoriesData.value = response.data;
            pagination.value = response.pagination;
        } catch (error) {
            console.error('Error fetching laboratories:', error);
            toast.add({
                severity: 'error',
                summary: 'Error',
                detail: 'Error al cargar los laboratorios',
                life: 3000
            });
        } finally {
            loadingTable.value = false;
        }
    };

    const searchLaboratory = async (name: string) => {
        await fetchLaboratories(1, name);
    };

    const openCreateModal = () => {
        selectedLaboratory.value = null;
        showCreateModal.value = true;
    };

    const openEditModal = (laboratory: Laboratory) => {
        selectedLaboratory.value = laboratory;
        showCreateModal.value = true;
    };

    const openDeleteModal = (laboratory: Laboratory) => {
        selectedLaboratory.value = laboratory;
        showDeleteModal.value = true;
    };

    const closeCreateModal = () => {
        showCreateModal.value = false;
        selectedLaboratory.value = null;
    };

    const closeDeleteModal = () => {
        showDeleteModal.value = false;
        selectedLaboratory.value = null;
    };

    const handleCreateLaboratory = async (laboratory: Omit<Laboratory, 'id' | 'created_at' | 'updated_at'>) => {
        try {
            await createLaboratory(laboratory);
            toast.add({
                severity: 'success',
                summary: 'Éxito',
                detail: 'Laboratorio creado exitosamente',
                life: 3000
            });
            await fetchLaboratories();
            closeCreateModal();
        } catch (error) {
            console.error('Error creating laboratory:', error);
            toast.add({
                severity: 'error',
                summary: 'Error',
                detail: 'Error al crear el laboratorio',
                life: 3000
            });
        }
    };


    const handleUpdateLaboratory = async (id: number, data: Partial<Omit<Laboratory, 'id' | 'created_at' | 'updated_at'>>) => {
        try {
         // console.log('Updating laboratory with data:', data);
          await updateLaboratory(id, data);
          toast.add({
            severity: 'success',
            summary: 'Éxito',
            detail: 'Laboratorio actualizado exitosamente',
            life: 3000
          });
          await fetchLaboratories();
          closeCreateModal();
        } catch (error) {
          console.error('Error updating laboratory:', error);
          toast.add({
            severity: 'error',
            summary: 'Error',
            detail: 'Error al actualizar el laboratorio',
            life: 3000
          });
        }
      };
      
    const handleDeleteLaboratory = async (id: number) => {
        try {
            await deleteLaboratory(id);
            toast.add({
                severity: 'success',
                summary: 'Éxito',
                detail: 'Laboratorio eliminado exitosamente',
                life: 3000
            });
            await fetchLaboratories();
            closeDeleteModal();
        } catch (error) {
            console.error('Error deleting laboratory:', error);
            toast.add({
                severity: 'error',
                summary: 'Error',
                detail: 'Error al eliminar el laboratorio',
                life: 3000
            });
        }
    };

    onMounted(() => {
        fetchLaboratories();
    });

    return {
        laboratoriesData,
        loadingTable,
        pagination,
        showCreateModal,
        showDeleteModal,
        selectedLaboratory,
        fetchLaboratories,
        searchLaboratory,
        openCreateModal,
        openEditModal,
        openDeleteModal,
        closeCreateModal,
        closeDeleteModal,
        handleCreateLaboratory,
        handleUpdateLaboratory,
        handleDeleteLaboratory
    };
}