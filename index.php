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
    $_SESSION['selectCity'] = $_POST["cid"];
    // echo $cid;
    header("location:current_weather.php");

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
        <select name="cid" id="cid" class="form-control">
            <option value="" disabled="" selected="">選擇縣市</option>
            <option value="0">雲林縣</option>
            <option value="1">南投縣</option>
            <option value="2">連江縣</option>
            <option value="3">臺東縣</option>
            <option value="4">金門縣</option>
            <option value="5">宜蘭縣</option>
            <option value="6">屏東縣</option>
            <option value="7">苗栗縣</option>
            <option value="8">澎湖縣</option>
            <option value="9">台北市</option>
            <option value="10">新竹縣</option>
            <option value="11">花蓮縣</option>
            <option value="12">高雄市</option>
            <option value="13">彰化縣</option>
            <option value="14">新竹市</option>
            <option value="15">新北市</option>
            <option value="16">基隆市</option>
            <option value="17">臺中市</option>
            <option value="18">臺南市</option>
            <option value="19">桃園市</option>
            <option value="20">嘉義縣</option>
            <option value="21">嘉義市</option>
        </select>
        <input type="submit" name="btnOk" id="btnOk" value="送出">
        <td>
          <a > <img src="/Images/<?= $city ?>.jpg" alt=""></a> 
        </td>

    </form>
</body>

</html>