import { ref } from "vue";

export function useTheme() {
    const isDarkMode = ref(false);

    const toggleDarkMode = () => {
        isDarkMode.value = !isDarkMode.value;
        document.documentElement.classList.toggle("dark", isDarkMode.value);
    };

    return {
        isDarkMode,
        toggleDarkMode,
    };
}
