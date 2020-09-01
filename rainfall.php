<?php
session_start();
require_once("config.php");
$cityName = $_SESSION['selectCity'];
// echo $cityName;
// echo "<br>";
$sql = <<<sqlstate
                    delete from rainfall where city = '$cityName';
                  sqlstate;
mysqli_query($link, $sql);
$resource_id = "O-A0002-001";
$Authorization = "CWB-20260A47-5D47-474D-AABA-BBC6BC84F310";



$url = "https://opendata.cwb.gov.tw/api/v1/rest/datastore/" . $resource_id . "?Authorization=" . $Authorization . "&format=JSON";  // Your json data url
$json = file_get_contents($url);  // 把整個文件讀入一個字符串中
$data = json_decode($json, true);  // 將json轉成陣列或object 
// 觀測站名;

$locations = $data['records']['location'];
//總站數
// echo count($locations);
// unset($json, $data);
// var_dump(count($weatherElement));//記錄天氣因子個數

for ($i = 0; $i < count($locations); $i++) {
    $attr = $locations[$i]['parameter'][4]['parameterValue'];
    $city = $locations[$i]['parameter'][0]['parameterValue'];
    if ($attr == '中央氣象局' && $city == $cityName) {
        $locationName = $locations[$i]['locationName'];
        $onehour = $locations[$i]['weatherElement'][1]['elementValue'];
        $HOUR_24 = $locations[$i]['weatherElement'][6]['elementValue'];
        $sql = <<<sqlstate

                    insert into rainfall (locationName,city,onehour,HOUR_24)
                    values('$locationName','$city','$onehour','$HOUR_24')
                  sqlstate;
        mysqli_query($link, $sql);
    }
}
$sql = <<<sqlstate
                    select * from rainfall where city = '$cityName'
                  sqlstate;
$rainfall = mysqli_query($link, $sql);
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
        <h1>
            <a href="index.php" class="text-light">RD1-氣象網</a>
        </h1>
        <form method="post">

        </form>
    </div>

    <div class="box-body">
        <h2 class="card-title">城市名：<?= $cityName ?></h2>
    </div>
    <div>
        <img src="<?= "Images/" . $_SESSION['selectCity'] . ".jpg"  ?>" alt="" width="500" height="400" class="img-thumbnail  float-right">
    </div>



    <h3>
        中央氣象局雨量觀測站
    </h3>


    <div class="row ">

        <?php while ($row = mysqli_fetch_assoc($rainfall)) {    ?>

            <div class="col-md card">
                <tr>
                    <?= $row["locationName"] ?>
                    <br>
                    <?php if ($row["onehour"] <= '0') : ?>
                        １小時累積雨量 ： 該時刻因故無資料
                    <?php else : ?>
                        １小時累積雨量 ： <?= $row["onehour"] ?>
                    <?php endif; ?>
                    <br>
                    <?php if ($row["HOUR_24"] <= '0') : ?>
                        24小時累積雨量 ： 該時刻因故無資料
                    <?php else : ?>
                        24小時累積雨量 ：<?= $row["HOUR_24"] ?>
                    <?php endif; ?>

                </tr>
            </div>

        <?php } ?>

    </div>


</body>

</html>