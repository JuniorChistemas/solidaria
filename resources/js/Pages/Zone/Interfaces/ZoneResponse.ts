import { Zone } from "./Zone";

export { Zone };
// pagination interface already exists in the general interfaces
export interface Pagination {
    total: number;
    current_page: number;
    per_page: number;
    last_page: number;
    from: number;
    to: number;
}

// you use this interface?
export interface ZoneResponse {
    data: Zone[];
    pagination: Pagination;
}
