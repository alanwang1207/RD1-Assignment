<?php
session_start();

$cityName = $_SESSION['selectCity'];
// echo $cityName;
// echo "<br>";
echo "城市名 ： " . $cityName;
echo "<br>";
$resource_id = "O-A0002-001";
$Authorization = "CWB-20260A47-5D47-474D-AABA-BBC6BC84F310";



$url = "https://opendata.cwb.gov.tw/api/v1/rest/datastore/" . $resource_id . "?Authorization=" . $Authorization . "&format=JSON";  // Your json data url
$json = file_get_contents($url);  // 把整個文件讀入一個字符串中
$data = json_decode($json, true);  // 將json轉成陣列或object 
// 觀測站名;

$locations = $data['records']['location'];
//總站數
// echo count($locations);
// unset($json, $data);
// var_dump(count($weatherElement));//記錄天氣因子個數

for ($i = 0; $i < count($locations); $i++) {
    $attr = $locations[$i]['parameter'][4]['parameterValue'];
    $city = $locations[$i]['parameter'][0]['parameterValue'];
    if ($attr == '中央氣象局' && $city == $cityName) {
        $locationName = $locations[$i]['locationName'];
        $onehour = $locations[$i]['weatherElement'][1]['elementValue'];
        $HOUR_24 = $locations[$i]['weatherElement'][6]['elementValue'];
        echo "<br>";
        echo "觀測站名 ： " . $locationName;
        echo "<br>";
        if ($onehour < 0) {
            echo "１小時累積雨量 ： 該時刻因故無資料";
            echo "<br>";
        } else {
            echo "１小時累積雨量 ： " . $onehour;
            echo "<br>";
        }
        if ($HOUR_24 <= 0) {
            echo "24小時累積雨量 ： 該時刻因故無資料";
            echo "<br>";
        } else {
            echo "24小時累積雨量 ： " . $HOUR_24;
            echo "<br>";
        }


        // $sql = <<<sqlstate

        //             insert into rainfall (locationName,city,onehour,HOUR_24)
        //             values('$locationName','$city','$onehour','$HOUR_24')
        //           sqlstate;
        // mysqli_query($link, $sql);
    }
}
