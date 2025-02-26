import { useToast } from "primevue/usetoast";

interface ToastOptions {
    severity?: "success" | "info" | "warn" | "error";
    summary?: string;
    detail: string;
    life?: number;
}

export const useToastUtil = () => {
    const toast = useToast();

    const showMessage = ({
        severity = "success",
        summary = "",
        detail,
        life = 3000,
    }: ToastOptions) => {
        toast.add({
            severity,
            summary,
            detail,
            life,
            group: "br",
        });
    };

    const showSuccess = (detail: string, summary: string = "Éxito") => {
        showMessage({ severity: "success", summary, detail });
    };

    const showError = (detail: string, summary: string = "Error") => {
        showMessage({ severity: "error", summary, detail });
    };

    const showInfo = (detail: string, summary: string = "Información") => {
        showMessage({ severity: "info", summary, detail });
    };

    const showWarn = (detail: string, summary: string = "Advertencia") => {
        showMessage({ severity: "warn", summary, detail });
    };

    return {
        showMessage,
        showSuccess,
        showError,
        showInfo,
        showWarn,
    };
};
