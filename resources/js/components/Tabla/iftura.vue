<script>
import axios from 'axios';
import company from '../Tabla/company.vue'
import person from '../Tabla/natural-person.vue'
import plan_admin from '../Tabla/plan-admin.vue'
import plan from '../Tabla/plan.vue'
import tickets_admin from '../Tabla/tickets-admin.vue'
import tickets from '../Tabla/tickets.vue'
export default {
  name: 'ProductSearch',
  props: {
    //visible: Boolean,
    //clienteId: Number,
    searchTerm: String,
    searchTermCompany: String, // <-- AÑADIDO
    searchTermRuc: String, //AÑADIDO(?
    productos: {
    type: Array,
    default: () => []
  },
  resultadosBusqueda: {
    type: Array,
    default: () => []
  }
  },
    components:{
      company,
      person,
      plan_admin,
      plan,
      tickets_admin,
      tickets,
  },
  data() {

  },
  computed: {
    productosMostrados() {
    if (this.resultadosBusqueda && this.resultadosBusqueda.length > 0) {
      return this.resultadosBusqueda;
    }
    return this.productos;
  },
    entityType() {
      const routeName = this.$route.name;
      if (routeName === "Clientes - Persona natural") return "natural-person";
      if (routeName === "Clientes - Empresa - Administrador") return "company";
      if (routeName === "Clientes - Persona Natural - Soporte TI") return "natural-person-support";
      if (routeName === "Administrador - Tickets") return "admintickets";
      return "company";
    },
    currentComponent() {
    const map = {
        "natural-person": "person",
        "company": "company",
        "natural-person-support": "person", // podrías usar el mismo
        "admintickets": "tickets_admin"
    };
    return map[this.entityType] || "company";
    },
    apiBaseUrl() {
      // Devuelve la ruta base de la API según el tipo de entidad
      const map = {
        "natural-person": "/api/natural-person",
        "company": "/api/company",
        "natural-person-support": "/api/natural-person/support",
        "admintickets": "/api/ticket"
      };
      return map[this.entityType] || "/api/company";
    }
  },
  methods: {

    async cargarProductos() {
      try {
        const response = await axios.get(this.apiBaseUrl);
        console.log('Productos recibidos:', response.data); // <--- Verifica esto
        this.producto = response.data;
      } catch (error) {
        console.error('Error al cargar productos:', error);
      }
    },
  },
  mounted() {
    this.cargarProductos();
  },
};
</script>
<template>
  <div>


    <component
      :is="currentComponent"
      :productos="productosMostrados"
    />
  </div>
</template>
