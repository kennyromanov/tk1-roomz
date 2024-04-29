<script setup lang="ts">

const props = defineProps({
    to: String,
});

</script>

<template>
    <RouterLink class="CoreLink" :to="props.to"><slot></slot></RouterLink>
</template>

<style scoped lang="scss">

@use '../../rmzlib';

.CoreLink {
    color: unset;
    text-decoration: none;
}

</style>
