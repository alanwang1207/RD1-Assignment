<?php
session_start();

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
// unset($json, $data);
// var_dump(count($weatherElement));//記錄天氣因子個數
for ($i = 0; $i < count($weatherElement); $i++) {
    //元素名
    $elementName = $weatherElement[$i]["elementName"];
    //名稱
    $description = $weatherElement[$i]["description"];
    //時間
    $time = $weatherElement[$i]["time"];

    for ($j = 0; $j < count($time); $j++) {
        $elementValue = $time[$j]["elementValue"][0]["value"];
        switch ($elementName) {
            case "PoP12h":
                echo $description . " : " . $elementValue . "%";
                echo "<br>";
                echo "startTime : " . $startTime = $time[$j]["startTime"];
                echo "<br>";
                echo "endTime : " . $endTime = $time[$j]["endTime"];
                echo "<br>";
                break;
            case "T":
                echo $description . " : " . $elementValue . "°C";
                echo "<br>";
                echo "startTime : " . $startTime = $time[$j]["startTime"];
                echo "<br>";
                echo "endTime : " . $endTime = $time[$j]["endTime"];
                echo "<br>";
                break;

            case "RH":
                echo $description . " : " . $elementValue . "%";
                echo "<br>";
                echo "startTime : " . $startTime = $time[$j]["startTime"];
                echo "<br>";
                echo "endTime : " . $endTime = $time[$j]["endTime"];
                echo "<br>";
                break;
            case "MinCI":
                echo $description . " : " . $elementValue;
                echo "<br>";
                echo "startTime : " . $startTime = $time[$j]["startTime"];
                echo "<br>";
                echo "endTime : " . $endTime = $time[$j]["endTime"];
                echo "<br>";
                break;
            case "MaxAT":
                echo $description . " : " . $elementValue . "°C";
                echo "<br>";
                echo "startTime : " . $startTime = $time[$j]["startTime"];
                echo "<br>";
                echo "endTime : " . $endTime = $time[$j]["endTime"];
                echo "<br>";
                break;
            case "Wx":
                echo $description . " : " . $elementValue;
                echo "<br>";
                echo "startTime : " . $startTime = $time[$j]["startTime"];
                echo "<br>";
                echo "endTime : " . $endTime = $time[$j]["endTime"];
                echo "<br>";
                break;
            case "MaxCI":
                echo $description . " : " . $elementValue . "°C";
                echo "<br>";
                echo "startTime : " . $startTime = $time[$j]["startTime"];
                echo "<br>";
                echo "endTime : " . $endTime = $time[$j]["endTime"];
                echo "<br>";
                break;

            case "MinT":
                echo $description . " : " . $elementValue . "°C";
                echo "<br>";
                echo "startTime : " . $startTime = $time[$j]["startTime"];
                echo "<br>";
                echo "endTime : " . $endTime = $time[$j]["endTime"];
                echo "<br>";
                break;


            case "UVI":
                echo $description . " : " . $elementValue;
                echo "<br>";
                echo "startTime : " . $startTime = $time[$j]["startTime"];
                echo "<br>";
                echo "endTime : " . $endTime = $time[$j]["endTime"];
                echo "<br>";
                break;
            case "WeatherDescription":
                echo $description . " : " . $elementValue;
                echo "<br>";
                echo "startTime : " . $startTime = $time[$j]["startTime"];
                echo "<br>";
                echo "endTime : " . $endTime = $time[$j]["endTime"];
                echo "<br>";
                break;


            case "MinAT":
                echo $description . " : " . $elementValue . "°C";
                echo "<br>";
                echo "startTime : " . $startTime = $time[$j]["startTime"];
                echo "<br>";
                echo "endTime : " . $endTime = $time[$j]["endTime"];
                echo "<br>";
                break;

            case "MaxT":
                echo $description . " : " . $elementValue . "°C";
                echo "<br>";
                echo "startTime : " . $startTime = $time[$j]["startTime"];
                echo "<br>";
                echo "endTime : " . $endTime = $time[$j]["endTime"];
                echo "<br>";
                break;

            case "WD":
                echo $description . " : " . $elementValue . "公尺/秒";
                echo "<br>";
                echo "startTime : " . $startTime = $time[$j]["startTime"];
                echo "<br>";
                echo "endTime : " . $endTime = $time[$j]["endTime"];
                echo "<br>";
                break;
            case "Td":
                echo $description . " : " . $elementValue . "°C";
                echo "<br>";
                echo "startTime : " . $startTime = $time[$j]["startTime"];
                echo "<br>";
                echo "endTime : " . $endTime = $time[$j]["endTime"];
                echo "<br>";
                break;
        }
        echo "<br>";
    }
    echo "--------------------------------------------------------------------------<br>";
}
