import { ref } from "vue";

export function useAside() {
    const isAsideVisible = ref(true);

    const toggleAside = () => {
        isAsideVisible.value = !isAsideVisible.value;
    };

    return {
        isAsideVisible,
        toggleAside,
    };
}
