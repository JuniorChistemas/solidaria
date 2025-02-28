import axios from "axios";
import { Zone, ZoneResponse } from "@/Pages/Zone/Interfaces/ZoneResponse";
const API_URL = "/modulo/zone";

export const getZones = async (page: number = 1, name: string = ""): Promise<ZoneResponse> => {
    const response = await axios.get<ZoneResponse>(`${API_URL}/list?page=${page}&name=${name}`);
    return response.data;
};
export const createZone = async (zoneData: Omit<Zone, "id" | "created_at" | "updated_at">): Promise<Zone> => {
    const response = await axios.post<Zone>(API_URL, zoneData); // ✅ Usar POST /modulo/zone
    return response.data;
};

export const updateZone = async (zoneId: number, zoneData: { name: string }): Promise<Zone> => {
    console.log("Actualizando zona con ID:", zoneId, "Datos:", zoneData); // ✅ Verifica en consola
    const response = await axios.put(`${API_URL}/${zoneId}`, zoneData);
    return response.data;
};
export const deleteZone = async (zoneId: number): Promise<void> => {
    await axios.delete(`${API_URL}/${zoneId}`); // ✅ DELETE /modulo/zone/{id}
};
