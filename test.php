<!-- <?php
        $url = "https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-C0032-001?Authorization=CWB-20260A47-5D47-474D-AABA-BBC6BC84F310&format=JSON&sort=time";  // Your json data url
        $data = file_get_contents($url);  // PHP get data from url
        $json = json_decode($data, true);  // Decode json data
        for ($i = 0; $i < 22; $i++) {
            echo "城市名 : " . $json['records']['location'][$i]['locationName'];
            // var_dump();// 查詢資料
            echo "<br>";
            for ($j = 0; $j < 5; $j++) {
                echo $json['records']['location'][$i]['weatherElement'][$j]['elementName'] . " : " . $json['records']['location'][$i]['weatherElement'][$j]['time'][0]['parameter']['parameterName'];
                echo "<br>";
            }
            echo "<br>";
        }



        ?> -->


<?php
date_default_timezone_set('Asia/Taipei');
$date = date("Y-m-d H:i:s");
echo $date;
$url = "https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-091?Authorization=CWB-20260A47-5D47-474D-AABA-BBC6BC84F310&format=JSON&sort=time";  // Your json data url
$data = file_get_contents($url);  // PHP get data from url
$json = json_decode($data, true);  // Decode json data


for ($i = 0; $i < 22; $i++) {
    echo "城市名 : " . $json['records']['locations'][0]['location'][$i]['locationName'];
    // var_dump();// 查詢資料
    echo "<br>";
    for ($j = 0; $j < 15; $j++) {
        for($k = 0;$k<14;$k++){
            echo $json['records']['locations'][0]['location'][$i]['weatherElement'][$j]["description"] . " : " . $json['records']['locations'][0]['location'][$i]['weatherElement'][$j]["time"][$k]["elementValue"][0]["value"];
            echo "<br>";
        }

           
        
    }
    echo "<br>";
}


?>
