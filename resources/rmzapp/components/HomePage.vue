<script setup lang="ts">

import {Ref, ref} from 'vue';
import * as rmzlib from '../rmzlib.mjs';
import CorePage from './_core/CorePage.vue';
import EstateRow from './EstateRow.vue';
import CoreHeader from "./_core/CoreHeader.vue";


const estates: Ref<any[]> = ref([]);

rmzlib.Events.on('search', async (data) => estates.value = data.Estates);

</script>

<template>
    <CorePage class="HomePage">
        <template #header>
            <CoreHeader></CoreHeader>
        </template>

        <div class="estate_rows">
            <EstateRow v-for="estate of estates"
                class="estate_row"
                :link="'/estate/'+estate.id"
                :descr="estate.descr"
                :picture="`/uploads/${estate.picture_filename}.jpg`"
                :price="estate.price"
                :priceCurrency="estate.price_currency"
                :address="`${estate.address_city}, ул. ${estate.address_street}, ${estate.address_house}, ${estate.address_apartment} кв./офис`"
                :area="estate.num_area"
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
