const colorTag = (state: boolean): string => {
    return state === true ? "success" : "danger";
};

const textTag = (state: boolean): string => {
    return state === true ? "Activo" : "Inactivo";
};

export { colorTag, textTag };
