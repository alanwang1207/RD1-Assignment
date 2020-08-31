<?php
session_start();
// date_default_timezone_set('Asia/Taipei');
// $date = date("Y-m-d H:i:s");
// echo $date;
$url = "https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-C0032-001?Authorization=CWB-20260A47-5D47-474D-AABA-BBC6BC84F310&format=JSON&sort=time";  // Your json data url
$json = file_get_contents($url);  // PHP get data from url
$data = json_decode($json, true);  // Decode json data
global $cid;

$locationName = $data['records']['location'];
// echo "<br>";
//     for ($j = 0; $j < count($locationName); $j++) {
//         echo $locationName[$j]["locationName"];
//             echo "<br>";
//         }
if (isset($_POST["btnOk"])) {
    $_SESSION['selectCity'] = $_POST["selectCity"];
    $method = $_POST["selectmethod"];
    // echo $cid;
    require($method . ".php");
    // header("location:".$method.".php");


}


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form method="post">
        <select name="selectCity" id="selectCity" class="form-control">
            <option value="" disabled="" selected="">選擇縣市</option>
            <option value="雲林縣">雲林縣</option>
            <option value="南投縣">南投縣</option>
            <option value="連江縣">連江縣</option>
            <option value="臺東縣">臺東縣</option>
            <option value="金門縣">金門縣</option>
            <option value="宜蘭縣">宜蘭縣</option>
            <option value="屏東縣">屏東縣</option>
            <option value="苗栗縣">苗栗縣</option>
            <option value="澎湖縣">澎湖縣</option>
            <option value="臺北市">臺北市</option>
            <option value="新竹縣">新竹縣</option>
            <option value="花蓮縣">花蓮縣</option>
            <option value="高雄市">高雄市</option>
            <option value="彰化縣">彰化縣</option>
            <option value="新竹市">新竹市</option>
            <option value="新北市">新北市</option>
            <option value="基隆市">基隆市</option>
            <option value="臺中市">臺中市</option>
            <option value="臺南市">臺南市</option>
            <option value="桃園市">桃園市</option>
            <option value="嘉義縣">嘉義縣</option>
            <option value="嘉義市">嘉義市</option>
        </select>
        <select name="selectmethod" id="selectmethod" class="form-control">
            <option value="" disabled="" selected="">選擇查看資料</option>
            <option value="current_weather">即時</option>
            <option value="twodays_weather">兩天</option>
            <option value="oneweek_weather">一週</option>
            <option value="rainfall">雨量</option>
        </select>
        <input type="submit" name="btnOk" id="btnOk" value="送出">
        <!-- 即時天氣 -->
        <table>
            <?php while ($row = mysqli_fetch_assoc($currentwt)) { ?>

                <tr class=".container">
                    <div>
                    城市名：<?= $row["cityName"] ?>
                    </div>
                    <div>
                    天氣狀況：<?= $row["Wx"] ?>
                    </div>
                    <div>
                    降雨機率：<?= $row["PoP"] ?>%
                    </div>
                    <div>
                    最低溫：<?= $row["MinT"] ?>°C
                    </div>
                    <div>
                    最高溫：<?= $row["MaxT"] ?>°C
                    </div>
                    <div>
                    舒適度：<?= $row["CI"] ?>
                    </div>
                </tr>
            <?php } ?>
        </table>


         <!-- 未來兩天 -->
         <table>
            <?php while ($row = mysqli_fetch_assoc($twodays)) { ?>

                <tr class=".container">
                    <div>
                    城市名：<?= $row["cityName"] ?>
                    </div>
                    <div>
                    天氣狀況：<?= $row["Wx"] ?>
                    </div>
                    <div>
                    降雨機率：<?= $row["PoP"] ?>%
                    </div>
                    <div>
                    溫度：<?= $row["T"] ?>°C
                    </div>
                    <div>
                    舒適度：<?= $row["CI"] ?>
                    </div>
                    <div>
                    濕度：<?= $row["RH"] ?>％
                    </div>
                    <div>
                    <?= $row["startTime"] ?>
                    </div>
                </tr>
            <?php } ?>
        </table>

    </form>
</body>

</html>