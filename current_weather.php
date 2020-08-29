<?php
session_start();

$cityId = $_SESSION['selectCid'];
echo $cityId;


$url = "https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-C0032-001?Authorization=CWB-20260A47-5D47-474D-AABA-BBC6BC84F310&format=JSON&sort=time";  // Your json data url
$json = file_get_contents($url);  // 把整個文件讀入一個字符串中
$data = json_decode($json, true);  // 將json轉成陣列或object 
// var_dump($data);
$locationName = $data['records']['locations'][0]['locationName'];
unset($json, $data);
