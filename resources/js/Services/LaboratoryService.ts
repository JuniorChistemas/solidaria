import axios from "axios";
import { LaboratoryDates,Laboratory } from "@/Pages/Laboratory/Interfaces/Laboratory";
import { LaboratoryResponse } from "@/Pages/Laboratory/Interfaces/LaboratoryResponse";

const API_URL = '/modulo/laboratory';


export const LaboratoryServices = {
  async getLaboratories(page: number, name: string = "") {
    try {
      const response = await axios.get("/modulo/laboratories/list", {
        params: { page, name },
      });
      return response.data as LaboratoryResponse;
    } catch (error) {
      console.error("Error fetching laboratories:", error);
      throw error;
    }
  },

  async getLaboratoryById(id: number) {
    try {
      const response = await axios.get(`${API_URL}/${id}`);
      return response.data as Laboratory;
    } catch (error) {
      console.error("Error fetching laboratory:", error);
      throw error;
    }
  },

  async saveLaboratory(laboratory: LaboratoryDates) {
    try {
      console.log("datos:", laboratory);
      const response = await axios.post(`${API_URL}`, laboratory);
      return response.data as Laboratory;
    } catch (error) {
      console.error("Error saving laboratory:", error);
      throw error;
    }
  },

  async updateLaboratory(laboratory: LaboratoryDates) {
    try {
      const response = await axios.put(`${API_URL}/${laboratory.id}`, laboratory);
      return response.data as Laboratory;
    } catch (error) {
      console.error("Error updating laboratory:", error);
      throw error;
    }
  },

  async deleteLaboratory(id: number) {
    try {
      const response = await axios.delete(`${API_URL}/${id}`);
      return response.data;
    } catch (error) {
      console.error("Error deleting laboratory:", error);
      throw error;
    }
  },
};
