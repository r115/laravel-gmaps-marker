import './bootstrap';
import '../css/app.css';

import {createApp, h, DefineComponent} from 'vue';
import {createInertiaApp} from '@inertiajs/vue3';
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers';
import {ZiggyVue} from '../../vendor/tightenco/ziggy/dist/vue.m';
import VueGoogleMaps from '@fawmi/vue-google-maps'

const appName = import.meta.env.VITE_APP_NAME || 'Google Map Markers';
const googleMapsLicenseKey = import.meta.env.VITE_GOOGLE_MAPS_LICENSE_KEY;

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob<DefineComponent>('./Pages/**/*.vue')),
    setup({el, App, props, plugin}) {
        createApp({render: () => h(App, props)})
            .use(plugin)
            .use(VueGoogleMaps, {
                load: {
                    key: googleMapsLicenseKey,
                },
            })
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
