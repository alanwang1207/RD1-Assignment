<?php
session_start();
require("./config.php");
$cityName = $_SESSION['selectCity'];
//清空資料表欄位
$sql = <<<sqlstate
            DELETE FROM oneweek WHERE cityName='$cityName';
        sqlstate;
mysqli_query($link, $sql);
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
        $weatherDescription = explode("。", $weatherDescription);
        $Wx = $weatherDescription[0];
        // echo "天氣狀況：" . $Wx . "<br>";
        if (count($weatherDescription) > 6) {
            $PoP = $weatherDescription[1];
            $T = $weatherDescription[2];
            $CI = $weatherDescription[3];
            $RH = $weatherDescription[5];
            $sql = <<<sqlstate
                    insert into oneweek (cityName,Wx,PoP,T,CI,RH,startTime)
                    values('$cityName','$Wx','$PoP','$T','$CI','$RH','$startTime')
                  sqlstate;
        mysqli_query($link, $sql);
            // echo $PoP . "<br>";
        } else {
            $T = $weatherDescription[1];
            $CI = $weatherDescription[2];
            $RH = $weatherDescription[4];
            $sql = <<<sqlstate
                    insert into oneweek (cityName,Wx,PoP,T,CI,RH,startTime)
                    values('$cityName','$Wx','0','$T','$CI','$RH','$startTime')
                  sqlstate;
        mysqli_query($link, $sql);
        }
        // echo $T . "<br>";
        // echo "舒適度：" . $CI . "<br>";
        // echo "開始時間 : " . $startTime . "<br>";
    }
    // echo "<br>";
}

$sql = <<<sqlstate
    select * from oneweek where cityName = '$cityName';
sqlstate;
$oneweek = mysqli_query($link, $sql);