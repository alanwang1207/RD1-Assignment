<?php
    $url = "https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-C0032-001?Authorization=CWB-0EF10C78-E76B-49E3-BD74-05B21416C3F5&format=JSON";  // Your json data url
    $data = file_get_contents($url);  // PHP get data from url
    $json = json_decode($data, true);  // Decode json data    
    var_dump($json['records']['location'][0]['locationName']);// 查詢資料
    echo "<br>";
    var_dump($json['records']['location'][0]['weatherElement'][0]['time'][0]['parameter']['parameterName']);
 
?>

<?php
    $url = "https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-003?Authorization=CWB-0EF10C78-E76B-49E3-BD74-05B21416C3F5&format=JSON";  // Your json data url
    $data = file_get_contents($url);  // PHP get data from url
    $json = json_decode($data, true);  // Decode json data    
    var_dump($json['records']['location'][0]['locationName']);// 查詢資料
    echo "<br>";
    var_dump($json['records']['location'][0]['weatherElement'][0]['time'][0]['parameter']['parameterName']);
 
?>