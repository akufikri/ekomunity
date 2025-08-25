<style>
    #map {
      position: absolute;
      top: 0;
      bottom: 0;
      width: 100%;
    }
  </style>
  
  <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v1.10.0/mapbox-gl.js'></script>
  <!--<script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.2.0/mapbox-gl-geocoder.min.js'></script>-->
  <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v1.10.0/mapbox-gl.css' rel='stylesheet' />
  <!--<link rel='stylesheet' href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.2.0/mapbox-gl-geocoder.css' type='text/css' />-->
  
  
  <script src="https://api.mapbox.com/mapbox-gl-js/v1.10.0/mapbox-gl.js"></script>
  <link href="https://api.mapbox.com/mapbox-gl-js/v1.10.0/mapbox-gl.css" rel="stylesheet" />
  <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.5.1/mapbox-gl-geocoder.min.js"></script>
  <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.5.1/mapbox-gl-geocoder.css" type="text/css" />
  <!-- Promise polyfill script required to use Mapbox GL Geocoder in IE 11 -->
  <script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.auto.min.js"></script>
  
  <div class="modal fade" tabindex="-1" id="selectLoaction" role="dialog" aria-labelledby="selectLoaction">
      <div class="modal-dialog modal-lg">
          <div class="modal-content" style="height:90vh">
              <div class="modal-body" style="padding:0px !important">
                  <div id='map'></div>
              </div>
          </div>
      </div>
  </div>
  
  <script>
  
  function loadMap(){
      var access_token = "pk.eyJ1IjoicmlkZXJ1bm5lcm15IiwiYSI6ImNrOHptdGloeTE3NXIzc213aXEybDRkY2UifQ.5a1AaVjCXWW36GJ9TLjLKg";
      // var start_lat = 3.892900617512808;
      // var start_lng = 114.8585287805206;
      // var end_lat = 7.3687280150057575;
      // var end_lng = 119.50981313567524;
      
      // https://docs.mapbox.com/playground/static/
      
      // var start_lat = 1.0912;
      // var start_lng = 100.7801;
      // var end_lat = 7.2438;
      // var end_lng = 119.2959;
      
      var start_lat = 0.8017;
      var start_lng = 99.6755;
      var end_lat = 7.3557;
      var end_lng = 119.3984;
  
      $('#selectLoaction').modal('show');
      
      mapboxgl.accessToken = access_token;
      var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v10',
        center: [109.537, 4.0854],
      //   center: [110.038, 4.1735],
      //   center: [116.796783, 5.420404],
        zoom: 3
      });
      //malay
      // var bounds = [[100.085756871, 0.773131415201], [119.181903925, 6.92805288332]];
      //sabah
      var bounds = [[start_lng, start_lat], [end_lng, end_lat]]
      map.setMaxBounds(bounds);
      var canvas = map.getCanvasContainer();
      
      var start = [100.085756871, 0.773131415201];
      
      var geocoder = new MapboxGeocoder({
          accessToken: mapboxgl.accessToken,
          countries: 'my',
          marker: false,
          // bbox: [100.085, 0.773, 119.181, 6.928],
          bbox: [start_lng, start_lat, end_lng, end_lat],
          mapboxgl: mapboxgl
      });
      
      map.on('load', function() {
          map.resize();
          map.on('click', function(e) {
              setMarker(canvas, map, 'CLICK' , e);
          });
          geocoder.on('result', function(e) {
              var coor = e.result.geometry.coordinates;
              var lnglat = {
                  lng: coor[0],
                  lat: coor[1],
              }

              setMarker(canvas, map, 'SEARCH', lnglat);
          });
      });
  
      map.addControl(geocoder);
      
      map.addControl(new mapboxgl.NavigationControl());
      
      function setMarker(canvas,map, type ,coordsObj){

            if(type === "CLICK"){
                var coordsObj = coordsObj.lngLat;
            }else{
                var coordsObj = coordsObj;
            }
            canvas.style.cursor = '';
            var coords = Object.keys(coordsObj).map(function(key) {
              return coordsObj[key];
            });
            input_lng = $('.place-longitude');
            input_lat = $('.place-latitude');
            input_lng.val(coords[0]);
            input_lat.val(coords[1]);
            var end = {
              type: 'FeatureCollection',
              features: [{
                type: 'Feature',
                properties: {},
                geometry: {
                  type: 'Point',
                  coordinates: coords
                }
              }
              ]
            };
            if (map.getLayer('end')) {
              map.getSource('end').setData(end);
            } else {
              map.addLayer({
                id: 'end',
                type: 'circle',
                source: {
                  type: 'geojson',
                  data: {
                    type: 'FeatureCollection',
                    features: [{
                      type: 'Feature',
                      properties: {},
                      geometry: {
                        type: 'Point',
                        coordinates: coords
                      }
                    }]
                  }
                },
                paint: {
                  'circle-radius': 10,
                  'circle-color': '#288fff'
                }
              });
            }
      }
  }
  </script>