import axios from "axios";
import { Laboratory, LaboratoryResponse } from "@/Pages/Laboratory/Interfaces/LaboratoryResponse";

// Base API URL
const API_URL = "/laboratory";

export const getLaboratories = async (page: number = 1, name: string = ""): Promise<LaboratoryResponse> => {
    const response = await axios.get(`${API_URL}/list?page=${page}&name=${name}`);
    return response.data;
};

export const createLaboratory = async (laboratoryData: Omit<Laboratory, "id" | "created_at" | "updated_at">): Promise<Laboratory> => {
    const response = await axios.post(`${API_URL}/add`, laboratoryData);
    return response.data;
};

export const updateLaboratory = async (laboratoryId: number, laboratoryData: Partial<Omit<Laboratory, "id" | "created_at" | "updated_at">>): Promise<Laboratory> => {
    const response = await axios.put(`${API_URL}/update/${laboratoryId}`, laboratoryData);
    return response.data;
};

export const deleteLaboratory = async (laboratoryId: number): Promise<void> => {
    await axios.delete(`${API_URL}/delete/${laboratoryId}`);
};