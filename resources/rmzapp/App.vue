<script setup lang="ts">

</script>

<template>
    <RouterView></RouterView>
</template>

<style lang="scss">

@use 'rmzlib';

html, body {
    @include rmzlib.elem;
    width: 100%;
    height: 100%;
}

html {
    @include rmzlib.p-font;
}

body {
    margin: 0;
}

h1, h2, h3, h4, h5, h6, p {
    margin: 0;
}

h1, h2, h3 {
    font-family: "Wix Madefor Display Variable", sans-serif;
}

h1 {
    font-size: 62px;
    font-weight: 600;
}

h2 {
    font-size: 44px;
    font-weight: 500;
}

h3 {
    font-size: 36px;
    font-weight: 500;
}

</style>
