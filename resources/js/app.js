require('./bootstrap');

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import Submenu from '@/Components/Submenu';
import Permissions from "./mixins/Permissions";
import Utilities from "./mixins/Utilities";
import Statscards from "./Components/Statscards";

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .mixin({ methods: { route } })
            .component('Datepicker', Datepicker)
            .component('Submenu', Submenu)
            .component('Statscards', Statscards)
            .mixin(Permissions)
            .mixin(Utilities)
            .mount(el);
    },
});

InertiaProgress.init({
    color: '#4B5563',
    // Whether to include the default NProgress styles.
    includeCSS: true,

    // Whether the NProgress spinner will be shown.
    showSpinner: true,
});
