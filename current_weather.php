<?php
session_start();

$cityName = $_SESSION['selectCity'];
echo $cityName;
echo "<br>";

$api = "F-D0047-089";
$Authorization = "CWB-20260A47-5D47-474D-AABA-BBC6BC84F310";
$locationName = urlencode($cityName);

$url = "https://opendata.cwb.gov.tw/api/v1/rest/datastore/".$api."?Authorization=".$Authorization."&format=JSON&locationName=".$locationName."&sort=time";  // Your json data url
$json = file_get_contents($url);  // 把整個文件讀入一個字符串中
$data = json_decode($json, true);  // 將json轉成陣列或object 
// var_dump($data);
$weatherElement = $data['records']['location'][0]['weatherElement'];
// unset($json, $data);
// var_dump(count($weatherElement));//記錄天氣因子個數
for($i=0;$i<count($weatherElement);$i++){
    echo $elementName = $weatherElement[$i]["elementName"];
    echo "<br>";
    $time = $weatherElement[$i]["time"];
    for($t=0;$t<count($time);$t++){
        echo "startTime : ".$startTime = $time[$t]["startTime"];
        echo "<br>";
        echo "endTime : ".$endTime = $time[$t]["endTime"];
        echo "<br>";
        echo "天氣狀況 : ".$parameterName = $time[$t]["parameter"]["parameterName"];
        echo "<br>";

    }
}

unset($json, $data);



var_dump($Wx);
$Wx = array();
