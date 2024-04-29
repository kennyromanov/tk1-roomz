<script setup lang="ts">

import {ref} from 'vue';


const isEmpty = ref(1);

const check = (e: any) => {
    if (e.target.value === '') isEmpty.value = 1;
    else isEmpty.value = 0;
}

</script>

<template>
    <input type="text" class="TextField" @input="check" :data-empty="isEmpty">
</template>

<style scoped lang="scss">

@use '../rmzlib';

.TextField {
    @include rmzlib.p-font;

    appearance: none;
    -webkit-appearance: none;
    padding: 20px 30px;
    border: none;
    border-radius: 3px;
    outline: none;
    color: #000;
    background: #ececf1;
}

</style>
