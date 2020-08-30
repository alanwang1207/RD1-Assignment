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
echo "<br>";
    for ($j = 0; $j < count($locationName); $j++) {
        echo $locationName[$j]["locationName"];
            echo "<br>";
        }
if (isset($_POST["btnOk"])) {
    $_SESSION['selectCity'] = $_POST["selectCity"];
    // echo $cid;
    header("location:oneweek_weather.php");

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
            <option value="台北市">台北市</option>
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
        <input type="submit" name="btnOk" id="btnOk" value="送出">
        <!-- <td>
          <a > <img src="/Images/<?= $city ?>.jpg" alt=""></a> 
        </td> -->

    </form>
</body>

</html>