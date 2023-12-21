<template>
    <div>
        <GMapMap
            :center="center"
            :zoom="10"
            :click="true"
            @click="greet"
            map-type-id="terrain"
            style="width: 100vw; height: 100vh"
        >
            <GMapCluster :zoomOnClick="true">
                <GMapMarker
                    :key="index"
                    v-for="(m, index) in formatted_markers"
                    :position="m.position"
                    :clickable="true"
                    :draggable="true"
                    @click="center = m.position"
                />
            </GMapCluster>
        </GMapMap>
    </div>

</template>

<script setup lang="ts">
type LatLng = {
    id: number;
    lat: number;
    lng: number;
}

const {markers} = defineProps<{
    markers: LatLng[]
}>()

const formatted_markers = markers.map((mark) => {
    return {
        id: mark.id,
        position: {
            lat: Number.parseFloat(mark.lat, 10),
            lng: Number.parseFloat(mark.lng, 10)
        }
    }
})

console.log(markers)
console.log(formatted_markers)

const  center = { lat: 51.093048, lng: 6.84212 }

const greet = async (event) =>  {
    await axios.post('/markers', {
        latitude: event.latLng.lat().toPrecision(8),
        longitude: event.latLng.lng().toPrecision(8)
    });
}
</script>

<style>
body {
    margin: 0;
}
</style>
