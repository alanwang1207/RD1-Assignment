<?php
session_start();


//用來記錄星期
$week = array("日", "一", "二", "三", "四", "五", "六");

//按下按鈕將選擇的縣市存到session並引入即時,未來兩天,未來一週的php檔
if (isset($_POST["btnOk"])) {
    $_SESSION['selectCity'] = $_POST["selectCity"];
    require("current_weather.php");
    require("twodays_weather.php");
    require("oneweek_weather.php");
}

//按下按鈕將選擇的縣市存到session並跳轉到雨量測量php
if (isset($_POST["btnRain"])) {
    $_SESSION['selectCity'] = $_POST["selectCity"];
    header("location:rainfall.php");
}

if (isset($_POST['btnMore'])) {
    $_SESSION['selectCity'] = $_POST["selectCity"];
    // $cityName = urlencode($cityName);
    header("location:" . $_SESSION['selectCity'] . "/index.php");
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
        <form method="post">
        </form>
    </div>
    <div class="box-body">
        <h2>城市名：<?= $_POST["selectCity"] ?></h2>
    </div>
    <div>
        <img src="<?= "Images/" . $_POST["selectCity"] . ".jpg"  ?>" alt="" width="500" height="400" class="img-thumbnail  float-right">
    </div>
    <form method="post">
        <select name="selectCity" id="selectCity" style="width: 200px;" class="browser-default custom-select">
            <option value="" selected="請選擇縣市" disabled>請選擇縣市</option>
            <option value="基隆市">基隆市</option>
            <option value="臺北市">臺北市</option>
            <option value="新北市">新北市</option>
            <option value="桃園市">桃園市</option>
            <option value="新竹市">新竹市</option>
            <option value="新竹縣">新竹縣</option>
            <option value="苗栗縣">苗栗縣</option>
            <option value="臺中市">臺中市</option>
            <option value="彰化縣">彰化縣</option>
            <option value="南投縣">南投縣</option>
            <option value="雲林縣">雲林縣</option>
            <option value="嘉義市">嘉義市</option>
            <option value="嘉義縣">嘉義縣</option>
            <option value="臺南市">臺南市</option>
            <option value="高雄市">高雄市</option>
            <option value="屏東縣">屏東縣</option>
            <option value="臺東縣">臺東縣</option>
            <option value="花蓮縣">花蓮縣</option>
            <option value="宜蘭縣">宜蘭縣</option>
            <option value="澎湖縣">澎湖縣</option>
            <option value="金門縣">金門縣</option>
            <option value="連江縣">連江縣</option>
        </select>
        <input type="submit" class="btn btn-primary" name="btnOk" id="btnOk" value="送出">
        <input type="submit" class="btn btn-success" id="btnRain" name="btnRain" value="雨量觀測">
        <input type="submit" class="btn btn-info" id="btnMore" name="btnMore" value="看更多">
        <div class="text-center col card box-margins" style="width: 35rem;">
            <!-- 即時天氣 -->
            <h2>
                即時天氣
            </h2>
            <table class="table table-striped">
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($currentwt)) { ?>
                        <thead>
                            <img src="<?= "Images/icon/" . $row["WxValue"] . ".png"  ?>" alt="" width="100" height="80" class="mx-auto d-block">
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
        <h2 style="text-align:left;">
            未來兩天
        </h2>
        <div class="row ">
            <?php while ($row = mysqli_fetch_assoc($twodays)) {    ?>
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
        <!-- 未來一週 -->
        <h2>
            未來一週
        </h2>
        <div class="row ">
            <?php while ($row = mysqli_fetch_assoc($oneweek)) {    ?>
                <div id="box1" class="col-md table ">
                    <div style="background-color: #C4E1FF;">
                        <?php list($date) = explode(" ", $row["startTime"]); //取出日期部份 
                        list($Y, $M, $D) = explode("-", $date); //分離出年月日以便製作時戳
                        echo $date;
                        echo "<br>";
                        echo "星期" . $week[date("w", mktime(0, 0, 0, $M, $D, $Y))]; ?>
                    </div>
                    <div style="background-color: #84C1FF;">
                        <br>
                        06:00<br>
                        <?= $row["Wx"] ?>
                        <br>
                        <img src="<?= "Images/icon/" . $row["WxValue"] . ".png"  ?>" alt="" width="100" height="80">
                        <br>
                        <img src="Images/icon/溫度.png" width="30" height="20" alt=""><?php $T = explode("溫度攝氏", $row["T"]);
                                                                                    echo $T[1]
                                                                                    ?>
                        <br>
                        舒適度：<?= $row["CI"] ?>
                        <br>
                        <?= $row["RH"] ?><br>
                    </div>
                    <?php $row = mysqli_fetch_assoc($oneweek) ?>
                    <div style="background-color: #2894FF;">
                        <br>
                        18:00
                        <br>
                        <?= $row["Wx"] ?>
                        <br>
                        <img src="<?= "Images/icon/" . $row["WxValue"] . ".png"  ?>" alt="" width="100" height="80">
                        <br>
                        <img src="Images/icon/溫度.png" width="30" height="20" alt=""><?php $T = explode("溫度攝氏", $row["T"]);
                                                                                    echo $T[1]
                                                                                    ?>
                        <br>
                        舒適度：<?= $row["CI"] ?>
                        <br>
                        <?= $row["RH"] ?><br>
                    </div>
                </div>
            <?php } ?>
        </div>
    </form>
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