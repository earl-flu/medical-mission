import './bootstrap';
import '../css/app.css';
import '@fortawesome/fontawesome-free/css/all.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import { createPinia } from 'pinia';
import VueApexCharts from 'vue3-apexcharts';

// Import Font Awesome core and components
import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { fas } from '@fortawesome/free-solid-svg-icons'; // Import specific icon packs or icons
import { fab } from '@fortawesome/free-brands-svg-icons'; // Optional: Brand icons

// Add icons to the library (add as many as you need)
library.add(fas, fab);

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(createPinia())
            .use(VueApexCharts)
            .component('font-awesome-icon', FontAwesomeIcon) // Register FontAwesomeIcon globally
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
