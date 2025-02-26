import { DoctorDTO } from "./DoctorDTO";

export interface DoctorResponse {
    success: boolean;
    data: DoctorDTO;
    message: string;
}
