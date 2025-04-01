<script>
import axios from 'axios';
export default {
  name: "TableComponent",
  data() {
    return {

    }
  },
  props: {
    columns: Array,
    data: Array,
  },
  computed: {
    etiquetasCampos() {
      return {
        nombreCampoBaseDatos: "Label a mostrar en vista",
      };
    },
  },
  methods: {
    infoShow() {
      // Lógica del botón
    },
  }
};
</script>

<template>
  <div class="table-container">

    <!--  Tabla de los registros -->
    <table>
      <thead>
      <tr>
        <th v-for="(col, index) in columns" :key="index">
          {{ col.label }}
        </th>
        <th>dato1</th>
        <th>dato2</th>
        <th>dato3</th>
        <th></th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="(row, rowIndex) in data" :key="rowIndex">
        <td v-for="(col, colIndex) in columns" :key="colIndex">
          {{ row[col.key] }}
        </td>
        <td>register1</td>
        <td>register2</td>
        <td>register3</td>
        <td class="acciones">
          <button class="pi pi-eye"  title="Ver registro" @click="infoShow"></button>
        </td>
      </tr>
      <tr>
        <td v-for="(col, colIndex) in columns" :key="colIndex">
          {{ row[col.key] }}
        </td>
        <td>register1</td>
        <td>register2</td>
        <td>register3</td>
        <td class="acciones">
          <button class="pi pi-eye"  title="Ver registro" @click="infoShow"></button>
        </td>
      </tr>
      <tr>
        <td v-for="(col, colIndex) in columns" :key="colIndex">
          {{ row[col.key] }}
        </td>
        <td>register1</td>
        <td>register2</td>
        <td>register3</td>
        <td class="acciones">
          <button class="pi pi-eye"  title="Ver registro" @click="infoShow"></button>
        </td>
      </tr>
      <tr>
        <td v-for="(col, colIndex) in columns" :key="colIndex">
          {{ row[col.key] }}
        </td>
        <td>register1</td>
        <td>register2</td>
        <td>register3</td>
        <td class="acciones">
          <button class="pi pi-eye"  title="Ver registro" @click="infoShow"></button>
        </td>
      </tr>
      </tbody>
    </table>
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
