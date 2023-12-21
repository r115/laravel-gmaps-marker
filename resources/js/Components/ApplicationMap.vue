<template>
    <div>
        <div>Map hererer</div>
        <GMapMap
            :center="center"
            :zoom="10"
            :click="true"
            @click="greet"
            map-type-id="terrain"
            style="width: 100vw; height: 20rem"
        >
            <GMapCluster :zoomOnClick="true" @click="greet">
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

<script setup>
const  center = { lat: 51.093048, lng: 6.84212 }

const  markers = [
    {
        position: {
            lat: 51.093048,
            lng: 6.84212,
        },
    },
    {
        position: {
            lat: 51.198429,
            lng: 6.69529,
        },
    },
    {
        position: {
            lat: 51.165218,
            lng: 7.067116,
        },
    },
    {
        position: {
            lat: 51.09256,
            lng: 6.84074,
        },
    },
]

const greet = (event) =>  {
    console.log(event)
    console.log(event.latLng.lat())
    console.log(event.latLng.lng())
}
</script>

<style>
body {
    margin: 0;
}
</style>
