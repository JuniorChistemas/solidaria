import { Supplier } from "./Supplier";
import { SupplierDTO } from "./SupplierDTO";


export const toSupplier = (supplierDTO: SupplierDTO): Supplier => {
    return {
        id: supplierDTO.id,
        name: supplierDTO.name,
        ruc: supplierDTO.ruc,
        phone: supplierDTO.phone,
        address: supplierDTO.address,
        state: supplierDTO.state,
    };
};

export const toSupplierDTO = (supplier: Supplier): SupplierDTO => {
    return {
        id: supplier.id,
        name: supplier.name,
        ruc: supplier.ruc,
        phone: supplier.phone,
        address: supplier.address,
        state: supplier.state,
    };
};
