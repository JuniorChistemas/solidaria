export interface Laboratory {
    id: number;
    name: string;
    state:boolean;
    created_at: string;
    updated_at: string;
}

export type LaboratoryDates = Omit<Laboratory, "created_at" | "updated_at">;