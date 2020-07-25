<template>
    <div id="sailings-list" class="sailings-container">
        Locations:
        <input type="text" @input="getLocations($event)" class="form-control" placeholder="Locations seperated with ," v-model="locations">
        <button v-on:click="getCoordinate">Confirm</button>

        <nav>
            <router-link to="/itinerary">Show Itinerary</router-link>
            <router-link to="/map">Show Map</router-link>
        </nav>

    </div>

</template>

<script>
    import {
    } from "vue-mapbox";

    export default {

        components: {
        },
        data() {
            return {
                locations:""
            };
        },

        methods : {
            getLocations(event){
                this.locations=event.target.value;
            },

            getCoordinate(event){
                this.$eventHub.$emit('locations-submit', this.locations);
            },
        },

        created() {
            this.read();
        }
    };
</script>
