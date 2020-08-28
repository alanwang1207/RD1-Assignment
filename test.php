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
// date_default_timezone_set('Asia/Taipei');
// $date = date("Y-m-d H:i:s");
// echo $date;
$url = "https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-091?Authorization=CWB-20260A47-5D47-474D-AABA-BBC6BC84F310&format=JSON&sort=time";  // Your json data url
$data = file_get_contents($url);  // PHP get data from url
$json = json_decode($data, true);  // Decode json data
global $cid;
if (isset($_POST["btnOk"])) {
    $cid = $_POST["cid"];
    // echo $cid;

    echo $city = $json['records']['locations'][0]['location'][$cid]['locationName'];
    echo "<br>";

    // $img = fopen("./images/'$city'.jpg", "rb");
    // header("Content-type: image/jpg");
    // fpassthru($img);
    // echo $json['records']['locations'][0]['location'][$cid]['weatherElement'][0]["description"] . " : " . $json['records']['locations'][0]['location'][$cid]['weatherElement'][0]["time"][0]["elementValue"][0]["value"];
    for ($j = 0; $j < 15; $j++) {
        for ($k = 0; $k < 14; $k++) {
            echo $json['records']['locations'][0]['location'][$cid]['weatherElement'][$j]["description"] . " : " . $json['records']['locations'][0]['location'][$cid]['weatherElement'][$j]["time"][$k]["elementValue"][0]["value"];
            echo "<br>";
        }
        echo "<br>";
    }
}

// for ($i = 0; $i < 22; $i++) {
//     $city = $json['records']['locations'][0]['location'][$i]['locationName'];
//     echo "城市名 : " .$city;
//     // var_dump();// 查詢資料

//     echo "<br>";
//     for ($j = 0; $j < 15; $j++) {
//         for($k = 0;$k<14;$k++){
//             echo $json['records']['locations'][0]['location'][$i]['weatherElement'][$j]["description"] . " : " . $json['records']['locations'][0]['location'][$i]['weatherElement'][$j]["time"][$k]["elementValue"][0]["value"];
//             echo "<br>";
//         }



//     }
//     echo "<br>";
// }


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