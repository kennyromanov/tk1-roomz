<script setup lang="ts">

import {Ref, ref} from 'vue';
import * as rmzlib from '../rmzlib.mjs';
import CorePage from './_core/CorePage.vue';
import EstateRow from './EstateRow.vue';
import CoreHeader from "./_core/CoreHeader.vue";


const estates: Ref<any[]> = ref([]);
let isReady = ref(false);

rmzlib.Events.on('search', async (data) => {
    estates.value = data.Estates;
    isReady.value = true;
});

</script>

<template>
    <CorePage class="HomePage">
        <template #header>
            <CoreHeader class="header" ></CoreHeader>
        </template>

        <div class="estate_rows">
            <p v-if="!isReady && estates.length === 0">Подождите...</p>
            <p v-if="isReady && estates.length === 0">Ничего не нашлось</p>

            <EstateRow v-for="estate of estates"
                class="estate_row"
                :link="'/estate/'+estate.id"
                :descr="estate.descr"
                :picture="estate.picture_filename"
                :price="estate.price"
                :priceCurrency="estate.price_currency"
                :address="`${estate.address_city}, ул. ${estate.address_street}, ${estate.address_house}, ${estate.address_apartment} кв./офис`"
                :area="estate.num_area"
                :rooms="estate.num_rooms_bedrooms + estate.num_rooms_livingrooms"
                :floor="estate.num_floor"
            ></EstateRow>
        </div>
    </CorePage>
</template>

<style scoped lang="scss">

@use '../rmzlib';

.HomePage {
    $vgap: 150px;
    $hgap: 100px;

    .header {
        z-index: 1;
    }

    .estate_rows {
        @include rmzlib.block((o: h));

        flex-wrap: wrap;
        margin-top: -1 * $vgap;
        margin-left: -1 * $hgap;

        > * {
            margin-top: $vgap;
            margin-left: $hgap;
        }

        .estate_row {
            width: calc(50% - #{$hgap});
        }
    }
}

</style>
