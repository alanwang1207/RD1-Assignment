<?php
session_start();
//引入db設定值
require("./config.php");
//選取的城市名
$cityName = $_SESSION['selectCity'];


//清空資料表欄位
$sql = <<<sqlstate
            DELETE FROM yilan ;
        sqlstate;
mysqli_query($link, $sql);

//將url拆解
$resource_id = "F-D0047-001";
$Authorization = "CWB-20260A47-5D47-474D-AABA-BBC6BC84F310";

//抓取天氣綜合描述
$url1 = "https://opendata.cwb.gov.tw/api/v1/rest/datastore/" . $resource_id . "?Authorization=" . $Authorization . "&format=JSON&elementName=WeatherDescription&sort=time";  // Your json data url
$json1 = file_get_contents($url1);  // 把整個文件讀入一個字符串中
$data1 = json_decode($json1, true);  // 將json轉成陣列或object 
$weatherElement1 = $data1['records']["locations"][0]['location'][0]['weatherElement'];

//抓取天氣值
$url2 = "https://opendata.cwb.gov.tw/api/v1/rest/datastore/" . $resource_id . "?Authorization=" . $Authorization . "&format=JSON&elementName=Wx&sort=time";  // Your json data url
$json2 = file_get_contents($url2);  // 把整個文件讀入一個字符串中
$data2 = json_decode($json2, true);  // 將json轉成陣列或object 
$weatherElement2 = $data2['records']["locations"][0]['location'][0]['weatherElement'];

//用來判斷開始時間
$today = date('Y-m-d', strtotime("+1 day"));
$twoday =  date('Y-m-d', strtotime("+3 day"));

$location = $data1['records']['locations'][0]['location'];

foreach ($location as $key => $value) {
    $locationName = $value['locationName'];
    echo $locationName;
    $weatherElement1=$value['weatherElement'];
    echo $weatherElement1;
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
                    insert into yilan (locationName,Wx,WxValue,PoP,T,CI,startTime)
                    values('$locationName','$Wx','0','$PoP','$T','$CI','$startTime')
                  sqlstate;
        mysqli_query($link, $sql);
    }
}
}
//天氣所有值
// foreach ($weatherElement2[0]['time'] as $key => $value) {
//     if ($value["startTime"] > $today && $twoday > $value["startTime"]) {
//         $startTime = $value['startTime'];
//         $weatherDescription = $value['elementValue'][0]['value'];
//         $WxValue =  $value['elementValue'][1]['value'];
        
//         $sql = <<<sqlstate
//                     update twodays set WxValue = '$WxValue' where cityName = '$cityName' and startTime= '$startTime' 
//                   sqlstate;
//         mysqli_query($link, $sql);
//     }
// }

//秀出選取城市所有資料
$sql = <<<sqlstate
select * from yilan
where  startTime like '%6:00%' or startTime like '%18:00%'
sqlstate;
$twodays = mysqli_query($link, $sql);




session_start();

//用來記錄星期
$week = array("日", "一", "二", "三", "四", "五", "六");

//按下按鈕將選擇的縣市存到session並引入即時,未來兩天,未來一週的php檔
// if (isset($_POST["btnOk"])) {
//     $_SESSION['selectCity'] = $_POST["selectCity"];
//     require("current_weather.php");
//     require("twodays_weather.php");
//     require("oneweek_weather.php");
// }

// //按下按鈕將選擇的縣市存到session並跳轉到雨量測量php
// if (isset($_POST["btnRain"])) {
//     $_SESSION['selectCity'] = $_POST["selectCity"];
//     header("location:rainfall.php");
// }
?>






<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RD1-氣象網</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/grid.css">
</head>
<!-- 顯示提示字特效 -->
<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

<body>

    <div class="p-3 mb-2 bg-primary text-white">
        <h1>
            <a href="index.php" class="text-light" data-toggle="tooltip" title="按我回首頁">RD1-氣象網</a>
        </h1>
    </div>

    <div class="box-body">
        <h2>城市名：<?= $_POST["selectCity"] ?></h2>
    </div>
    <div>
        <img src="<?= "Images/" . $_POST["selectCity"] . ".jpg"  ?>" alt="" width="500" height="400" class="img-thumbnail  float-right">
    </div>

        <!-- 未來兩天 -->
        <h2 style="text-align:left;">
            宜蘭未來兩天
        </h2>
        <div class="row ">
            <?php while ($row = mysqli_fetch_assoc($yilan)) {    ?>

                <div class="col-sm ">

                    <thead>
                        <tr class="test">
                            <?php list($date) = explode(" ", $row["startTime"]); //取出日期部份 
                            list($Y, $M, $D) = explode("-", $date); //分離出年月日以便製作時戳
                            echo $date;
                            echo "<br>";
                            echo "星期" . $week[date("w", mktime(0, 0, 0, $M, $D, $Y))]; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <br>
                            凌晨天氣狀況：<?= $row["Wx"] ?>
                            <br>
                            <img src="<?= "Images/icon/" . $row["WxValue"] . ".png"  ?>" alt="" width="100" height="80" class="float-left">
                            <br><br><br><br>
                            <img src="Images/icon/降雨量.png" width="30" height="20" alt=""><?= $row["PoP"] ?>
                            <br>
                            <img src="Images/icon/溫度.png" width="30" height="20" alt=""><?= $row["T"] ?>
                            <br><br>
                        </tr>
                    </tbody>


                    <?php $row = mysqli_fetch_assoc($twodays) ?>

                    <tr>
                        <br>
                        傍晚天氣狀況：<?= $row["Wx"] ?>
                        <br>
                        <img src="<?= "Images/icon/" . $row["WxValue"] . ".png"  ?>" alt="" width="100" height="80" class="float-left">
                        <br><br><br><br>
                        <img src="Images/icon/降雨量.png" width="30" height="20" alt=""><?= $row["PoP"] ?>
                        <br>
                        <img src="Images/icon/溫度.png" width="30" height="20" alt=""><?= $row["T"] ?>
                        <br><br>
                    </tr>
                </div>

            <?php } ?>
        </div>





    <!-- 回頂部特效 -->
    <button type="button" id="BackTop" class="btn btn-primary">回頂部</button>
    <script>
        $(function() {
            $('#BackTop').click(function() {
                $('html,body').animate({
                    scrollTop: 0
                }, 333);
            });
            $(window).scroll(function() {
                if ($(this).scrollTop() > 300) {
                    $('#BackTop').fadeIn(222);
                } else {
                    $('#BackTop').stop().fadeOut(222);
                }
            }).scroll();
        });
    </script>

    
</body>

</html>