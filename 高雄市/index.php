<?php
session_start();

//用來記錄星期
$week = array("日", "一", "二", "三", "四", "五", "六");

//按下按鈕將選擇的縣市存到session並引入未來兩天,未來一週的php檔
if (isset($_POST["btnOk"])) {
    $selectCity = $_SESSION['selectCity'];
    $_SESSION['selectLocation'] = $_POST["selectLocation"];
    require("twodays_weather.php");
    require("oneweek_weather.php");
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

    <body>

        <div class="p-3 mb-2 bg-primary text-white">
            <h1>
                <a href="../index.php" class="text-light" data-toggle="tooltip" title="按我回首頁">RD1-氣象網</a>
            </h1>
            <form method="post">

            </form>
        </div>

        <div class="box-body">
            <h2><?= $selectCity ?></h2>
            <h2>鄉鎮市區名：<?= $_POST["selectLocation"] ?></h2>
        </div>
        <div>
            <img src="<?= "Images/" . $_POST["selectLocation"] . ".jpg"  ?>" alt="" width="500" height="400" class="img-thumbnail  float-right">
        </div>
        <form method="post">
            <select name="selectLocation" id="selectLocation" style="width: 200px;" class="browser-default custom-select">
                <option value="" selected="請選擇鄉鎮市區" disabled>請選擇鄉鎮市區</option>
                <option value="新興區">新興區</option>
                <option value="梓官區">梓官區</option>
                <option value="三民區">三民區</option>
                <option value="楠梓區">楠梓區</option>
                <option value="左營區">左營區</option>
                <option value="鼓山區">鼓山區</option>
                <option value="鹽埕區">鹽埕區</option>
                <option value="燕巢區">燕巢區</option>
                <option value="田寮區">田寮區</option>
                <option value="阿蓮區">阿蓮區</option>
                <option value="路竹區">路竹區</option>
                <option value="湖內區">湖內區</option>
                <option value="前鎮區">前鎮區</option>
                <option value="茄萣區">茄萣區</option>
                <option value="苓雅區">苓雅區</option>
                <option value="永安區">永安區</option>
                <option value="前金區">前金區</option>
                <option value="彌陀區">彌陀區</option>
                <option value="旗山區">旗山區</option>
                <option value="美濃區">美濃區</option>
                <option value="鳥松區">鳥松區</option>
                <option value="岡山區">岡山區</option>
                <option value="大樹區">大樹區</option>
                <option value="大寮區">大寮區</option>
                <option value="林園區">林園區</option>
                <option value="鳳山區">鳳山區</option>
                <option value="小港區">小港區</option>
                <option value="旗津區">旗津區</option>
                <option value="六龜區">六龜區</option>
                <option value="甲仙區">甲仙區</option>
                <option value="杉林區">杉林區</option>
                <option value="內門區">內門區</option>
                <option value="茂林區">茂林區</option>
                <option value="桃源區">桃源區</option>
                <option value="大社區">大社區</option>
                <option value="那瑪夏區">那瑪夏區</option>
                <option value="仁武區">仁武區</option>
                <option value="橋頭區">橋頭區</option>


            </select>
            <input type="submit" class="btn btn-primary" name="btnOk" id="btnOk" value="送出">



            <!-- 未來兩天 -->
            <h2 style="text-align:left;">
                未來兩天
            </h2>
            <div class="row ">
                <?php while ($row = mysqli_fetch_assoc($twodays)) {    ?>

                    <div class="col-sm ">

                        <thead>
                            <tr class="test">
                                <?= $row["locationName"] ?>
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
                                <img src="<?= "../Images/icon/" . $row["WxValue"] . ".png"  ?>" alt="" width="100" height="80" class="float-left">
                                <br><br><br><br>
                                <img src="../Images/icon/降雨量.png" width="30" height="20" alt=""><?= $row["PoP"] ?>
                                <br>
                                <img src="../Images/icon/溫度.png" width="30" height="20" alt=""><?= $row["T"] ?>
                                <br><br>
                            </tr>
                        </tbody>


                        <?php $row = mysqli_fetch_assoc($twodays) ?>

                        <tr>
                            <br>
                            傍晚天氣狀況：<?= $row["Wx"] ?>
                            <br>
                            <img src="<?= "../Images/icon/" . $row["WxValue"] . ".png"  ?>" alt="" width="100" height="80" class="float-left">
                            <br><br><br><br>
                            <img src="../Images/icon/降雨量.png" width="30" height="20" alt=""><?= $row["PoP"] ?>
                            <br>
                            <img src="../Images/icon/溫度.png" width="30" height="20" alt=""><?= $row["T"] ?>
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
                            <img src="<?= "../Images/icon/" . $row["WxValue"] . ".png"  ?>" alt="" width="100" height="80">
                            <br>
                            <img src="../Images/icon/溫度.png" width="30" height="20" alt=""><?php $T = explode("溫度攝氏", $row["T"]);
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
                            <img src="<?= "../Images/icon/" . $row["WxValue"] . ".png"  ?>" alt="" width="100" height="80">
                            <br>
                            <img src="../Images/icon/溫度.png" width="30" height="20" alt=""><?php $T = explode("溫度攝氏", $row["T"]);
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