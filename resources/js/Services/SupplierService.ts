import { SupplierDTO } from "@/Pages/Supplier/Interfaces/SupplierDTO";
import axios from "axios";

export const SupplierServices = {
    async getSuppliers(page: number, name: string = "") {
        try {
            const response = await axios.get("/modulo/suppliers/list", {
                params: { page, name },
            });
            // console.log(response.data);
            return response.data;
        } catch (error) {
            console.error("Error fetching suppliers:", error);
            throw error;
        }
    },
    async getSupplierdId(id: number) {
        try {
            const response = await axios.get(`/modulo/supplier/${id}`);
            return response.data;
        } catch (error) {
            console.error("Error fetching supplier:", error);
            throw error;
        }
    },
    async saveSupplier(supplier: SupplierDTO) {
        try {
            const response = await axios.post("/modulo/supplier", supplier);
            return response.data;
        } catch (error) {
            console.error("Error saving supplier hola:", error);
            throw error;
        }
    },
    async updateSupplier(supplier: SupplierDTO) {
        try {
            const response = await axios.put(
                `/modulo/supplier/${supplier.id}`,
                supplier
            );
            return response.data;
        } catch (error) {
            console.error("Error updating supplier:", error);
            throw error;
        }
    },
    async deleteSupplier(id: number) {
        try {
            const response = await axios.delete(`/modulo/supplier/${id}`);
            return response.data;
        } catch (error) {
            console.error("Error deleting supplier:", error);
            throw error;
        }
    },
};
