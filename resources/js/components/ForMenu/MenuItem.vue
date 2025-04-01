<script setup>
import { ref, onBeforeMount, watch } from 'vue';
import { useRoute } from 'vue-router';
import { useLayout } from "./layout.js";

const route = useRoute();
const { layoutState, setActiveMenuItem, onMenuToggle } = useLayout();

const props = defineProps({
  item: {
    type: Object,
    default: () => ({}),
  },
  index: {
    type: Number,
    default: 0,
  },
  root: {
    type: Boolean,
    default: true,
  },
  parentItemKey: {
    type: String,
    default: null,
  },
});

const isActiveMenu = ref(false);
const itemKey = ref(null);

onBeforeMount(() => {
  itemKey.value = props.parentItemKey ? `${props.parentItemKey}-${props.index}` : String(props.index);
  const activeItem = layoutState.activeMenuItem;
  isActiveMenu.value = activeItem === itemKey.value || activeItem?.startsWith(`${itemKey.value}-`);
});

watch(
    () => layoutState.activeMenuItem,
    (newVal) => {
      isActiveMenu.value = newVal === itemKey.value || newVal?.startsWith(`${itemKey.value}-`);
    }
);

function itemClick(event, item) {
  if (item.disabled) {
    event.preventDefault();
    return;
  }

  if ((item.to || item.url) && (layoutState.staticMenuMobileActive || layoutState.overlayMenuActive)) {
    onMenuToggle();
  }

  if (item.command) {
    item.command({ originalEvent: event, item });
  }

  const foundItemKey = item.items ? (isActiveMenu.value ? props.parentItemKey : itemKey) : itemKey.value;
  setActiveMenuItem(foundItemKey);
}

function checkActiveRoute(item) {

  console.log("Ruta actual: " + item.to)

  return route.path === item.to;

}
</script>

<template>
  <li :class="{ 'layout-root-menuitem': root, 'active-menuitem': isActiveMenu }">
    <!-- Si el item tiene una propiedad 'to', usamos router-link -->
    <router-link
        v-if="item.to && !item.items && item.visible !== false"
        @click="itemClick($event, item, index)"
        :class="[item.class, { 'active-route': checkActiveRoute(item) }]"
        tabindex="0"
        :to="item.to"
        class="menu-item"
    >
      <i :class="item.icon" class="layout-menuitem-icon" v-if="item.icon"/>
      <img :src="item.svg" class="layout-menuitem-icon" v-if="item.svg" alt="" style="width: 1rem; height: 1rem"/>
      <span class="layout-menuitem-text">{{ item.label }}</span>
    </router-link>

    <!-- Si el item tiene una propiedad 'url', usamos <a> para enlaces externos -->
    <a
        v-else-if="item.url && !item.items && item.visible !== false"
        :href="item.url"
        @click="itemClick($event, item, index)"
        :class="item.class"
        :target="item.target"
        tabindex="0"
        class="menu-item"
    >
      <i :class="item.icon" class="layout-menuitem-icon"></i>
      <span class="layout-menuitem-text">{{ item.label }}</span>
    </a>
  </li>
</template>


<style scoped>
/* Aplicar la fuente Poppins */
body, .menu-item, .layout-menuitem-text {
  font-family: 'Poppins', sans-serif;
}

/* Estilo de la raíz del menú */
.layout-root-menuitem {
  font-weight: 600;
  color: black;
}

/* Estilo del texto del menú */
.layout-menuitem-text {
  font-size: 1rem;
  font-weight: 400;
}

.menu-item {
  display: flex;
  align-items: center;
  padding: 15px 20px;
  background-color: #fbfbfb;
  transition: background-color 0.3s ease, color 0.3s ease;
  color: #001839;
  cursor: pointer;
  text-decoration: none;  /* Evitar el subrayado en los enlaces */
}
/* Evitar subrayado en los router-link y <a> */
.menu-item:hover, .menu-item:focus, .menu-item:active {
  text-decoration: none;
}
/* Estilo de hover: Fondo amarillo y texto sin cambiar */
.menu-item:hover {
  color: rgb(182, 182, 182);
  transform: scale(1);
  transition: transform 0.3s ease, color 0.3s ease;
}
/* Estilo del icono en los items del menú */
.menu-item .layout-menuitem-icon {
  margin-right: 10px;
  font-size: 1.5rem;
  transition: color 0.3s ease;  /* Transición suave para el cambio de color */
}

/* Cuando el menú está en hover, el icono cambia de color */
.menu-item:hover .layout-menuitem-icon {
  color: rgb(182, 182, 182); /* Ícono azul en hover */
  transform: scale(1.5); /* Aumentar el tamaño del ícono un 10% */
  transition: transform 0.3s ease, color 0.3s ease; /* Transición suave */
}


/* Estilo de un item activo (por la ruta activa) */
.menu-item.active-route {
  background-color: rgb(182, 182, 182);
  color: black;
}

.menu-item.active-route .layout-menuitem-icon {
  color: black;
}
</style>


