<script setup lang="ts">

const props = defineProps<{ name: string }>()
</script>

<template>
    <h1>hello {{name}}</h1>
</template>
