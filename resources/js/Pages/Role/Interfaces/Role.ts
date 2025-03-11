export interface Role {
    id: number;
    name: string;
    state: boolean;
    created_at: Date;
    updated_at: Date;
}

export type RoleDates = Omit<Role, "created_at" | "updated_at">;
