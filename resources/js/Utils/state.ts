const colorTag = (state: number): string => {
    return state === 1 ? "success" : "danger";
};

const textTag = (state: number): string => {
    return state === 1 ? "Activo" : "Inactivo";
};

export { colorTag, textTag };
