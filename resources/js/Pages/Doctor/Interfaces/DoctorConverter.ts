import { Doctor } from "./Doctor";
import { DoctorDTO } from "./DoctorDTO";

export const toDoctor = (doctorDTO: DoctorDTO): Doctor => {
    return {
        id: doctorDTO.id,
        code: doctorDTO.code,
        name: doctorDTO.name,
        start_date: new Date(doctorDTO.start_date),
        state: doctorDTO.state,
    };
};

export const toDoctorDTO = (doctor: Doctor): DoctorDTO => {
    return {
        id: doctor.id,
        code: doctor.code,
        name: doctor.name,
        start_date: doctor.start_date.toISOString(),
        state: doctor.state,

    };
};
