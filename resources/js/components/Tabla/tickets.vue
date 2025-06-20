<template>
  <div>
    <input
      v-model="searchTerm"
      @input="buscarProductos"
      placeholder="Buscar Personas..."
    />

    <table>
      <thead>
        <tr>
          <th>Id</th>
          <th>ID del equipo</th>
          <th>Tipo de incidente</th>
          <th>Nombre</th>
          <th>Empresa</th>
          <th>Área</th>
          <th>Sucursal</th>
          <th>Estado</th>
          <th>Fecha de registro</th>
          <th>ojito</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="producto in productosMostrados" :key="producto.id">
          <td>{{ producto.id }}</td>
          <td>{{ producto.machine_id }}</td>
          <td>{{ producto.incident_type }}</td>
          <td>{{ producto.client_name }}</td>
          <td>{{ producto.company }}</td>
          <td>{{ producto.area }}</td>
          <td>{{ producto.branch }}</td>
          <td>{{ producto.state }}</td>
          <td>{{ producto.registration_date }}</td>
          <td></td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from 'axios';


export default {
  name:'tickets',
  props: {
    visible: Boolean,
    clienteId: Number,
  },
  data() {
    return {
      producto: [],           // todos los productos
      resultadosBusqueda: [],  // resultados del filtro
      searchTerm: '',
    };
  },
  computed: {
    productosMostrados() {
      return this.searchTerm.length > 0 ? this.resultadosBusqueda : this.producto;
    },
  },
  methods: {
    async buscarProductos() {
      if (this.searchTerm.length === 0) return;

      try {
        const response = await axios.get('/api/tickets/buscar', {
          params: { query: this.searchTerm },
        });
        this.resultadosBusqueda = response.data;
      } catch (error) {
        console.error('Error en la búsqueda:', error);
      }
    },
    async cargarProductos() {
      try {
        const response = await axios.get('/api/tickets');
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

<style scoped>
.table-container {
    display: flex;
    flex-direction: column;
    width: 100%;
    overflow: hidden;
}

.selection-toolbar {
    background-color: #f8f9fa;
    padding: 12px 16px;
    border: 1px solid #dee2e6;
    border-radius: 8px 8px 0 0;
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}

.selection-info {
    font-weight: 500;
    color: #495057;
}

.btn-bulk-action {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 6px 12px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.btn-bulk-action:hover {
    background-color: #0056b3;
}

.table-wrapper {
    overflow-x: auto;
    overflow-y: hidden;
    width: 100%;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    background-color: white;
}

table {
    width: 100%;
    min-width: 800px; /* Ancho mínimo para evitar que se comprima demasiado */
    border-collapse: collapse;
    text-align: center;
    table-layout: auto; /* Cambiado de fixed a auto para mejor responsive */
    background-color: white;
}

thead {
    background-color: #f8f9fa;
    position: sticky;
    top: 0;
    z-index: 10;
}

thead th {
    background-color: #f8f9fa;
    font-weight: 600;
    color: #495057;
    border-bottom: 2px solid #dee2e6;
    white-space: nowrap; /* Evita que el texto del header se rompa */
}

/* Eliminar display: flex de las filas */
tr {
    display: table-row; /* Comportamiento normal de tabla */
}

td, th {
    padding: 12px 16px;
    border-bottom: 1px solid #dee2e6;
    text-overflow: ellipsis;
    overflow: hidden;
    vertical-align: middle;
    min-width: 100px; /* Ancho mínimo para cada celda */
}

/* Columnas específicas con anchos mínimos */
.checkbox-column {
    width: 50px;
    min-width: 50px;
    text-align: center;
}

.priority-column {
    width: 120px;
    min-width: 120px;
}

.acciones {
    width: 120px;
    min-width: 120px;
    white-space: nowrap;
}

tbody tr {
    transition: background-color 0.2s ease;
}

tbody tr:nth-child(odd) {
    background-color: #fff;
}

tbody tr:nth-child(even) {
    background-color: #f8f9fa;
}

tbody tr:hover {
    background-color: #e3f2fd;
}

.selected-row {
    background-color: #bbdefb !important;
}

/* Estilos para botones de acción */
button.pi {
    padding: 8px;
    border: none;
    border-radius: 4px;
    background-color: #f0f0f0;
    cursor: pointer;
    margin: 0 2px;
    font-size: 14px;
    min-width: 32px;
    height: 32px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

button.pi:hover {
    background-color: #e0e0e0;
    transform: translateY(-1px);
}

/* Estilos para badges de prioridad */
.priority-badge {
    display: inline-block;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    white-space: nowrap;
}

/* Estilos para checkboxes */
.checkbox-container {
    display: inline-block;
    position: relative;
    cursor: pointer;
}

.checkbox-container input[type="checkbox"] {
    width: 18px;
    height: 18px;
    cursor: pointer;
}

.checkmark {
    position: absolute;
    top: 0;
    left: 0;
    height: 18px;
    width: 18px;
    background-color: #eee;
    border-radius: 3px;
    pointer-events: none;
}

/* Paginador */
.paginator {
    position: sticky;
    bottom: 0;
    padding: 16px;
    background-color: #fff;
    border-top: 1px solid #dee2e6;
    z-index: 5;
}

/* Media queries para pantallas pequeñas */
@media (max-width: 768px) {
    .table-wrapper {
        border-radius: 0;
    }

    td, th {
        padding: 8px 12px;
        font-size: 14px;
        min-width: 80px;
    }

    .checkbox-column {
        width: 40px;
        min-width: 40px;
    }

    .priority-column {
        width: 100px;
        min-width: 100px;
    }

    .acciones {
        width: 100px;
        min-width: 100px;
    }

    button.pi {
        padding: 6px;
        margin: 0 1px;
        min-width: 28px;
        height: 28px;
        font-size: 12px;
    }

    .priority-badge {
        font-size: 10px;
        padding: 2px 6px;
    }

    .selection-toolbar {
        padding: 8px 12px;
        font-size: 14px;
    }

    .paginator {
        padding: 12px;
    }
}

@media (max-width: 480px) {
    table {
        min-width: 600px; /* Reducir el ancho mínimo en móviles muy pequeños */
    }

    td, th {
        padding: 6px 8px;
        font-size: 12px;
        min-width: 60px;
    }

    .checkbox-column {
        width: 35px;
        min-width: 35px;
    }

    .acciones {
        width: 80px;
        min-width: 80px;
    }

    button.pi {
        padding: 4px;
        min-width: 24px;
        height: 24px;
        font-size: 10px;
    }
    }
</style>
