<script setup lang="ts">
// @ts-nocheck not enough time to figure out the map library types

import type {LatLng} from '@/Pages/Welcome.vue'
import {onMounted, ref, watch} from "vue";
import axios from "axios";

/**
 * Map library expects a specific structure.
 *
 * @param markers
 */
const formatMapMarkers = (markers: LatLng[]): object => {
    return markers.map((mark) => {
        return {
            id: mark.id,
            position: {
                lat: Number.parseFloat(mark.lat),
                lng: Number.parseFloat(mark.lng)
            }
        }
    })
}

const {isMapClickable} = defineProps<{
    isMapClickable: string
}>()

const isSubmitting = ref(false)
const markers = ref([])

const  center = { lat: 52.093048, lng: -1.84212 }

const addMarkerToMap = async (event) =>  {
    isSubmitting.value = true;

    if(isMapClickable === "yes") {
        await axios.post('/markers', {
            latitude: event.latLng.lat().toPrecision(8),
            longitude: event.latLng.lng().toPrecision(8)
        });
    }

    isSubmitting.value = false;
}
const fetchMarkers = async () => {
    const markersData = await axios.get('/markers');

    markers.value = formatMapMarkers(markersData.data.markers)
}

watch(isSubmitting,async () => {
   await fetchMarkers();
})

onMounted(async () => {
    await fetchMarkers();
})

</script>

<template>
    <div>
        <GMapMap
            :center="center"
            :zoom="10"
            @click="addMarkerToMap"
            map-type-id="terrain"
            style="width: 100vw; height: 100vh"
        >
            <GMapCluster :zoomOnClick="true">
                <!--@ts-ignore-->
                <GMapMarker
                    :key="index"
                    v-for="(m, index) in markers"
                    :position="m.position"
                    :clickable="true"
                    :draggable="true"
                    @click="center = m.position"
                />
            </GMapCluster>
        </GMapMap>
    </div>
</template>
