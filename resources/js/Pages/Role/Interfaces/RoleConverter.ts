import { Role } from "./Role";
import { RoleDTO } from "./RoleDTO";

export const toRole = (roleDTO: RoleDTO): Role => {
    return {
        id: roleDTO.id,
        name: roleDTO.name,
        state: roleDTO.state,
        created_at: new Date(roleDTO.created_at),
        updated_at: new Date(roleDTO.updated_at),
    };
};

export const toRoleDTO = ({
    created_at,
    updated_at,
    ...role
}: Role): Omit<RoleDTO, "created_at" | "updated_at"> => {
    return {
        ...role,
    };
};
