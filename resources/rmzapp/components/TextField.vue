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
    padding: 10px 20px;
    border: none;
    border-radius: 3px;
    outline: none;
    box-sizing: border-box;
    color: #000;
    background: #ececf1;
    transition: background 0.4s, box-shadow 0.5s;

    &:focus {
        background: white;
        box-shadow: 0 2px 100px rgba(black, 0.2);
    }
}

</style>
