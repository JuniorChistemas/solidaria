import { Category } from "./Category";

export { Category }; 
export interface Pagination {
    total: number;
    current_page: number;
    per_page: number;
    last_page: number;
    from: number;
    to: number;
}

export interface CategoryResponse {
    data: Category[]; 
    pagination: Pagination;
}
