<?php
session_start();
require("./config.php");
$cityName = $_SESSION['selectCity'];
// echo $cityName;
// echo "<br>";

//清空資料表欄位
$sql = <<<sqlstate
            DELETE FROM currentwt WHERE cityName='$cityName';
        sqlstate;
mysqli_query($link, $sql);

$resource_id = "F-C0032-001";
$Authorization = "CWB-20260A47-5D47-474D-AABA-BBC6BC84F310";
$locationName = urlencode($cityName);

$url = "https://opendata.cwb.gov.tw/api/v1/rest/datastore/" . $resource_id . "?Authorization=" . $Authorization . "&format=JSON&locationName=" . $locationName . "&sort=time";  // Your json data url
$json = file_get_contents($url);  // 把整個文件讀入一個字符串中
$data = json_decode($json, true);  // 將json轉成陣列或object 
// var_dump($data);
$weatherElement = $data['records']['location'][0]['weatherElement'];
// unset($json, $data);
// var_dump(count($weatherElement));//記錄天氣因子個數
for ($i = 0; $i < count($weatherElement); $i++) {
    $elementName = $weatherElement[$i]["elementName"];
    // echo "<br>";
    $ntime = $weatherElement[$i]["time"][0];
    $parameterName = $ntime["parameter"]["parameterName"];
    
    // echo "startTime : " . $startTime = $time[0]["startTime"];
    // echo "<br>";
    // echo "endTime : " . $endTime = $time[0]["endTime"];
    // echo "<br>";
    switch ($elementName) {
        case "Wx":
            $Wx = $parameterName;
            $WxValue = $ntime["parameter"]["parameterValue"];
            // echo "目前天氣狀況 : " . $WxValue;
            // echo "<br>";
            break;
        case "PoP":
            $PoP = $parameterName;
            // echo "降雨機率 : " . $PoP . "%";
            // echo "<br>";
            break;
        case "MinT":
            $MinT = $parameterName;
            // echo "最低溫度 : " . $MinT . "°C";
            // echo "<br>";
            break;
        case "MaxT":
            $MaxT = $parameterName;
            // echo "最高溫度 : " . $parameterName . "°C";
            // echo "<br>";
            break;
        case "CI":
            $CI = $parameterName;
            // echo "舒適度 : " . $parameterName;
            // echo "<br>";
            break;
    }
}

$sql = <<<sqlstate
    insert into currentwt (cityName,Wx,WxValue,PoP,MinT,MaxT,CI)
    values('$cityName','$Wx','$WxValue','$PoP','$MinT','$MaxT','$CI')
  sqlstate;

mysqli_query($link, $sql);

$sql = <<<sqlstate
    select * from currentwt where cityName = '$cityName';
sqlstate;
$currentwt = mysqli_query($link, $sql);

?>

