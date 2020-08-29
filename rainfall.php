<?php
session_start();

$cityName = $_SESSION['selectCity'];
echo $cityName;
echo "<br>";

$resource_id = "O-A0002-001";
$Authorization = "CWB-20260A47-5D47-474D-AABA-BBC6BC84F310";
$locationName = urlencode($cityName);

$url = "https://opendata.cwb.gov.tw/api/v1/rest/datastore/" . $resource_id . "?Authorization=" . $Authorization . "&format=JSON";  // Your json data url
$json = file_get_contents($url);  // 把整個文件讀入一個字符串中
$data = json_decode($json, true);  // 將json轉成陣列或object 
// 觀測站名;
$location = $data['records']['location'];
$obsTime = $data['records']['location'][0]['time']["obsTime"];
// unset($json, $data);
// var_dump(count($weatherElement));//記錄天氣因子個數
for ($i = 0; $i < count($location); $i++) {
    $locationName = $location[$i]['locationName'];
    echo "<br>";
    $obsTime = $location[$i]["time"]["obsTime"];
    $weatherElement = $location[$i]["weatherElement"];
    for ($j = 0; $j < count($weatherElement); $j++) {
        $elementName = $weatherElement[$j]["elementName"];
        $elementValue = $weatherElement[$j]["elementValue"];
        switch ($elementName) {
            case "HOUR_24":
                echo "過去２４小時累積雨量  : " . $elementValue. "mm";
                echo "<br>";
                break;
            case "RAIN":
                echo "過去一小時累積雨量 : " . $elementValue . "mm";
                echo "<br>";
                break;
        }
    }
}

unset($json, $data);

$Wx = array();
