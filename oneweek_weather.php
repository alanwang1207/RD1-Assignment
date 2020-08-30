<?php
session_start();
require("./config.php");
$cityName = $_SESSION['selectCity'];
echo $cityName;
echo "<br>";

$resource_id = "F-D0047-091";
$Authorization = "CWB-20260A47-5D47-474D-AABA-BBC6BC84F310";
$locationName = urlencode($cityName);

$url = "https://opendata.cwb.gov.tw/api/v1/rest/datastore/" . $resource_id . "?Authorization=" . $Authorization . "&format=JSON&locationName=" . $locationName . "&sort=time";  // Your json data url
$json = file_get_contents($url);  // 把整個文件讀入一個字符串中
$data = json_decode($json, true);  // 將json轉成陣列或object 
// var_dump($data);

$weatherElement = $data['records']["locations"][0]['location'][0]['weatherElement'];
//用來判斷開始時間
$today = date('Y-m-d', strtotime("+1 day"));
$oneweek =  date('Y-m-d', strtotime("+8 day"));
// unset($json, $data);
// var_dump(count($weatherElement));//記錄天氣因子個數


foreach ($weatherElement[10]['time'] as $key => $value) {
    if ($value["startTime"] > $today) {
        $startTime = $value['startTime'];
        $weatherDescription = $value['elementValue'][0]['value'];
        $sql = <<<sqlstate
                    insert into oneweek (cityName,startTime,weatherDescription)
                    values('$cityName','$startTime','$weatherDescription')
                  sqlstate;
        mysqli_query($link, $sql);
    }
}