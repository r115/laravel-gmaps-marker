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
                <GMapMarker
                    :key="index"
                    v-for="(m, index) in mergedMarkers()"
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
import type {LatLng} from '@/Pages/Welcome.vue'
const formatMapMarkers = (markers: LatLng[]) => {
    return markers.map((mark) => {
        return {
            id: mark.id,
            position: {
                lat: Number.parseFloat(mark.lat, 10),
                lng: Number.parseFloat(mark.lng, 10)
            }
        }
    })
}

const {markers, isMapClickable} = defineProps<{
    markers: LatLng[],
    isMapClickable: string
}>()

const _markers: LatLng[] = formatMapMarkers(markers)
let _new_markers: LatLng[] = []



const  center = { lat: 52.093048, lng: -1.84212 }

const addMarkerToMap = async (event) =>  {
    console.log(isMapClickable);

    if(isMapClickable === "yes") {
        await axios.post('/markers', {
            latitude: event.latLng.lat().toPrecision(8),
            longitude: event.latLng.lng().toPrecision(8)
        });

        const reloadedMarkers = await axios.get('/markers');

        console.log(reloadedMarkers.data)
        _new_markers=formatMapMarkers(reloadedMarkers.data.markers)

        console.log('markers', _markers)
        mergedMarkers()
    }
}

const mergedMarkers = () => {
    const mix = [..._new_markers,..._markers];

    console.log(mix)

        const unique = [
            ...new Map(mix.map((item) => [item["id"], item])).values(),
        ];

    console.log(unique)
    return unique
}

</script>
