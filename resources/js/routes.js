
import Home from './components/ItinsComponent.vue';
import Register from './components/MapComponent.vue';
import Map from './components/MapComponent.vue';

import Action from './components/MapComponent.vue';

const routes = [
    { path: '/', component: Map },
    { path: '/map', component: Map },
    { path: '/action', component: Action },
];

export default routes;
