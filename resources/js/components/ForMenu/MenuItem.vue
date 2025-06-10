<template>
    <li :class="{ 'layout-menuitem-category': !item.to && item.label }">
        <template v-if="!item.to && item.label">
            <div class="layout-menuitem-root-text" v-if="!root">{{ item.label }}</div>
        </template>
        <template v-else>
            <router-link v-if="item.to" :to="item.to" custom v-slot="{ href, navigate, isActive, isExactActive }">
                <a :href="href" @click="navigate" :class="{ 'active-route': item.exact ? isExactActive : isActive }">
                    <i :class="item.icon"></i>
                    <span>{{ item.label }}</span>
                    <i v-if="item.items" :class="['pi pi-fw', item.expanded ? 'pi-angle-down' : 'pi-angle-right']"></i>
                </a>
            </router-link>
            <a v-else @click="onMenuItemClick($event, item)" :class="{ 'active-route': isCurrentRouteActive(item) }">
                <i :class="item.icon"></i>
                <span>{{ item.label }}</span>
                <i v-if="item.items" :class="['pi pi-fw', item.expanded ? 'pi-angle-down' : 'pi-angle-right']"></i>
            </a>

            <Transition v-if="item.items && item.visible !== false" name="layout-submenu-wrapper">
                <ul v-show="root ? true : item.expanded" class="layout-submenu">
                    <menu-item v-for="(child, i) in item.items" :key="child.label + i" :item="child" :index="i"></menu-item>
                </ul>
            </Transition>
        </template>
    </li>
</template>

<script setup>
import { ref, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';

const route = useRoute();
const router = useRouter();

const props = defineProps({
    item: Object,
    index: Number,
    root: {
        type: Boolean,
        default: false
    }
});

const emit = defineEmits(['menuitem-click']);

// Mantén esta función solo si tienes elementos de menú que NO son router-links
// pero que necesitan resaltar su estado activo basado en la URL.
// Si todos tus elementos de menú que navegan usan `item.to` y, por lo tanto, `router-link`,
// entonces esta función y el `v-else` en la plantilla de arriba pueden ser eliminados.
const isCurrentRouteActive = (menuItem) => {
    if (!menuItem.to) return false;
    try {
        const resolvedRoute = router.resolve(menuItem.to);
        // Para que esta función sea más precisa, podríamos comparar el nombre de la ruta,
        // o usar `isExactActive` en lugar de `startsWith` si es un caso de "home" que no debe coincidir con subrutas.
        // Pero para el problema actual, el foco es el `router-link` y sus propiedades.
        return route.path.startsWith(resolvedRoute.path);
    } catch (e) {
        console.warn('Error resolviendo ruta en MenuItem (isCurrentRouteActive):', menuItem.to, e);
        return false;
    }
};

const onMenuItemClick = (event, item) => {
    if (item.command) {
        item.command(event);
    }
    if (item.items) {
        item.expanded = !item.expanded;
    }
    emit('menuitem-click', { originalEvent: event, item: item });
};

watch(() => route.path, (newPath, oldPath) => {
    // Depuración si es necesario.
});

</script>

<style scoped>
/* Tus estilos existentes para MenuItem.vue */
li {
    list-style: none;
    margin: 0;
    padding: 0;
}

a {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 20px;
    color: var(--text-color, #333);
    text-decoration: none;
    font-weight: 500;
    transition: background-color 0.2s, color 0.2s;
    border-radius: var(--border-radius);
}

a i {
    font-size: 1.2rem;
}

a:hover {
    background-color: var(--hover-bg-color, #e0e0e0);
    color: var(--hover-text-color, #000);
}

.active-route {
    background-color: var(--active-menu-bg-color, var(--main-color));
    color: var(--active-menu-text-color, #fff);
    font-weight: bold;
    border-left: 5px solid var(--accent-color, #007bff);
}

.layout-submenu {
    list-style: none;
    padding: 0;
    margin-left: 20px;
}

.layout-submenu-wrapper-enter-active,
.layout-submenu-wrapper-leave-active {
    transition: all 0.3s ease-in-out;
    max-height: 500px;
    overflow: hidden;
}
.layout-submenu-wrapper-enter-from,
.layout-submenu-wrapper-leave-to {
    max-height: 0;
    opacity: 0;
}
</style>
