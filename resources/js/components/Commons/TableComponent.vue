<script>
import apiServices from "../../services/ApiServices.js";

export default {
  name: "TableComponent",
  data() {
    return {
      microCompany: [],  // Datos de las microempresas
    };
  },
  props: {
    columns: Array,  // Prop de columnas, que contiene las cabeceras y las claves para las filas
  },
  async created() {
    await this.fetchMicroCompany();  // Llamada a la API cuando el componente se crea
  },
  methods: {
    infoShow() {
      // Lógica para el botón de ver detalles (si es necesario)
    },
    async fetchMicroCompany() {
      // Obtener los datos de microempresas desde la API
      this.microCompany = await apiServices.getMicroCompany();
      console.log(this.microCompany);  // Verifica los datos que se reciben
    },
  },
};
</script>

<template>
  <div class="table-container">

    <!--  Tabla de los registros -->
    <table>
      <thead>
      <tr>
        <!-- Mostrar las columnas dinámicamente -->
        <th v-for="(col, index) in columns" :key="index">
          {{ col.label }}  <!-- Mostrar el label de cada columna -->
        </th>
        <th></th>  <!-- Columna para la acción -->
      </tr>
      </thead>
      <tbody>
      <!-- Iterar sobre microCompany para mostrar los datos -->
      <tr v-for="(row, rowIndex) in microCompany" :key="rowIndex">
        <!-- Iterar sobre cada columna para mostrar los datos -->
        <td v-for="(col, colIndex) in columns" :key="colIndex">
          {{ row[col.key] }}  <!-- Mostrar el valor de cada columna del objeto de microCompany -->
        </td>
        <td class="acciones">
          <button class="pi pi-eye" title="Ver registro" @click="infoShow"></button>
        </td>
      </tr>
      </tbody>
    </table>

    <!-- Paginador -->
    <Paginator></Paginator>

  </div>
</template>

<style scoped>

  table {
    width: 100%;
    border-collapse: collapse;
    border-radius: 10px;
    overflow: hidden;
    text-align: center;
  }
  thead {
    background-color: #ccc;
  }
  tr {
    display: flex;
    align-items: center;
  }
  td, th {
    flex: 1;
    padding: 16px;
  }
  tbody tr:nth-child(odd) {
    background-color: #fff;
  }

  tbody tr:nth-child(even) {
    background-color: #eee;
  }

  .pagination {
    margin-top: 20px;
    text-align: center;
  }

  .pagination button {
    padding: 5px 10px;
    margin: 0 5px;
    cursor: pointer;
  }

  .pagination button:disabled {
    background-color: #ccc;
    cursor: not-allowed;
  }
</style>
