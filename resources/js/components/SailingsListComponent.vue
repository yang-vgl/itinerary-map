<template>
    <div id="sailings-list" class="sailings-container">
        Locations:
        <input type="text" @input="getLocations($event)" class="form-control" placeholder="Locations seperated with ," v-model="locations">
        <button v-on:click="getCoordinate">Confirm</button>
        <p>email: {{locations}}</p>

        <nav>
            <router-link to="/">Go to Home</router-link>
            <router-link to="/itinerary">Show Itinerary</router-link>
            <router-link to="/action">Show Action</router-link>
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
                internal_sailings : [],
                external_sailings : [],
                selected_sailing : '',
                form:{email:""},
                locations:""
            };
        },

        methods : {
            getLocations(event){
                this.locations=event.target.value;
                console.log(this.locations);
            },

            getCoordinate(event){
                console.log( this.locations);
            },

            read()
            {
                /*
                window.axios.get('/api/sailings/get').then((response) => {
                    this.internal_sailings = response.data.internal_sailings;
                    this.external_sailings = response.data.external_sailings;
                })

                 */
            },

            onChange:function(event){
                if(event.target.options.selectedIndex > -1) {
                    var selected =  event.target.options[event.target.options.selectedIndex];
                    this.selected_sailing = selected.dataset.name+ ' Departure: '+selected.dataset.departure+ ' Arrival: '+selected.dataset.arrival;
                    this.$eventHub.$emit('sailing-change', {'sailing_id':selected.value, 'source' :  selected.dataset.source});
                }
            },
        },

        created() {
            this.read();
        }
    };
</script>
