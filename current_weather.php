<?php
session_start();
//引入db設定值
require("./config.php");
//選取的城市名
$cityName = $_SESSION['selectCity'];


//清空資料表欄位
$sql = <<<sqlstate
            DELETE FROM currentwt WHERE cityName='$cityName';
        sqlstate;
mysqli_query($link, $sql);

//將url拆解
$resource_id = "F-C0032-001";
$Authorization = "CWB-20260A47-5D47-474D-AABA-BBC6BC84F310";
$locationName = urlencode($cityName);

$url = "https://opendata.cwb.gov.tw/api/v1/rest/datastore/" . $resource_id . "?Authorization=" . $Authorization . "&format=JSON&locationName=" . $locationName . "&sort=time";  // Your json data url
$json = file_get_contents($url);  // 把整個文件讀入一個字符串中
$data = json_decode($json, true);  // 將json轉成陣列或object 

//鎖定天氣元素
$weatherElement = $data['records']['location'][0]['weatherElement'];

//天氣元素分組
for ($i = 0; $i < count($weatherElement); $i++) {
    $elementName = $weatherElement[$i]["elementName"];
    $ntime = $weatherElement[$i]["time"][0];
    $parameterName = $ntime["parameter"]["parameterName"];
    switch ($elementName) {
        case "Wx":
            $Wx = $parameterName;
            $WxValue = $ntime["parameter"]["parameterValue"];
            break;
        case "PoP":
            $PoP = $parameterName;
            break;
        case "MinT":
            $MinT = $parameterName;
            break;
        case "MaxT":
            $MaxT = $parameterName;
            break;
        case "CI":
            $CI = $parameterName;
            break;
    }
}

//輸入資料
$sql = <<<sqlstate
    insert into currentwt (cityName,Wx,WxValue,PoP,MinT,MaxT,CI)
    values('$cityName','$Wx','$WxValue','$PoP','$MinT','$MaxT','$CI')
  sqlstate;
mysqli_query($link, $sql);

//秀出選取城市所有資料
$sql = <<<sqlstate
    select * from currentwt where cityName = '$cityName';
sqlstate;
$currentwt = mysqli_query($link, $sql);
