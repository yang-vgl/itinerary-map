<template>
    <div id="sailings-list" class="sailings-container">

        <select name="LeaveType" @change="onChange($event)" class="form-control">
            <option v-for="(sailing, index) in sailings" :key="index" :value="sailing.id">
                {{sailing.name}}
            </option>
        </select>
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
                sailings : []
            };
        },

        methods : {
            read()
            {
                return  window.axios.get('/api/sailings/get', {
                    params: {
                    }
                }).then((response) => {
                    this.sailings = response.data;
                    console.log( this.sailings);
                })
            },

            onChange:function(event){
                if(event.target.options.selectedIndex > -1) {
                    var sailing_id = event.target.options[event.target.options.selectedIndex].value;
                    this.$eventHub.$emit('sailing-change', sailing_id);
                }
            }
        },

        created() {
            this.read();
        }
    };
</script>
