import axios from "axios";
import { Laboratory, LaboratoryResponse } from "@/Pages/Laboratory/Interfaces/LaboratoryResponse";

// Base API URL
const API_URL = "/modulo/laboratory";

export const getLaboratories = async (page = 1, name = "") => {
    // Corregido para usar la ruta correcta
    const response = await axios.get(`/modulo/laboratories/list`, {
        params: { page, name }
    });
    return response.data;
};

export const createLaboratory = async (laboratoryData) => {
    // Corregido para usar la ruta correcta
    const response = await axios.post(API_URL, laboratoryData);
    return response.data;
};

export const updateLaboratory = async (laboratoryId, laboratoryData) => {
    // Corregido para usar la ruta correcta
    const response = await axios.put(`${API_URL}/${laboratoryId}`, laboratoryData);
    return response.data;
};

export const deleteLaboratory = async (laboratoryId) => {
    // Corregido para usar la ruta correcta
    await axios.delete(`${API_URL}/${laboratoryId}`);
};