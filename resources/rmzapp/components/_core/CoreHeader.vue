<script setup lang="ts">

import * as rmzlib from '../../rmzlib.mts';
import TextField from '../TextField.vue';


let searchVal = '';
let doSearch = true;

const search = (e: any) => {
    searchVal = e.target.value;
    doSearch = true;
}

setInterval(() => {
    if (!doSearch) return;
    doSearch = false;

    rmzlib.api({
        path: '/api/v1/estates',
        method: 'get',
        query: {
            name: searchVal,
            soften: 1,
            limit: 50,
        },
    }).then((response) => {
        console.log(response);
    }).catch(rmzlib.err);
}, 300);

</script>

<template>
    <div class="CoreHeader">
        <div class="search">
            <TextField @input="search"></TextField>
            <div class="search_logo"><span>Roomz</span>&nbsp;Поиск</div>
        </div>
    </div>
</template>

<style scoped lang="scss">

@use '../../rmzlib';

.CoreHeader {
    @include rmzlib.block((o: h, gaps: 40px));
    width: 100%;

    .search {
        @include rmzlib.block;

        width: 100%;
        height: 60px;
        position: relative;
        border-radius: 3px;

        .TextField {
            width: 100%;
            height: 100%;
            padding: 0 34px;

            &:focus, &[data-empty="0"] {
                & + .search_logo {
                    display: none;
                }
            }
        }

        .search_logo {
            position: absolute;
            top: 50%;
            left: 34px;
            font-family: "Wix Madefor Display Variable", sans-serif;
            font-size: 26px;
            font-weight: 500;
            color: #7a8291;
            pointer-events: none;
            transform: translate(0, -50%);

            span {
                font-weight: 700;
            }
        }
    }
}

</style>
