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
                <td>{{itin.day}}</td>
                <td>{{itin.port_name}}</td>
                <td></td>
                <td></td>
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
                columns : ['Day', 'Port', 'Arrival', 'Departure'],
                itins : [],
            };
        },

        methods : {
            read(sailing_id = 1)
            {
                return  window.axios.get('/api/itinerary/get', {
                    params: {
                        sailing_id: sailing_id,
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
