import { RoleDates } from "@/Pages/Role/Interfaces/Role";
import { RoleDTO } from "@/Pages/Role/Interfaces/RoleDTO";
import axios from "axios";

export const RoleServices = {
    async getRoles(page: number, name: string = "") {
        try {
            const response = await axios.get("/modulo/roles/list", {
                params: { page, name },
            });
            return response.data;
        } catch (error) {
            console.error("Error fetching roles:", error);
            throw error;
        }
    },
    async getRoleId(id: number) {
        try {
            const response = await axios.get(`/modulo/role/${id}`);
            return response.data;
        } catch (error) {
            console.error("Error fetching role:", error);
            throw error;
        }
    },
    async saveRole(role: RoleDates) {
        try {
            console.log("datos: ", role);
            const response = await axios.post("/modulo/role", role);
            return response.data;
        } catch (error) {
            console.error("Error saving role:", error);
            throw error;
        }
    },
    async updateRole(role: RoleDates) {
        try {
            const response = await axios.put(`/modulo/role/${role.id}`, role);
            return response.data;
        } catch (error) {
            console.error("Error updating role:", error);
            throw error;
        }
    },
    async deleteRole(id: number) {
        try {
            const response = await axios.delete(`/modulo/role/${id}`);
            return response.data;
        } catch (error) {
            console.error("Error deleting role:", error);
            throw error;
        }
    },
};
