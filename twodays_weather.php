<?php
session_start();
require("./config.php");
$cityName = $_SESSION['selectCity'];

//清空資料表欄位
$sql = <<<sqlstate
            DELETE FROM twodays WHERE cityName='$cityName';
        sqlstate;
mysqli_query($link, $sql);
$resource_id = "F-D0047-089";
$Authorization = "CWB-20260A47-5D47-474D-AABA-BBC6BC84F310";
$locationName = urlencode($cityName);

$url = "https://opendata.cwb.gov.tw/api/v1/rest/datastore/" . $resource_id . "?Authorization=" . $Authorization . "&format=JSON&locationName=" . $locationName . "&sort=time";  // Your json data url
$json = file_get_contents($url);  // 把整個文件讀入一個字符串中
$data = json_decode($json, true);  // 將json轉成陣列或object 
// var_dump($data);

$weatherElement = $data['records']["locations"][0]['location'][0]['weatherElement'];
//用來判斷開始時間
$today = date('Y-m-d', strtotime("+1 day"));
$twoday =  date('Y-m-d', strtotime("+3 day"));
// unset($json, $data);
// var_dump(count($weatherElement));//記錄天氣因子個數


foreach ($weatherElement[6]['time'] as $key => $value) {
    if ($value["startTime"] > $today && $twoday > $value["startTime"]) {
        $startTime = $value['startTime'];
        $weatherDescription = $value['elementValue'][0]['value'];
        $weatherDescription = explode("。", $weatherDescription);
        $Wx = $weatherDescription[0];
        $PoP = $weatherDescription[1];
        $T = $weatherDescription[2];
        $CI = $weatherDescription[3];
        $RH = $weatherDescription[5];
        // echo "天氣狀況：" . $Wx;
        // echo "<br>";
        // echo $PoP;
        // echo "<br>";
        // echo $T;
        // echo "<br>";
        // echo "舒適度：" . $CI;
        // echo "<br>";
        // echo $RH;
        // echo "<br>";
        // echo "開始時間 : " . $startTime;
        // echo "<br>";
        $sql = <<<sqlstate
                    insert into twodays (cityName,Wx,PoP,T,CI,RH,startTime)
                    values('$cityName','$Wx','$PoP','$T','$CI','$RH','$startTime')
                  sqlstate;
        mysqli_query($link, $sql);
        // echo "<br>";
    }
}

$sql = <<<sqlstate
select * from twodays
where (cityName = '$cityName') and (startTime like '%6:00%' or startTime like '%18:00%')
sqlstate;
$twodays = mysqli_query($link, $sql);
?>