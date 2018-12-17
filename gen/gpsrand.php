<?php
function gpsRandom() {
$longitude = (float) 28.039372;
$latitude = (float) -26.2049;
$radius = rand(1,30); // in miles

$lng_min = $longitude - $radius / abs(cos(deg2rad($latitude)) * 69);
$lng_max = $longitude + $radius / abs(cos(deg2rad($latitude)) * 69);
$lat_min = $latitude - ($radius / 69);
$lat_max = $latitude + ($radius / 69);

$arr['lat'] = $lat_max;
$arr['lng'] = $lng_max;

return $arr;
}

