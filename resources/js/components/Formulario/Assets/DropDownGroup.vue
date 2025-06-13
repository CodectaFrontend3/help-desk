<template>
  <div class="form-group">
    <label class="subtitulo">{{ label }}</label>
    <select :placeholder="placeholder" v-model="selectedValue">
      <option v-for="(option, index) in options" :key="index" :value="option">
        {{ option }}
      </option>
    </select>
  </div>
</template>

<script>
export default {
  name: 'DropdownGroup',
  props: {
    label: String,
    placeholder: String,
    options: {
      type: Array,
      required: true,
    },
  },
  data() {
    return {
      selectedValue: null,  // Almacenará la opción seleccionada
    };
  },
};
</script>

<style scoped>
.form-group {
  display: flex;
  flex-direction: column;
  gap: 10px;
  margin-top: 10px;
  font-size: 20px;
}
.form-group label {
  font-weight: bold;
}
.form-group select {
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 5px;
  width: 95%;
  margin-left: 15px;
  margin-right: 15px;
  margin-bottom: 15px;
  font-size: 12px;
}
</style>
