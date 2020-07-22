<template>

    <div id="itins" class="itins-container">

    <table>
        
    </table>
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
                                "coordinates": [[30.0, 0.5], [10.0, 0.5],[100.0, 45.5]]
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
                zoom : 1
            };
        },
        created() {
            this.mapbox = Mapbox;

            this.markers = [
                {coordinates :[30.0, 0.5]},
                {coordinates :[10.0, 0.5]},
                {coordinates :[100.0, 45.5]},
            ];

            var el = document.createElement('div' );
            var markerName = 1;
            var currentPositionClass = '';
            markerName = '1/' + markerName;
            el.innerHTML = '<span class="marker-wrap">' + markerName + '</span>';
            console.log(el);
            this.el1 = el;
        }
    };
</script>
