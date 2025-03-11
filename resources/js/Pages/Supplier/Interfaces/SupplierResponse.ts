import { SupplierDTO } from "./SupplierDTO";

export interface SupplierResponse {
    success: boolean;
    data: SupplierDTO;
    message: string;
}