import { DoctorDTO } from "@/Pages/Doctor/Interfaces/DoctorDTO";
import axios from "axios";

export const DoctorServices = {
    async getDoctors(page: number, name: string = "") {
        try {
            const response = await axios.get("/modulo/doctors/list", {
                params: { page, name },
            });
            return response.data;
        } catch (error) {
            console.error("Error fetching doctors:", error);
            throw error;
        }
    },
    async getDoctorId(id: number) {
        try {
            const response = await axios.get(`/modulo/doctor/${id}`);
            return response.data;
        } catch (error) {
            console.error("Error fetching doctor:", error);
            throw error;
        }
    },
    async saveDoctor(doctor: DoctorDTO) {
        try {
            const response = await axios.post("/modulo/doctor", doctor);
            return response.data;
        } catch (error) {
            console.error("Error saving doctor hola:", error);
            throw error;
        }
    },
    async updateDoctor(doctor: DoctorDTO) {
        try {
            const response = await axios.put(
                `/modulo/doctor/${doctor.id}`,
                doctor
            );
            return response.data;
        } catch (error) {
            console.error("Error updating doctor:", error);
            throw error;
        }
    },
    async deleteDoctor(id: number) {
        try {
            const response = await axios.delete(`/modulo/doctor/${id}`);
            return response.data;
        } catch (error) {
            console.error("Error deleting doctor:", error);
            throw error;
        }
    },
};
