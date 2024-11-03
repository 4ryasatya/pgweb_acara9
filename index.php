<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Leaflet.JS + PHP</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        #map {
            width: 100%;
            height: 650px;
        }
        .judul{
            text-align: center;
        }
    </style>
</head>

<body>
    <h2 class="judul">Data Kecamatan di Kabupaten Sleman</h2>
    <div id="map"></div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script>
        // Inisialisasi peta
        var map = L.map("map").setView([-7.6667577, 110.3985214], 12);

        // Tile Layer Base Map
        var osm = L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        });

        var Esri_WorldImagery = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
        });

        var rupabumiindonesia = L.tileLayer('https://geoservices.big.go.id/rbi/rest/services/BASEMAP/Rupabumi_Indonesia/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'Badan Informasi Geospasial'
        });

        // Menambahkan basemap ke dalam peta
        osm.addTo(map);

        // Scale
        // var scale = L.control.scale();
        // Posisi skala
        var scale = L.control.scale({
            position: "bottomright",
            imperial: false
        });
        scale.addTo(map);

        <?php
        // Sesuaikan dengan setting MySQL
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "pgweb_acara8";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT kecamatan, luas_km2, longitude, latitude, jumlah_penduduk FROM data_kecamatan";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $lat = $row["latitude"];
                $long = $row["longitude"];
                $info = "Kecamatan: ". $row["kecamatan"] . "<br>" . "Luas (km2): " . $row["luas_km2"] . "<br>". "Jumlah Penduduk: ". $row["jumlah_penduduk"];
                echo "L.marker([$lat, $long]).addTo(map).bindPopup('$info');";
            }
        } else {
            echo "0 results";
        }
        $conn->close();
        ?>
    </script>
    
</body>

</html>