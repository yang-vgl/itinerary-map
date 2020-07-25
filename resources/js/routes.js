import Map from './components/MapComponent.vue';
import Itinerary from './components/ItinsComponent.vue';

const routes = [
    { path: '/itinerary', component: Itinerary },
    { path: '/map', component: Map }
];

export default routes;
