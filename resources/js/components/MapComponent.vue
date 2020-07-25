<template>

    <div id="map" class="map-container">

        <MglMap :accessToken="accessToken" :mapStyle="mapStyle"  :zoom = "zoom"  :center="center" @load="mapLoaded">

            <MglMarker v-for="(marker, i) in markers"  :coordinates.sync="marker.coordinates">
                <div  slot="marker" class="my-div-icon mapboxgl-marker mapboxgl-marker-anchor-center map-marker">
                    <span class="marker-wrap">{{i}}</span>
                </div>
                <MglPopup>
                    <div>{{marker.name}} - {{marker.coordinates}}</div>
                </MglPopup>
            </MglMarker>

            <MglGeojsonLayer
                :sourceId="geoJsonLayer.id"
                :layerId="geoJsonLayer.id"
                :layer="geoJsonLayer"
            />

        </MglMap>

    </div>
</template>

<script>
    import Mapbox from "mapbox-gl";
    import {
        MglMap, MglGeojsonLayer, MglMarker, MglPopup
    } from "vue-mapbox";

    export default {
        components: {
            MglMap,
            MglMarker,
            MglGeojsonLayer,
            MglPopup
        },

        data() {
            return {
                accessToken:
                    "pk.eyJ1IjoibWlrZWhhbWlsdG9uMDAiLCJhIjoiNDVjS2puUSJ9.aLvWM5BnllUGJ0e6nwMSEg",
                mapStyle: "mapbox://styles/mapbox/streets-v11",
                geoJsonLayer:  {
                    "id": "route",
                    "type": "line",
                    "source": {
                        "type": "geojson",
                        "data": {
                            "type": "Feature",
                            "properties": {},
                            "geometry": {
                                "type": "LineString",
                                "coordinates": []
                            }
                        }
                    },
                    "layout": {
                        "line-join": "round",
                        "line-cap": "round"
                    },
                    "paint": {
                        "line-color": "#3ea2f7",
                        "line-width": 2,
                        "line-dasharray": [1, 3]
                    }
                },
                //todo maxBounds not behaves very good
                //maxBounds :,
                center : [0, 0],
                zoom : 1,
                markers : []
            };
        },

        methods : {

            reload(itins)
            {
                console.log(itins);

                self = this;
                var coordinate = [];
                self.markers = [];
                self.maxBounds = [];
                Object.keys(itins).forEach(function(key) {
                    if(itins[key].lat && itins[key].lng) {
                        var cord = [itins[key].lng, itins[key].lat];
                        coordinate.push(cord);
                        self.markers.push({coordinates :cord, name : itins[key].location});
                        self.maxBounds.push(cord);
                    }
                });

                this.center = coordinate[0];
                this.zoom = 2;
                //this.map.fitBounds( this.map.getMaxBounds(), {padding: 65} );
                this.geoJsonLayer.source.data.geometry.coordinates = coordinate;

                //todo why isn't the template automatically re-rendered when geoJsonLayer is changed ?
                if(this.map.getLayer(this.geoJsonLayer.id)) {
                    this.map.removeLayer(this.geoJsonLayer.id);
                }
                if(this.map.getSource(this.geoJsonLayer.id)) {
                    this.map.removeSource(this.geoJsonLayer.id);
                }
                this.map.addLayer(this.geoJsonLayer);
            },

            mapLoaded ({ map }) {
                this.map = map;
                console.log(map.get);
            },
        },

        created() {
            this.mapbox = Mapbox;
            self = this;
            this.$eventHub.$on('get-coordinate', function(e){
                console.log('map');
                self.reload(e);
            });
        }
    };
</script>
