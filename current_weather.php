<?php
session_start();

$cityName = $_SESSION['selectCity'];
echo $cityName;
echo "<br>";

$api = "F-C0032-001";
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
    $elementName = $weatherElement[$i]["elementName"];
    echo "<br>";
    $time = $weatherElement[$i]["time"];
        echo $elementName." : ".$parameterName = $time[0]["parameter"]["parameterName"];
        echo "<br>";
        echo "startTime : ".$startTime = $time[0]["startTime"];
        echo "<br>";
        echo "endTime : ".$endTime = $time[0]["endTime"];
        echo "<br>";
        

    
}

unset($json, $data);



var_dump($Wx);
$Wx = array();

