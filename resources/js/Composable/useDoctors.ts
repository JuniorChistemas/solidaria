import { Pagination } from "@/Interfaces/Pagination";
import { Doctor } from "@/Pages/Doctor/Interfaces/Doctor";
import {
    toDoctor,
    toDoctorDTO,
} from "@/Pages/Doctor/Interfaces/DoctorConverter";
import { DoctorDTO } from "@/Pages/Doctor/Interfaces/DoctorDTO";
import { DoctorResponse } from "@/Pages/Doctor/Interfaces/DoctorResponse";
import { DoctorServices } from "@/Services/DoctorServices";
import { useToastUtil } from "@/Utils/Message";
import axios from "axios";
import { onMounted, reactive } from "vue";

export const useDoctors = () => {
    const { showInfo, showError } = useToastUtil();
    const father = reactive({
        doctorsDate: [] as DoctorDTO[],
        pagination: {} as Pagination,
        loadingTable: false as boolean,
        filter: "" as string,
        idDoctor: 0 as number,
        statusModal: {
            register: false as boolean,
            delete: false as boolean,
        },
        doctorData: {} as Doctor,
    });
    const loadingDoctors = async (page: number = 1, name: string = "") => {
        father.loadingTable = true;
        try {
            const data = await DoctorServices.getDoctors(page, name);
            father.doctorsDate = data.data;
            father.pagination = data.pagination;
        } catch (error) {
            console.error("Error fetching doctors:", error);
        } finally {
            father.loadingTable = false;
        }
    };
    const getDoctor = async (id: number) => {
        if (id === 0) {
            father.doctorData = {
                id: 0,
                name: "",
                code: "",
                start_date: null,
            } as Doctor;
            return;
        }
        try {
            const response: DoctorResponse = await DoctorServices.getDoctorId(
                id
            );
            father.doctorData = toDoctor(response.data);
        } catch (error) {
            console.error("Error fetching doctor:", error);
        }
    };

    // save or edit doctor
    const saveDoctor = async (doctor: Doctor) => {
        father.loadingTable = true;
        try {
            // we convert to discount
            const doctorDTO = toDoctorDTO(doctor);
            // const for response
            const response =
                doctorDTO.id === 0
                    ? await DoctorServices.saveDoctor(doctorDTO)
                    : await DoctorServices.updateDoctor(doctorDTO);
            if (response.success) {
                showInfo(response.message);
                loadingDoctors(father.pagination.current_page, father.filter);
                father.statusModal.register = false;
            } else {
                const errors = response.errors || {
                    general: response.message || "Error al guardar el doctor",
                };
                Object.entries(errors).forEach(([field, message]) => {
                    showError(`${field}: ${message}`);
                });
            }
        } catch (error) {
            showError(
                error.response.data.errors || "Error al guardar el doctor"
            );
        } finally {
            father.loadingTable = false;
        }
    };
    const deleteDoctor = async (doctor: number) => {
        father.loadingTable = true;
        try {
            const response = await DoctorServices.deleteDoctor(doctor);
            if (response.success) {
                showInfo(response.message);
                loadingDoctors(father.pagination.current_page, father.filter);
                father.statusModal.delete = false;
            }
        } catch (error) {
            console.error("Error deleting doctor:", error);
            showError("Error al eliminar");
        } finally {
            father.loadingTable = false;
        }
    };
    const loadingPage = (page: number) => {
        loadingDoctors(page, father.filter);
    };
    const searchDoctor = (name: string) => {
        father.filter = name;
        loadingDoctors(1, name);
    };
    const emitIdDoctorRegister = async (id: number) => {
        father.idDoctor = id || 0;
        await getDoctor(father.idDoctor);
        father.statusModal.register = true;
    };
    const emitIdDoctorDelete = async (id: number) => { 
        father.statusModal.delete = true;
        father.idDoctor = id;
        await getDoctor(father.idDoctor); 

    };
    const closeModalAll = (type: "register" | "delete") => {
        father.statusModal[type] = false;
        father.idDoctor = 0;
        father.doctorData = {} as Doctor;
    };
    const refreshDoctors = () => {
        loadingDoctors(father.pagination.current_page, father.filter);
    };
    onMounted(() => {
        loadingDoctors();
    });

    return {
        father,
        loadingPage,
        searchDoctor,
        emitIdDoctorRegister,
        emitIdDoctorDelete,
        closeModalAll,
        refreshDoctors,
        saveDoctor,
        deleteDoctor,
    };
};
