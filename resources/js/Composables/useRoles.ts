import { Pagination } from "@/Interfaces/Pagination";
import { Role } from "@/Pages/Role/Interfaces/Role";
import { toRoleDTO } from "@/Pages/Role/Interfaces/RoleConverter";
import { RoleDTO } from "@/Pages/Role/Interfaces/RoleDTO";
import { RoleServices } from "@/Services/RoleService";
import { useToastUtil } from "@/Utils/Message";
import { onMounted, reactive } from "vue";

export const useRoles = () => {
    const { showInfo, showError } = useToastUtil();
    const father = reactive({
        rolesData: [] as RoleDTO[],
        pagination: {} as Pagination,
        loadingTable: false as boolean,
        filter: "" as string,
        idRole: 0 as number,
        statusModal: {
            register: false as boolean,
            delete: false as boolean,
        },
        roleData: {} as Role,
    });

    const loadingRoles = async (page: number = 1, name: string = "") => {
        father.loadingTable = true;
        try {
            const data = await RoleServices.getRoles(page, name);
            father.rolesData = data.data;
            father.pagination = data.pagination;
        } catch (error) {
            console.error("Error fetching roles:", error);
        } finally {
            father.loadingTable = false;
        }
    };

    const getRole = async (id: number) => {
        if (id === 0) {
            father.roleData = {
                id: 0,
                name: "",
                state: false,
                created_at: null,
                updated_at: null,
            } as Role;
            return;
        }
        try {
            const response = await RoleServices.getRoleId(id);
            father.roleData = response.data;
        } catch (error) {
            console.error("Error fetching role:", error);
        }
    };
    const saveRole = async (role: Role) => {
        father.loadingTable = true;
        try {
            const roleDTO = toRoleDTO(role);
            console.log(roleDTO);
            const response =
                roleDTO.id === 0
                    ? await RoleServices.saveRole(roleDTO)
                    : await RoleServices.updateRole(roleDTO);
            if (response.success) {
                showInfo(response.message);
                loadingRoles(father.pagination.current_page, father.filter);
                father.statusModal.register = false;
            } else {
                const errors = response.errors || {
                    general: response.message || "Error saving role2",
                };
                showError(errors.general);
            }
        } catch (error) {
            showError("Error saving role3");
        } finally {
            father.loadingTable = false;
        }
    };
    const deleteRole = async (role: number) => {
        father.loadingTable = true;
        try {
            const response = await RoleServices.deleteRole(role);
            if (response.success) {
                showInfo(response.message);
                loadingRoles(father.pagination.current_page, father.filter);
                father.statusModal.delete = false;
            }
        } catch (error) {
            console.error("Error deleting role:", error);
        } finally {
            father.loadingTable = false;
        }
    };
    const loandingPage = (Page: number) => {
        loadingRoles(Page, father.filter);
    };
    const searchRole = (name: string) => {
        father.filter = name;
        loadingRoles(1, name);
    };
    const emitIdRoleRegister = async (id: number) => {
        father.idRole = id || 0;
        await getRole(father.idRole);
        father.statusModal.register = true;
    };
    const emitIdRoleDelete = async (id: number) => {
        father.idRole = id;
        father.statusModal.delete = true;
        await getRole(father.idRole);
    };
    const closeModalAll = (type: "register" | "delete") => {
        father.statusModal[type] = false;
        father.idRole = 0;
        father.roleData = {} as Role;
    };
    const refreshRoles = () => {
        loadingRoles(father.pagination.current_page, father.filter);
    };

    onMounted(() => {
        loadingRoles();
    });
    return {
        father,
        loandingPage,
        searchRole,
        emitIdRoleDelete,
        emitIdRoleRegister,
        closeModalAll,
        refreshRoles,
        saveRole,
        deleteRole,
    };
};
