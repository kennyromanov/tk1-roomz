<script setup lang="ts">

import * as rmzlib from '../rmzlib.mjs';
import CoreLink from './_core/CoreLink.vue';
import {computed} from "vue";


const props = defineProps({
    link: {
        type: String,
        required: true
    },
    descr: {
        type: String,
        required: true
    },
    price: {
        type: Number,
        required: true
    },
    priceCurrency: {
        type: String,
        default: 'kzt',
        required: true
    },
    address: {
        type: String,
        required: true
    },
    area: {
        type: Number,
        required: true
    },
    rooms: {
        type: Number,
        required: true
    },
    floor: {
        type: Number,
        required: true
    },
    picture: {
        type: String,
    },
});

const currencies: rmzlib.JSON = {
    kzt: '₸',
    usd: '$',
}
let picture = computed(() => props.picture ? `/uploads/${props.picture}.jpg` : null);

</script>

<template>
    <CoreLink class="EstateRow" :to="props.link">
        <div class="inner">
            <div class="image">
                <img v-if="picture" :src="picture" alt="Estate picture">
            </div>

            <div class="info">
                <div class="info_price">{{ currencies[props.priceCurrency] ?? '?' }}&thinsp;{{ props.price }}</div>
                <div class="info_address">{{ props.address }}</div>
                <div class="info_other">{{ props.area }} м², {{ props.rooms }} комн., {{ props.floor }} этаж</div>
            </div>
        </div>

        <div class="descr">{{ props.descr }}</div>
    </CoreLink>
</template>

<style scoped lang="scss">

@use '../rmzlib';

.EstateRow {
    @include rmzlib.block((gaps: 40px));
    transition: transform 1s;

    &:hover {
        transform: scale(1.01);
    }

    .inner {
        @include rmzlib.block((o: h, gaps: 50px));

        .image {
            flex-shrink: 0;
            width: 250px;
            height: 250px;
            border: 0.5px solid rgba(black, 0.2);
            border-radius: 5px;
            overflow: hidden;
            background: #f6f6f7;

            img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
        }

        .info {
            @include rmzlib.block((gaps: auto));

            .info_price {
                @include rmzlib.h-font;
                font-size: 38px;
                font-weight: 600;
            }
        }
    }
}

</style>
