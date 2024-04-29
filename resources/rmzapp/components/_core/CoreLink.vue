<script setup lang="ts">

const props = defineProps({
    to: String,
});

</script>

<template>
    <RouterLink :to="props.to"><slot></slot></RouterLink>
</template>

<style scoped lang="scss">

@use '../../rmzlib';

</style>
