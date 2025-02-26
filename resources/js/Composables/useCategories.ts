import { ref, onMounted } from "vue";
import { getCategories, createCategory, updateCategory, deleteCategory } from "@/Services/CategoryService";
import { Category, CategoryResponse } from "@/Pages/Category/Interfaces/CategoryResponse";

export default function useCategories(toast) {
    const categoriesData = ref<Category[]>([]);
    const loadingTable = ref<boolean>(true);
    const pagination = ref<CategoryResponse["pagination"]>({
        total: 0,
        current_page: 1,
        per_page: 10,
        last_page: 1,
        from: 0,
        to: 0
    });

    const nameCategory = ref<string>("");
    const showCreateModal = ref<boolean>(false);
    const showDeleteModal = ref<boolean>(false);
    const selectedCategory = ref<Category | null>(null);

    const fetchCategories = async (page: number = pagination.value.current_page, name: string = nameCategory.value) => {
        loadingTable.value = true;
        try {
            const data = await getCategories(page, name);
            categoriesData.value = data.data;
            pagination.value = data.pagination;
        } catch (error) {
            toast.add({
                severity: "error",
                summary: "Error",
                detail: "No se pudieron cargar las categorías",
                life: 3000
            });
        } finally {
            loadingTable.value = false;
        }
    };

    const searchCategory = (name: string) => {
        nameCategory.value = name;
        fetchCategories(1, name);
    };

    const openCreateModal = () => {
        selectedCategory.value = null;
        showCreateModal.value = true;
    };

    const openEditModal = (category: Category) => {
        selectedCategory.value = category;
        showCreateModal.value = true;
    };

    const openDeleteModal = (category: Category) => {
        selectedCategory.value = category;
        showDeleteModal.value = true;
    };

    const closeCreateModal = () => {
        showCreateModal.value = false;
    };

    const closeDeleteModal = () => {
        showDeleteModal.value = false;
    };

    const handleCreateCategory = async (categoryData: { name: string }) => {
        try {
            const response = await createCategory(categoryData);            
            toast.add({
                severity: "success",
                summary: "Éxito",
                detail: "Categoría creada correctamente",
                life: 3000
            });
    
            fetchCategories(pagination.value.current_page, nameCategory.value);
        } catch (error) {
            toast.add({
                severity: "error",
                summary: "Error",
                detail: error.response?.data?.message || "No se pudo crear la categoría",
                life: 3000
            });
        } finally {
            closeCreateModal();
        }
    };
    
    
    
    const handleUpdateCategory = async (categoryId: number, categoryData: { name: string }) => {
        try {
            await updateCategory(categoryId, categoryData);
            toast.add({
                severity: "success",
                summary: "Éxito",
                detail: "Categoría actualizada correctamente",
                life: 3000
            });
            fetchCategories(pagination.value.current_page, nameCategory.value);
        } catch (error) {
            const errorMessage = error.response?.data?.errors?.name 
                ? error.response.data.errors.name[0] 
                : "No se pudo actualizar la categoría";
    
            toast.add({
                severity: "error",
                summary: "Error",
                detail: errorMessage,
                life: 3000
            });
        } finally {
            closeCreateModal();
        }
    };
    

    const handleDeleteCategory = async (categoryId: number) => {
        try {
            await deleteCategory(categoryId);
            toast.add({
                severity: "success",
                summary: "Éxito",
                detail: "Categoría eliminada correctamente",
                life: 3000
            });
            fetchCategories(pagination.value.current_page, nameCategory.value);
        } catch (error) {
            toast.add({
                severity: "error",
                summary: "Error",
                detail: "No se pudo eliminar la categoría",
                life: 3000
            });
        } finally {
            closeDeleteModal();
        }
    };
    

    onMounted(() => fetchCategories());

    return {
        categoriesData,
        loadingTable,
        pagination,
        nameCategory,
        showCreateModal,
        showDeleteModal,
        selectedCategory,
        fetchCategories,
        searchCategory,
        openCreateModal,
        openEditModal,
        openDeleteModal,
        closeCreateModal,
        closeDeleteModal,
        handleCreateCategory,
        handleUpdateCategory,
        handleDeleteCategory
    };
}
