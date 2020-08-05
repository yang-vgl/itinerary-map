<template>
    <div id="sailings-list" class="sailings-container">
        Locations:
        <input type="text" @input="getLocations($event)" class="form-control"
               placeholder="Locations seperated with ',', e.g. Berlin,Dresden,Leipzig,München,Frankfurt"

               v-model="locations">
        <button v-on:click="getCoordinate">Confirm</button>
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
                locations:"Berlin,Dresden,Leipzig,München,Frankfurt"
            };
        },

        methods : {
            getLocations(event){
                this.locations=event.target.value;
            },

            getCoordinate(event){
                this.$eventHub.$emit('locations-submit', this.locations);
            },
        }
    };
</script>
