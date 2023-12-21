<script setup lang="ts" xmlns="http://www.w3.org/1999/html">
import {Head} from '@inertiajs/vue3';
import { ref } from 'vue'
import ApplicationMap from '@/Components/ApplicationMap.vue';

export type LatLng = {
    id: number;
    lat: number;
    lng: number;
}

const isMapClickable = ref("yes")

const props = defineProps<{
    markers: LatLng[];
}>();
</script>

<template>
    <Head title="Map Markers On Laravel"/>

    <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen">
        <div class="fixed w-60 z-10 left-0 bottom-0 h-14 bg-gray-700 rounded-tr-md flex px-4 py-2">
            <div class="flex h-6 items-center">
                <input
                    id="toggle"
                    aria-describedby="toggle-description"
                    name="toggle"
                    type="checkbox"
                    true-value="yes"
                    false-value="no"
                    v-model="isMapClickable"
                    class="h-4 w-4 rounded border-gray-300 text-yellow-600 focus:ring-yellow-600"
                />
            </div>
            <div class="ml-3 text-sm leading-6">
                <label for="toggle" class="font-medium text-gray-200">Click to add Markers</label>
                <p id="toggle-description" class="text-gray-400 text-xs">clickable: {{isMapClickable}}</p>
            </div>
        </div>

        <ApplicationMap :markers="props.markers" :is-map-clickable="isMapClickable"/>
    </div>
</template>
