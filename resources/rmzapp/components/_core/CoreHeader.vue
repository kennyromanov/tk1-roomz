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
            descr: searchVal,
            soften: 1,
            limit: 50,
        },
    }).then((response) => {
        rmzlib.Events.emit('search', response.data);
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
        height: 80px;
        position: relative;
        border-radius: 3px;

        .TextField {
            width: 100%;
            height: 100%;
            padding: 0 50px;
            font-size: 25px;
            font-weight: 500;

            &:hover {
                & + .search_logo {
                    transform: translate(0, calc(-50% - 2px));
                }
            }

            &:focus, &[data-empty="0"] {
                & + .search_logo {
                    display: none;
                }
            }
        }

        .search_logo {
            @include rmzlib.h-font;

            position: absolute;
            top: 50%;
            left: 50px;
            color: #7a8291;
            pointer-events: none;
            transform: translate(0, -50%);
            transition: transform 0.5s;

            span {
                font-weight: 700;
            }
        }
    }
}

</style>
