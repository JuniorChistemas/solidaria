<template>
    <aside
        class="aside"
        :class="[
            'text-primary-900 w-64 transition-all duration-300 mb-2 rounded-r-lg shadow hover:shadow-lg',
            {
                'ml-0': AsideStore.isAsideVisible,
                '-ml-64': !AsideStore.isAsideVisible,
            },
            ThemeStore.isDarkMode ? 'dark:bg-slate-900' : 'text-primary-900',
        ]"
    >
        <nav class="p-4">
            <ul>
                <li
                    v-for="(item, index) in menuItems"
                    :key="item.label"
                    class="mb-2"
                >
                    <!-- Menu with submenus -->
                    <template v-if="item.submenu">
                        <div
                            @click="toggleSubmenu(index)"
                            :class="[
                                'flex items-center justify-between p-2 rounded-lg cursor-pointer transition-colors',
                                'dark:hover:bg-primary-700 hover:bg-primary-200',
                            ]"
                        >
                            <div class="flex items-center gap-3">
                                <i
                                    :class="[
                                        item.icon,
                                        'text-lg text-primary-700 text-sky-700',
                                    ]"
                                ></i>
                                <span
                                    class="transition-opacity duration-300 text-sky-700"
                                >
                                    {{ item.label }}
                                </span>
                            </div>
                            <i
                                :class="[
                                    'pi',
                                    openMenus[index]
                                        ? 'pi-chevron-down'
                                        : 'pi-chevron-right',
                                    'text-sky-700 dark:text-primary-300',
                                ]"
                            ></i>
                        </div>
                        <!-- Submenú -->
                        <ul
                            v-show="openMenus[index]"
                            class="ml-6 mt-2 space-y-2 transition-all duration-300"
                        >
                            <li
                                v-for="subItem in item.submenu"
                                :key="subItem.label"
                            >
                                <NavLink
                                    :href="route(subItem.route)"
                                    :active="isActive(subItem.route)"
                                    :class="[
                                        'flex items-center p-2 rounded-lg transition-colors',
                                        'dark:hover:bg-primary-700 hover:bg-primary-200',
                                    ]"
                                >
                                    <div class="flex items-center gap-3">
                                        <i
                                            :class="[
                                                subItem.icon,
                                                'text-lg text-primary-700 dark:text-primary-300',
                                            ]"
                                        ></i>
                                        <span
                                            class="transition-opacity duration-300"
                                        >
                                            {{ subItem.label }}
                                        </span>
                                    </div>
                                </NavLink>
                            </li>
                        </ul>
                    </template>

                    <!-- Menu without submenus -->
                    <NavLink
                        v-else
                        :href="route(item.route)"
                        :active="isActive(item.route)"
                        :class="[
                            'flex items-center p-2 rounded-lg transition-colors',
                            'dark:hover:bg-primary-700 hover:bg-primary-200',
                        ]"
                    >
                        <div class="flex items-center gap-3">
                            <i
                                :class="[
                                    item.icon,
                                    'text-lg text-primary-700 dark:text-primary-300',
                                ]"
                            ></i>
                            <span class="transition-opacity duration-300">
                                {{ item.label }}
                            </span>
                        </div>
                    </NavLink>
                </li>
            </ul>
        </nav>
    </aside>
</template>

<script setup>
import { ref } from "vue";
import NavLink from "@/Components/NavLink.vue";
import { useAsideStore, useThemeStore } from "@/Stores/DashboardStore";

const AsideStore = useAsideStore();
const ThemeStore = useThemeStore();

// Static menu data
const menuItems = [
    { label: "Inicio", route: "dashboard", icon: "pi pi-home" },
    {
        label: "Usuarios",
        icon: "pi pi-users",
        submenu: [
            { label: "Perfil", route: "profile.show", icon: "pi pi-user" },
            { label: "Seguridad", route: "login", icon: "pi pi-shield" },
            {
                label: "Configuración",
                route: "profile.show",
                icon: "pi pi-cog",
            },
        ],
    },
    {
        label: "Médico",
        icon: "pi pi-heart",
        submenu: [
            { label: "Registro", route: "profile.show", icon: "pi pi-plus" },
            { label: "Doctores", route: "doctor.index", icon: "pi pi-user" },
            { label: "Consultas", route: "dashboard", icon: "pi pi-calendar" },
            { label: "Pacientes", route: "dashboard", icon: "pi pi-users" },
        ],
    },
    { label: "Notas", route: "dashboard", icon: "pi pi-pencil" },
    { label: "Trabajos", route: "profile.show", icon: "pi pi-briefcase" },
    { label: "Reportes", route: "dashboard", icon: "pi pi-chart-bar" },
    { label: "Zonas", route: "zone.index", icon: "pi pi-map" },
    { label: "Busquedas", route: "search", icon: "pi pi-search" },
];

// Reactive status for submenus only
const openMenus = ref({});

const toggleSubmenu = (index) => {
    openMenus.value[index] = !openMenus.value[index];
};

const isActive = (routeName) => {
    return route().current(routeName);
};
</script>

<style scoped>
.tooltip {
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease, visibility 0.3s ease;
}

.menu-link:hover .tooltip {
    opacity: 1;
    visibility: visible;
}
</style>
