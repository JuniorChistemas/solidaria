import axios from "axios";
import { Category, CategoryResponse } from "@/Pages/Category/Interfaces/CategoryResponse";
const API_URL = "/category";

export const getCategories = async (page: number = 1, name: string = ""): Promise<CategoryResponse> => {
    const response = await axios.get<CategoryResponse>(`${API_URL}/list?page=${page}&name=${name}`);
    return response.data;
};

export const createCategory = async (categoryData: Omit<Category, "id" | "created_at" | "updated_at">): Promise<Category> => {
    const response = await axios.post<Category>(`${API_URL}/add`, categoryData);
    return response.data;
};

export const updateCategory = async (categoryId: number, categoryData: Omit<Category, "id" | "created_at" | "updated_at">): Promise<Category> => {
    const response = await axios.put<Category>(`${API_URL}/update/${categoryId}`, categoryData);
    return response.data;
};

export const deleteCategory = async (categoryId: number): Promise<void> => {
    await axios.delete(`${API_URL}/delete/${categoryId}`);
};
