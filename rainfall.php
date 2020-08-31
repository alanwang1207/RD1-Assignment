<?php
session_start();

$cityName = $_SESSION['selectCity'];
echo $cityName;
echo "<br>";

$resource_id = "O-A0002-001";
$Authorization = "CWB-20260A47-5D47-474D-AABA-BBC6BC84F310";



$url = "https://opendata.cwb.gov.tw/api/v1/rest/datastore/" . $resource_id . "?Authorization=" . $Authorization . "&format=JSON";  // Your json data url
$json = file_get_contents($url);  // 把整個文件讀入一個字符串中
$data = json_decode($json, true);  // 將json轉成陣列或object 
// 觀測站名;
$locations = $data['records']['location'];

$city = $data['records']['location'][$i]['parameter'][0]['parameterValue'];
$human = $data['records']['location'][$i]['parameter'][4]['parameterValue'];
$onehour = $data['records']['location'][$i]['weatherElement'][1]['elementValue'];
$HOUR_24 = $data['records']['location'][$i]['weatherElement'][6]['elementValue'];
// unset($json, $data);
// var_dump(count($weatherElement));//記錄天氣因子個數

for ($i = 0; $i < count($locations); $i++) {
    $human = $data['records']['location'][$i]['parameter'][4]['parameterValue'];
    if ($human = '中央氣象局') {
        $locationName = $locations[$i]['locationName'];
        $city = $locations[$i]['parameter'][0]['parameterValue'];
        $onehour = $locations[$i]['weatherElement'][1]['elementValue'];
        $HOUR_24 = $locations[$i]['weatherElement'][6]['elementValue'];
        $sql = <<<sqlstate
                   
                    insert into oneweek (cityName,startTime,weatherDescription)
                    values('$cityName','$startTime','$weatherDescription')
                  sqlstate;
        mysqli_query($link, $sql);
    }
}
