<?php
session_start();
require("./config.php");
$cityName = $_SESSION['selectCity'];
echo $cityName;
echo "<br>";

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
        echo "天氣狀況 : " . $weatherDescription;
        echo "<br>";
        echo "startTime : " . $startTime;
        echo "<br>";
        $sql = <<<sqlstate
                    insert into twodays (cityName,startTime,weatherDescription)
                    values('$cityName','$startTime','$weatherDescription')
                  sqlstate;
        mysqli_query($link, $sql);
    }
    echo "<br>";
}


// for ($i = 0; $i < count($weatherElement); $i++) {
//     //元素名
//     $elementName = $weatherElement[$i]["elementName"];
//     echo "<br>";
//     //時間
//     $time = $weatherElement[$i]["time"];
//     //名稱
//     $description = $weatherElement[$i]["description"];
//     for ($j = 0; $j < count($time); $j++) {
//         if ($time[$j]["startTime"] > $today && $twoday > $time[$j]["startTime"] ) {

//             $startTime = $time[$j]["startTime"];
//             // echo $startTime;
//             // echo "<br>";
//             $elementName = $weatherElement[$i]["elementName"];
//             switch ($elementName) {
//                 case "WeatherDescription":
//                     $startTime = $time["startTime"];
//                     $elementValue = $time[$j]["elementValue"][0]["value"];
//                     $weatherDescription = $time[$j]["elementValue"][0]["value"];
//                     echo $description . " : " . $weatherDescription;
//                     echo "<br>";
//                     echo "startTime : " . $startTime;
//                     echo "<br>";

//                     break;
//             }
//             $sql = <<<sqlstate
//             insert into twodays (cityName,startTime,weatherDescription)
//             values('$cityName','$startTime','$weatherDescription')
//           sqlstate;
//             mysqli_query($link, $sql);
//         }
//     }
// }
