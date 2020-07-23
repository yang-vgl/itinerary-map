<template>

    <div id="map" class="map-container">

        <MglMap :accessToken="accessToken" :mapStyle="mapStyle"  :zoom = "zoom" @load="mapLoaded">

            <MglMarker v-for="(marker, i) in markers"  :coordinates.sync="marker.coordinates">
                <div  slot="marker" class="my-div-icon mapboxgl-marker mapboxgl-marker-anchor-center"
                      style="transform: translate(-50%, -50%) translate(515px, 440px);">
                    <span class="marker-wrap">{{i}}</span>
                </div>
            </MglMarker>

            <MglGeojsonLayer
                :sourceId="geoJsonLayer.id"
                layerId="route"
                :layer="geoJsonLayer"
            />
        </MglMap>
    </div>
</template>

<script>
    import Mapbox from "mapbox-gl";
    import { MglMap, MglGeojsonLayer, MglMarker,
    } from "vue-mapbox";

    export default {
        components: {
            MglMap,
            MglMarker,
            MglGeojsonLayer
        },

        data() {
            return {
                accessToken:
                    "pk.eyJ1IjoiY3J1aXNld2F0Y2giLCJhIjoiY2psbTU1cXA5MGJzdzNqcW1uMW8xdnhxOSJ9.XQXd9br5alZu0SsqgrOAGA",
                mapStyle: "mapbox://styles/cruisewatch/cjmgdmwxd4e662rpv1z8zcxvr",
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
                                "coordinates": [[30.0, 0.5], [10.0, 0.5],[40.0, 5.5]]
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
                center : [30.0, 0.5],
                zoom : 1,
                markers : []
            };
        },

        methods : {

            reload(sailing_id)
            {
                console.log(sailing_id);
                self = this;
                return  window.axios.get('/api/itinerary/get', {
                    params: {
                        sailing_id: sailing_id,
                    }
                }).then((response) => {
                    var coordinate = [];
                    self.markers = [];
                    Object.keys(response.data).forEach(function(key) {
                        if(response.data[key].gps) {
                            coordinate.push(response.data[key].gps);
                            self.markers.push( {coordinates :response.data[key].gps});
                        }
                    });

                    console.log(coordinate);
                    console.log(self.markers);
                    this.geoJsonLayer.source.data.geometry.coordinates = coordinate;

                    if(this.map.getLayer(this.geoJsonLayer.id)) {
                        this.map.removeLayer(this.geoJsonLayer.id);
                    }
                    if(this.map.getSource(this.geoJsonLayer.id)) {
                        this.map.removeSource(this.geoJsonLayer.id);
                    }
                    this.map.addLayer(this.geoJsonLayer);
                })
            },

            mapLoaded ({ map }) {
                this.map = map;
                this.reload(29006);
                console.log(map.get);
            },
        },

        created() {
            this.mapbox = Mapbox;
            self = this;
            this.$eventHub.$on('sailing-change', function(e){
                self.reload(e);
            });
        }
    };
</script>
