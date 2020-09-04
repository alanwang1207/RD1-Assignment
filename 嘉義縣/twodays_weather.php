<?php
session_start();
//引入db設定值
require("../config.php");
//選取的鄉鎮市區名
$locationName =  $_SESSION['selectLocation'];
$cityName = $selectCity;
//清空資料表欄位
$sql = <<<sqlstate
            DELETE FROM twodays WHERE locationName='$locationName';
        sqlstate;
mysqli_query($link, $sql);


//將url拆解
$resource_id = "F-D0047-029";
$Authorization = "CWB-20260A47-5D47-474D-AABA-BBC6BC84F310";
$locationNameurl = urlencode($locationName);

//抓取天氣綜合描述
$url1 = "https://opendata.cwb.gov.tw/api/v1/rest/datastore/" . $resource_id . "?Authorization=" . $Authorization . "&format=JSON&locationName=".$locationNameurl."&elementName=WeatherDescription&sort=time";  // Your json data url
$json1 = file_get_contents($url1);  // 把整個文件讀入一個字符串中
$data1 = json_decode($json1, true);  // 將json轉成陣列或object 
$weatherElement1 = $data1['records']['locations'][0]['location'][0]["weatherElement"];

//抓取天氣值
$url2 = "https://opendata.cwb.gov.tw/api/v1/rest/datastore/" . $resource_id . "?Authorization=" . $Authorization . "&format=JSON&locationName=".$locationNameurl."&elementName=Wx&sort=time";  // Your json data url
$json2 = file_get_contents($url2);  // 把整個文件讀入一個字符串中
$data2 = json_decode($json2, true);  // 將json轉成陣列或object 
$weatherElement2 = $data2['records']["locations"][0]['location'][0]['weatherElement'];

//用來判斷開始時間
$today = date('Y-m-d', strtotime("+1 day"));
$twoday =  date('Y-m-d', strtotime("+3 day"));



        //綜合描述所有值
        foreach ($weatherElement1[0]['time'] as $key => $value) {

            if ($value["startTime"] > $today && $twoday > $value["startTime"]) {
                $startTime = $value['startTime'];
                $weatherDescription = $value['elementValue'][0]['value'];
                $weatherDescription = explode("。", $weatherDescription);
                $Wx = $weatherDescription[0];
                $PoP = $weatherDescription[1];
                $T = $weatherDescription[2];
                $CI = $weatherDescription[3];
                $sql = <<<sqlstate
                    insert into twodays (cityName,locationName,Wx,WxValue,PoP,T,CI,RH,startTime)
                    values('$cityName','$locationName','$Wx','0','$PoP','$T','$CI','0','$startTime')
                  sqlstate;
                mysqli_query($link, $sql);
            }
        }

        //天氣所有值
        foreach ($weatherElement2[0]['time'] as $key => $value) {


            if ($value["startTime"] > $today && $twoday > $value["startTime"]) {
                $startTime = $value['startTime'];
                // $weatherDescription = $value['elementValue'][0]['value'];
                $WxValue =  $value['elementValue'][1]['value'];
                // echo $locationName;
                $sql = <<<sqlstate
                    update twodays set WxValue = $WxValue where locationName = '$locationName' and startTime= '$startTime' 
                  sqlstate;
                mysqli_query($link, $sql);
            }
        }



$sql = <<<sqlstate
select * from twodays
where (locationName = '$locationName') and (startTime like '%6:00%' or startTime like '%18:00%')
sqlstate;
$twodays = mysqli_query($link, $sql);
