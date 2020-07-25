<template>
    <div id="itins" class="itins-container">

        <table class="itins-table">
            <thead>
            <tr>
                <th v-for="(column, index) in columns" :key="index"> {{column}}</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(itin, index) in itins" :key="index">
                <td>{{itin.location}}</td>
                <td>{{itin.country}}</td>
                <td>{{itin.lat}}</td>
                <td>{{itin.lng}}</td>
            </tr>
            </tbody>
        </table>

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
                columns : ['Location', 'Country', 'Latitude', 'Longitude'],
                itins : [],
            };
        },

        methods : {
            read(locations)
            {
                return  window.axios.get('/api/locations/get', {
                    params: {
                        locations: locations,
                    }
                }).then((response) => {
                    this.itins = response.data;
                })
            },
        },

        created() {

            this.read();

            var self = this;

            this.$eventHub.$on('sailing-change', function(e){
                self.read(e);
            });
        }
    };
</script>
