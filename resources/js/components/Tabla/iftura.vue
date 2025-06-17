<script>
export default {
  name: 'ProductSearch',
  props: {
    visible: Boolean,
    clienteId: Number,
  },
  data() {
    return {
      producto: [],
      resultadosBusqueda: [],
      searchTerm: '',
    };
  },
  computed: {
    productosMostrados() {
      return this.searchTerm.length > 0 ? this.resultadosBusqueda : this.producto;
    },
    entityType() {
      const routeName = this.$route.name;
      if (routeName === "Clientes - Persona natural") return "natural-person";
      if (routeName === "Clientes - Empresa - Administrador") return "company";
      if (routeName === "Clientes - Persona Natural - Soporte TI") return "natural-person-support";
      if (routeName === "Administrador - Tickets") return "admintickets";
      return "company";
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
    async buscarProductos() {
      if (this.searchTerm.length === 0) return;

      try {
        const response = await axios.get(`${this.apiBaseUrl}/buscar`, {
          params: { query: this.searchTerm },
        });
        this.resultadosBusqueda = response.data;
      } catch (error) {
        console.error('Error en la búsqueda:', error);
      }
    },
    async cargarProductos() {
      try {
        const response = await axios.get(this.apiBaseUrl);
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
