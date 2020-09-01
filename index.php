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
    $cityi = $_POST["selectCity"];
    $_SESSION['selectCity'] = $_POST["selectCity"];
    // echo $cid;
    require("current_weather.php");
    require("twodays_weather.php");
    // require("oneweek_weather.php");
    // header("location:".$method.".php");


}


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
    <link rel="stylesheet" href="css/ style.css">
    <link rel="stylesheet" href="css/grid.css">
</head>


<body>

    <div class="p-3 mb-2 bg-primary text-white">
        <h1 class="text-light">RD1-氣象網</h1>
    </div>
    <div class="box-body">
        <h2>城市名：<?= $_POST["selectCity"] ?></h2>
    </div>
    <div>
            <img src="<?= "Images/" . $_POST["selectCity"] . ".jpg"  ?>" alt="" width="500" height="400" class="img-thumbnail  float-right">
        </div>
    <form method="post">
        <select name="selectCity" id="selectCity" style="width: 200px" class="browser-default custom-select">
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
        <input type="submit" name="btnOk" id="btnOk" value="送出">

        

        <div id="box1" class="text-center col card box-margins" style="width: 30rem;">

            <!-- 即時天氣 -->
            <h3>
                即時天氣
            </h3>
            <table class="table table-striped">
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($currentwt)) { ?>
                        <thead>
                            <tr>
                                <th>天氣狀況：</th>
                                <th>降雨機率：</th>
                                <th>溫度：</th>
                                <th>舒適度：</th>
                            </tr>
                        </thead>
                        <tr>

                            <td><?= $row["Wx"] ?></td>
                            <td><?= $row["PoP"] ?>%</td>
                            <td><?= $row["MinT"] ?>～<?= $row["MaxT"] ?>°C</td>
                            <td><?= $row["CI"] ?></td>

                        </tr>
                    <?php } ?>
                </tbody>
            </table>

        </div>





        <!-- 未來兩天 -->
        <h3>
            未來兩天
        </h3>
        <div id="box">

            <?php while ($row = mysqli_fetch_assoc($twodays)) {    ?>
                <div>
                    <?= $row["startTime"] ?>
                    <br>
                    天氣狀況：<?= $row["Wx"] ?>
                    <br>
                    <img src="<?= "Images/icon/" .$row["Wx"]. ".png"  ?>" alt="" width="100" height="80" class="float-left">
                    <br><br><br><br>
                    <img src="Images/icon/降雨量.png" width="30" height="20" alt=""><?= $row["PoP"] ?>
                    <br>
                    <img src="Images/icon/溫度.png" width="30" height="20" alt=""><?= $row["T"] ?>
                    <br><br>
                </div>

            <?php } ?>
        </div>











        <!-- 未來一週 -->
        <!-- <h3>
            未來一週
        </h3> -->

        <div id="box">

            <?php while ($row = mysqli_fetch_assoc($oneweek)) {    ?>
                <div>
                    天氣狀況：<?= $row["Wx"] ?>
                    <br>
                    <?php if ($row["PoP"] == '-1') : ?>
                    <?php else : ?>
                        <?= $row["PoP"] ?>
                    <?php endif; ?>
                    <br>
                    溫度：<?= $row["T"] ?>
                    <br>
                    舒適度：<?= $row["CI"] ?>
                    <br>
                    舒適度：<?= $row["CI"] ?>
                    <br>
                    濕度：<?= $row["RH"] ?>
                    <br>
                    <?= $row["startTime"] ?>
                    <br><br>
                </div>

            <?php } ?>
        </div>


    </form>
</body>

</html>