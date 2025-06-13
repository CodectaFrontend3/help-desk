<template>
  <div class="button-group">
    <button
        v-for="(button, index) in buttons"
        :key="index"
        @click="handleButtonClick(button.value)"
    >
      {{ button.label }}
    </button>
  </div>
</template>

<script>
export default {
  name: 'ButtonGroup',
  props: {
    // Recibe un arreglo de objetos con las propiedades `label` y `value`
    buttons: {
      type: Array,
      required: true
    }
  },
  methods: {
    handleButtonClick(view) {
      this.$emit('updateView', view);
    }
  }
};
</script>

<style scoped>
.button-group {
  display: flex;
  justify-content: space-between;
  gap: 30px;
  margin-top: 15px;
  margin-left: 15px;
  margin-right: 15px;
}
.button-group button {
  flex: 1;
  background-color: #ffcb87;
  color: rgb(46, 46, 46);
  padding: 8px 10px;
  border-radius: 5px;
  border: none;
  cursor: pointer;
  font-size: 13px;
}
.button-group button:hover {
  background-color: #ffb049;
}
</style>
