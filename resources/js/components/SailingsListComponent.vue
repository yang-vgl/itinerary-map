<template>
    <div id="sailings-list" class="sailings-container">
        internal:
        <select name="internal_sailings" @change="onChange($event)" class="form-control">
            <option value="" selected="selected" >Please Select</option>
            <option v-for="(sailing, index) in internal_sailings" :key="index" :value="sailing.id" :data-name="sailing.name" :data-departure="sailing.departure" :data-arrival="sailing.arrival">
                {{sailing.id}} - {{sailing.name}}
            </option>
        </select>

        external:
        <select name="external_sailings" @change="onChange($event)" class="form-control">
            <option v-for="(sailing, index) in external_sailings"
                    :key="index" :value="sailing.id"  :data-name="sailing.name" :data-source="sailing.source" :data-departure="sailing.departure" :data-arrival="sailing.arrival">
                {{sailing.id}} - {{sailing.source}} -  {{sailing.name}}
            </option>
        </select>

        <h4>{{selected_sailing}} </h4>
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
                selected_sailing : ''
            };
        },

        methods : {
            read()
            {
                return  window.axios.get('/api/sailings/get', {
                    params: {
                    }
                }).then((response) => {
                    this.internal_sailings = response.data.internal_sailings;
                    this.external_sailings = response.data.external_sailings;
                    console.log(response.data);
                })
            },

            onChange:function(event){
                if(event.target.options.selectedIndex > -1) {
                    var selected =  event.target.options[event.target.options.selectedIndex];
                    this.selected_sailing = selected.dataset.name+ selected.dataset.departure+ selected.dataset.arrival;
                    this.$eventHub.$emit('sailing-change', {'sailing_id':selected.value, 'source' :  selected.dataset.source});
                }
            },
        },

        created() {
            this.read();
        }
    };
</script>
