import { Zone } from "./Zone";

export { Zone }; 
export interface Pagination {
    total: number;
    current_page: number;
    per_page: number;
    last_page: number;
    from: number;
    to: number;
}

export interface ZoneResponse {
    data: Zone[]; 
    pagination: Pagination;
}