<template>

    <div id="map" class="map-container">

        <MglMap :accessToken="accessToken" :mapStyle="mapStyle"  :zoom = "zoom"  :center="center" @load="mapLoaded">

            <MglMarker v-for="(marker, i) in markers"  :coordinates.sync="marker.coordinates">
                <div  slot="marker" class="my-div-icon mapboxgl-marker mapboxgl-marker-anchor-center map-marker">
                    <span class="marker-wrap">{{i}}</span>
                </div>
                <MglPopup>
                        <div>{{marker.name}} - {{marker.country}}</div>
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

            reload(data)
            {
                self = this;
                return  window.axios.get('/api/itinerary/get', {
                    params: {
                        sailing_id: data.sailing_id,
                        source: data.source
                    }
                }).then((response) => {
                    var coordinate = [];
                    self.markers = [];
                    self.maxBounds = [];
                    Object.keys(response.data).forEach(function(key) {
                        if(response.data[key].gps) {
                            coordinate.push(response.data[key].gps);
                            self.markers.push({coordinates :response.data[key].gps, name : response.data[key].port_name, country : response.data[key].country});
                            self.maxBounds.push(response.data[key].gps);
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
                })
            },

            mapLoaded ({ map }) {
                this.map = map;
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
