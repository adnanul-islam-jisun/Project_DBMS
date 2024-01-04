<?php
include(__DIR__ . "/Web_Design/DBconnection.php");

$toure = allgroup($_SESSION['username']);
if($toure == null){
    $locations[] = "dhaka";
}else{
    foreach ($toure as $location) {
    $locations[] = $location['ToLocation'];
}
}

$api_key = 'AkcKTkaCZKKAdrUrSATJWbV7xVleTJ1HtvHxp04_PKIVO1w5SSJGokoMWimJITcj';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type='text/javascript' src='https://www.bing.com/api/maps/mapcontrol?key=<?php echo $api_key; ?>&callback=loadMapScenario' async defer></script>
    <title>Your visited place</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
            height: 100vh;
            background: #032030;
        }

        #map {
            width: 600px;
            height: 700px;
        }
    </style>
</head>
<body> <div id="x" style="color:#fff ;  text-decoration: none; text-decoration: underline;  height: 40px; width: 90px; " ><a href="/Home_pages/home.php"  style="color:#fff ;  text-decoration: none; text-decoration: underline;  height: 40px; width: 190px;"><img src="/Home_pages/image/icons/next.png" alt="" width="25px" > Back </a></div>

    <div id="map" ></div>

    <script>
        function loadMapScenario() {
            var map = new Microsoft.Maps.Map(document.getElementById('map'), {
                credentials: '<?php echo $api_key; ?>',
                center: new Microsoft.Maps.Location(23.6850, 90.3563), // Center the map on Dhaka
                zoom: 7
            });

            var locations = <?php echo json_encode($locations); ?>;

            locations.forEach(function (locationName) {
                Microsoft.Maps.loadModule('Microsoft.Maps.Search', function () {
                    var searchManager = new Microsoft.Maps.Search.SearchManager(map);
                    var requestOptions = {
                        where: locationName + ', Bangladesh',
                        callback: function (searchResults, userData) {
                            if (searchResults && searchResults.results && searchResults.results.length > 0) {
                                var location = searchResults.results[0].location;
                                var pin = new Microsoft.Maps.Pushpin(location, {
                                    title: locationName
                                });
                                map.entities.push(pin);
                            }
                        }
                    };
                    searchManager.geocode(requestOptions);
                });
            });
        }
    </script>
</body>
</html>
