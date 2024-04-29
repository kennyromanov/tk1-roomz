<script setup lang="ts">

import * as rmzlib from '../../rmzlib.mts';
import TextField from '../TextField.vue';


let searchVal = '';
let pictureVal = 0;
let roomsVal = {min: null, max: null};
let areaVal = {min: null, max: null};
let doSearch = true;

const search = (e: any) => {
    searchVal = e.target.value;
    doSearch = true;
}

const picture = (e: any) => {
    pictureVal = Number(e.target.checked);
    doSearch = true;
}

const minRooms = (e: any) => {
    roomsVal.min = e.target.value || null;
    doSearch = true;
}

const maxRooms = (e: any) => {
    roomsVal.max = e.target.value || null;
    doSearch = true;
}

const minArea = (e: any) => {
    areaVal.min = e.target.value || null;
    doSearch = true;
}

const maxArea = (e: any) => {
    areaVal.max = e.target.value || null;
    doSearch = true;
}

setInterval(() => {
    if (!doSearch) return;
    doSearch = false;

    rmzlib.api({
        path: '/api/v1/estates',
        method: 'get',
        query: {
            search: searchVal,
            soften: 1,
            picture: pictureVal,
            minRooms: roomsVal.min,
            maxRooms: roomsVal.max,
            minArea: areaVal.min,
            maxArea: areaVal.max,
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

        <div class="filters">
            <div class="filter">
                <p><label for="filter_with_photo">С фото</label></p>
                <input type="checkbox" id="filter_with_photo" @change="picture">
            </div>

            <div class="filter">
                <p>Кол-во комнат</p>
                <TextField type="number" @change="minRooms" placeholder="От" min="0"></TextField>
                <TextField type="number" @change="maxRooms" placeholder="До" min="1"></TextField>
            </div>

            <div class="filter">
                <p>Размер м²</p>
                <TextField type="number" @change="minArea" placeholder="От" min="0"></TextField>
                <TextField type="number" @change="maxArea" placeholder="До" min="1"></TextField>
            </div>
        </div>
    </div>
</template>

<style scoped lang="scss">

@use '../../rmzlib';

.CoreHeader {
    @include rmzlib.block((gaps: 40px));
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

    .filters {
        @include rmzlib.block((o: h, gaps: 60px));

        .filter {
            @include rmzlib.block((o: h, gaps: 20px));

            align-items: center;

            p {
                flex-shrink: 0;
            }

            .TextField {
                width: 100px;
            }
        }
    }
}

</style>
