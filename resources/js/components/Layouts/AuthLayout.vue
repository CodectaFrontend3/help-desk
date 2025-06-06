<template>
    <router-view />
</template>

<script setup>
import { computed } from 'vue'

const currentYear = computed(() => new Date().getFullYear())
</script>
