<template>
  <div class="form-group">
    <label class="subtitulo">{{ label }}</label>
    <input type="text" :placeholder="placeholder" />
  </div>
</template>

<script>
export default {
  name: 'FormGroup',
  props: {
    label: String,
    placeholder: String,
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
.form-group input {
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
>