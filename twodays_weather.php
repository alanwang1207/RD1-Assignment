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
    select * from twodays where cityName = '$cityName';
sqlstate;
$twodays = mysqli_query($link, $sql);



// for ($i = 0; $i < count($weatherElement); $i++) {
//     $time = $weatherElement[$i]['time'];
//     for ($j = 0; $j < count($time); $j++) {
//         if (($time[$j]["startTime"] > $today && $twoday > $time[$j]["startTime"]) || ($time[$j]["dataTime"] > $today && $twoday > $time[$j]["dataTime"])) {
//             $startTime = $time[$j]['startTime'];
//             $elementName = $weatherElement[$i]["elementName"];
//             // $weatherDescription = $value['elementValue'][0]['value'];
//             // $str_sec = explode("。",$weatherDescription);
//             switch ($elementName) {
//                 case "WeatherDescription":
//                     $weatherDescription = $time[$j]['elementValue'][0]['value'];
//                     $PoP3h = explode("。", $weatherDescription);
//                     $PoP3h = $PoP3h[1];
//                     echo $PoP3h;
//                     echo "<br>";
//                     echo "startTime : " . $startTime;
//                     echo "<br>";

//                     break;

//                 case "Wx":
//                     $Wx = $time[$j]["elementValue"][0]["value"];
//                     // echo $elementName . " : " .  $elementValue;
//                     echo "天氣現象 : " . $Wx;
//                     echo "<br>";
//                     echo "startTime : " . $startTime;
//                     echo "<br>";

//                     break;

//                 case "AT":
//                     $dataTime = $time[$j]['dataTime'];
//                     $AT = $time[$j]["elementValue"][0]["value"];
//                     // echo $elementName . " : " .  $elementValue;
//                     echo "體感溫度 : " . $AT . "°C";
//                     echo "<br>";
//                     echo "startTime : " . $dataTime;
//                     echo "<br>";
//                     break;
//                 case "T":
//                     $T = $time[$j]["elementValue"][0]["value"];
//                     // echo $elementName . " : " .  $elementValue;
//                     echo "溫度 : " . $T . "°C";
//                     echo "<br>";
//                     echo "startTime : " . $dataTime;
//                     echo "<br>";
//                     break;
//                 case "CI":
//                     $CI = $time[$j]["elementValue"][1]["value"];
//                     // echo $elementName . " : " .  $elementValue;
//                     echo "舒適度 : " .  $CI;
//                     echo "<br>";
//                     echo "startTime : " . $dataTime;
//                     echo "<br>";

//                     break;
//             }
//         }
//     }
//     echo "<br>";
//     $sql = <<<sqlstate
//         insert into twodays (cityName,startTime,PoP12h,Wx)
//         values('$cityName','$startTime','$PoP3h','$Wx')
//       sqlstate;
//     mysqli_query($link, $sql);
// }




// foreach ($weatherElement[$i]['time'] as $key => $value) {
//     if ($value["startTime"] > $today && $twoday > $value["startTime"]) {
//         $startTime = $value['startTime'];
//         $weatherDescription = $value['elementValue'][0]['value'];
//         // $str_sec = explode("。",$weatherDescription);
//         echo "天氣狀況 : " . $weatherDescription;
//         echo "<br>";
//         echo "startTime : " . $startTime;
//         echo "<br>";
//         $sql = <<<sqlstate
//                     insert into twodays (cityName,startTime,weatherDescription)
//                     values('$cityName','$startTime','$weatherDescription')
//                   sqlstate;
//         mysqli_query($link, $sql);
//     }
//     echo "<br>";
// }


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
?>