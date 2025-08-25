<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Peta Cawangan</title>
    <meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no">
    <link href="https://api.mapbox.com/mapbox-gl-js/v3.0.1/mapbox-gl.css" rel="stylesheet">
    <script src="https://api.mapbox.com/mapbox-gl-js/v3.0.1/mapbox-gl.js"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        #map {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 100%;
        }

        .mapboxgl-popup {
            max-width: 600px;
        }

        .mapboxgl-popup-close-button {
            display: none;
        }

        .pagination {
            display: flex;
            gap: 8px;
            justify-content: center;
            margin-top: 10px;
            font-size: 14px;
        }

        .pagination span {
            cursor: pointer;
        }

        .pagination .active {
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div id="map"></div>

    <input id="mapData" type="hidden" value="{{ json_encode($mapData) }}">

    <script>
        mapboxgl.accessToken =
            'pk.eyJ1IjoicmlkZXJ1bm5lcm15IiwiYSI6ImNrOHptdGloeTE3NXIzc213aXEybDRkY2UifQ.5a1AaVjCXWW36GJ9TLjLKg';

        const map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v12',
            center: [115.9849559, 5.7384564], // Sabah center
            zoom: 7
        });

        const mapData = JSON.parse(document.getElementById("mapData").value);

        // Fungsi untuk generate isi popup dengan pagination
        function generatePopupContent(item, page = 1, perPage = 5) {
            const totalCompanies = item.companies.length;
            const totalPages = Math.ceil(totalCompanies / perPage);
            const start = (page - 1) * perPage;
            const end = start + perPage;
            const companiesToShow = item.companies.slice(start, end);

            let companyList = "";
            companiesToShow.forEach(c => {
                companyList += `<div>( ${c.kod_cawangan ?? '-'} ) ${c.company_name}</div>`;
            });

            // Pagination HTML
            let paginationHtml = `<div class="pagination">`;
            for (let i = 1; i <= totalPages; i++) {
                paginationHtml +=
                    `<span class="${i === page ? 'active' : ''}" onclick="changePage('${item.city_id}', ${i})">${i}</span>`;
            }
            if (page < totalPages) {
                paginationHtml += `<span onclick="changePage('${item.city_id}', ${page + 1})">>></span>`;
            }
            paginationHtml += `</div>`;

            return `
                <div id="popup-content-${item.city_id}" style="padding:15px; font-family: Arial, sans-serif;">
                    <h3 style="margin:0 0 5px 0; font-size:18px; font-weight:bold;">
                        USIA BAHAGIAN ${item.city_name.toUpperCase()}
                    </h3>
                    <p style="margin:0 0 10px 0; font-size:14px;">Senarai Cawangan</p>
                    ${companyList}
                    ${paginationHtml}
                </div>
            `;
        }

        // Simpan semua popup supaya bisa diupdate ketika ganti halaman
        const popups = {};

        // Buat markers untuk setiap lokasi
        mapData.forEach(item => {
            if (!item.latitude || !item.longitude) return;

            const popup = new mapboxgl.Popup({
                    offset: 20,
                    maxWidth: "600px"
                })
                .setHTML(generatePopupContent(item, 1)); // default page 1

            popups[item.city_id] = {
                popup,
                item
            };

            new mapboxgl.Marker({
                    color: "#E96F51"
                })
                .setLngLat([item.longitude, item.latitude])
                .setPopup(popup)
                .addTo(map);
        });

        // Fungsi global untuk ganti halaman di popup
        window.changePage = function(cityId, page) {
            const {
                popup,
                item
            } = popups[cityId];
            popup.setHTML(generatePopupContent(item, page));
        };

        // Fit map bounds to show all markers
        if (mapData.length > 0) {
            const coordinates = mapData
                .filter(item => item.latitude && item.longitude)
                .map(item => [item.longitude, item.latitude]);

            if (coordinates.length > 0) {
                const bounds = coordinates.reduce((bounds, coord) => {
                    return bounds.extend(coord);
                }, new mapboxgl.LngLatBounds(coordinates[0], coordinates[0]));

                map.fitBounds(bounds, {
                    padding: 100,
                    maxZoom: 8
                });
            }
        } else {
            map.setZoom(6);
        }
    </script>
</body>

</html>
