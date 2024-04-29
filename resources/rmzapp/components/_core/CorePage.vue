<script setup lang="ts">

import CoreHeader from './CoreHeader.vue';

</script>

<template>
    <div class="CorePage">
        <div class="header">
            <slot name="header">
                <CoreHeader></CoreHeader>
            </slot>
        </div>

        <div class="content">
            <slot name="default"></slot>
        </div>

        <div class="footer">
            <slot name="footer"></slot>
        </div>
    </div>
</template>

<style scoped lang="scss">

@use '../../rmzlib';

.CorePage {
    @include rmzlib.elem;

    width: 100%;
    padding: 40px 20px;

    .header, .content, .footer {
        @include rmzlib.elem;
        width: 100%;
    }

    .content, .footer {
        margin-top: 20px;
    }
}

</style>
