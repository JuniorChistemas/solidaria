import { Laboratory } from "./Laboratory";

export { Laboratory }; 

export interface Pagination {
    total: number;
    current_page: number;
    per_page: number;
    last_page: number;
    from: number;
    to: number;
}

export interface LaboratoryResponse {
    data: Laboratory[]; 
    pagination: Pagination;
}
