<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Marker Ahli</title>
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
    </style>
</head>

<body>
    <style>
        #marker {
            background-image: url('https://docs.mapbox.com/mapbox-gl-js/assets/washington-monument.jpg');
            background-size: cover;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
        }

        .mapboxgl-popup {
            max-width: 200px;
        }

        .mapboxgl-popup-close-button {
            display: none;
        }
    </style>
    <div id="map"></div>

    <input id="data" type="hidden" value="{{ $city }}">

    <script>
        mapboxgl.accessToken =
            'pk.eyJ1IjoicmlkZXJ1bm5lcm15IiwiYSI6ImNrOHptdGloeTE3NXIzc213aXEybDRkY2UifQ.5a1AaVjCXWW36GJ9TLjLKg';
        const map = new mapboxgl.Map({
            container: 'map',
            // Choose from Mapbox's core styles, or make your own style with Mapbox Studio
            // Sabah
            // lat 5.7384564
            // lng 115.9849559

            // Default
            // [12.550343, 55.665957],
            style: 'mapbox://styles/mapbox/streets-v12',
            center: [115.9849559, 5.7384564],
            zoom: 7
        });

        var data_city = JSON.parse(document.getElementById("data").value);

        data_city.forEach(myFunction)

        function myFunction(item, index, arr) {
            //   arr[index] = item * 10;

            // var popupContent = `
        //     <div style="font-size:14px; line-height:1.5;">
        //         <strong>${item.city}</strong><br>
        //         <b>Total Ahli:</b> ${item.total_ahli}<br>
        //         <b>Latitude:</b> ${item.latitude || '-'}<br>
        //         <b>Longitude:</b> ${item.longitude || '-'}<br>
        //         <b>Keterangan:</b> ${item.description || '-'}<br>
        //     </div>
        // `;

            const popupContent = `
    <div style="display: flex; flex-direction: row; gap: 10px;">
        <div class="card" style="padding:10px; border:1px solid #ccc; border-radius:8px; width: 200px;">
            <strong>Perstatusan Lesen Perniagaan</strong><br>
            ${item.business_type?.map(business_type => `
                    ${business_type.business_type} (${business_type.percentage_label})<br>
                `).join('')}<br>
            <strong>Aktiviti Perniagaan</strong><br>
            ${item.business_activity?.map(business_activity => `
                    ${business_activity.business_activity} (${business_activity.percentage_label})<br>
                `).join('')}<br>
            <strong>Jenis Kategori Perniagaan</strong><br>
            ${item.sub_business_activity?.map(sub_business_activity => `
                    ${sub_business_activity.sub_business_activity} (${sub_business_activity.percentage_label})<br>
                `).join('')}<br>
        </div>
        <div class="card" style="padding:10px; border:1px solid #ccc; border-radius:8px; width: 200px;">
            Nama Daerah:<br>
            <strong>${item.city}</strong><br>
            Total PPK Overall:<br>
            <strong>${item.total_ahli_overall} Ahli</strong><br>
            Total PPK Aktif:<br>
            <strong>${item.total_ahli} Ahli</strong><br>
            Purata Pendapatan Mingguan:<br>
            <strong>${item.total_weekly || 'RM0.00'}</strong><br>
            Purata Pendapatan Bulanan:<br>
            <strong>${item.total_monthly || 'RM0.00'}</strong><br>
        </div>
        <div class="card" style="padding:10px; border:1px solid #ccc; border-radius:8px; width: 200px;">
            <strong>${item.city}</strong><br>
            <p style="margin: 10px 0px 0px 0px;">Perwakilan PPK Daerah:</p>
            <strong>${item.representation || '-'}</strong><br>
            Nama Persatuan:<br>
            <strong>${item.association || '-'}</strong>
            <p style="color: #0083C4;font-size: 10px;margin: 0px;line-height: 15px;">${item.description || '-'}</p>
            <p style="color: #B39702;font-size: 8px;margin: 0px;line-height: 15px;">${item.description2 || '-'}</p>
            <p style="margin: 5px 0px 0px 0px;">No. Telefon:</p>
            <strong>${item.phone_number || '-'}</strong><br>


        </div>
    </div>
`;

            var popup = new mapboxgl.Popup({
                    offset: 20,
                    maxWidth: "800px"
                })
                .setHTML(popupContent)
                .addTo(map);

            const marker = new mapboxgl.Marker({
                    color: "#E96F51"
                })
                .setLngLat([item.longitude, item.latitude])
                .setPopup(popup)
                .addTo(map);

        }


        // marker1.getElement().addEventListener('click', (e) => alert(data_city));


        // Create a default Marker, colored black, rotated 45 degrees.
        // const marker2 = new mapboxgl.Marker({ color: 'black', rotation: 45 })
        // .setLngLat([12.65147, 55.608166])
        // .addTo(map);
    </script>

</body>

</html>
