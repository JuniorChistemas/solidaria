import { Pagination } from "@/Interfaces/Pagination";
import { Supplier } from "@/Pages/Supplier/Interfaces/Supplier";
import { SupplierDTO } from "@/Pages/Supplier/Interfaces/SupplierDTO";
import { SupplierResponse } from "@/Pages/Supplier/Interfaces/SupplierResponse";
import { SupplierServices } from "@/Services/SupplierService";
import {
    toSupplier,
    toSupplierDTO,
} from "@/Pages/Supplier/Interfaces/SupplierConverte";
import { useToastUtil } from "@/Utils/Message";
import axios from "axios";
import { onMounted, reactive } from "vue";

export const useSuppliers = () => {
    const { showInfo, showError } = useToastUtil();
    const father = reactive({
        supplierDate: [] as SupplierDTO[],
        pagination: {} as Pagination,
        loadingTable: false as boolean,
        filter: "" as string,
        idSupplier: 0 as number,
        statusModal: {
            register: false as boolean,
            delete: false as boolean,
        },
        supplierData: {} as Supplier,
    });

    const loadingSuppliers = async (page: number = 1, name: string = "") => {
        father.loadingTable = true;
        try {
            const data = await SupplierServices.getSuppliers(page, name);
            father.supplierDate = data.data;
            father.pagination = data.pagination;
        } catch (error) {
            console.error("Error fetching suppliers:", error);
        } finally {
            father.loadingTable = false;
        }
    };

    const getSupplier = async (id: number) => {
        if (id === 0) {
            father.supplierData = {
                id: 0,
                name: "",
                ruc: "",
                phone: "",
                address: "",
            } as Supplier;
            return;
        }
        try {
            const response: SupplierResponse = await SupplierServices.getSupplierdId(
                id
            );
            father.supplierData = toSupplier(response.data);
        } catch (error) {
            console.error("Error fetching supplier:", error);
        }
    };

    // guardar o editar proveedor
    const saveSupplier = async (supplier: Supplier) => {
        father.loadingTable = true;
        try {
            // convertimos a dto
            const supplierDTO = toSupplierDTO(supplier);
            // const para response
            const response =
                supplierDTO.id === 0
                    ? await SupplierServices.saveSupplier(supplierDTO)
                    : await SupplierServices.updateSupplier(supplierDTO);
            if (response.success) {
                showInfo(response.message);
                loadingSuppliers(father.pagination.current_page, father.filter);
                father.statusModal.register = false;
            } else {
                const errors = response.errors || {
                    general: response.message || "Error al guardar el proveedor",
                };
                Object.entries(errors).forEach(([field, message]) => {
                    showError(`${field}: ${message}`);
                });
            }
        } catch (error) {
            showError(
                error.response.data.errors || "Error al guardar el proveedor"
            );
        } finally {
            father.loadingTable = false;
        }
    };

    const deleteSupplier = async (supplier: number) => {
        father.loadingTable = true;
        try {
            const response = await SupplierServices.deleteSupplier(supplier);
            if (response.success) {
                showInfo(response.message);
                loadingSuppliers(father.pagination.current_page, father.filter);
                father.statusModal.delete = false;
            }
        } catch (error) {
            console.error("Error deleting supplier:", error);
            showError("Error al eliminar");
        } finally {
            father.loadingTable = false;
        }
    };
    const loadingPage = (page: number) => {
        loadingSuppliers(page, father.filter);
    };
    const searchSupplier = (name: string) => {
        father.filter = name;
        loadingSuppliers(1, name);
    };
    const emitIdSupplierRegister = async (id: number) => {
        father.idSupplier = id || 0;
        await getSupplier(father.idSupplier);
        father.statusModal.register = true;
    };
    const emitIdSupplierDelete = async (id: number) => {
        father.statusModal.delete = true;
        father.idSupplier = id;
        await getSupplier(father.idSupplier);
    };
    const closeModalAll = (type: "register" | "delete") => {
        father.statusModal[type] = false;
        father.idSupplier = 0;
        father.supplierData = {} as Supplier;
    };
    const refreshSuppliers = () => {
        loadingSuppliers(father.pagination.current_page, father.filter);
    };
    onMounted(() => {
        loadingSuppliers();
    });

    return {
        father,
        loadingPage,
        searchSupplier,
        emitIdSupplierRegister,
        emitIdSupplierDelete,
        closeModalAll,
        refreshSuppliers,
        saveSupplier,
        deleteSupplier,
    };
};
