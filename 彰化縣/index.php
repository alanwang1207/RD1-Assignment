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
                <option value="溪湖鎮">溪湖鎮</option>
                <option value="員林市">員林市</option>
                <option value="社頭鄉">社頭鄉</option>
                <option value="永靖鄉">永靖鄉</option>
                <option value="北斗鎮">北斗鎮</option>
                <option value="二水鄉">二水鄉</option>
                <option value="大村鄉">大村鄉</option>
                <option value="田中鎮">田中鎮</option>
                <option value="埔心鄉">埔心鄉</option>
                <option value="埔鹽鄉">埔鹽鄉</option>
                <option value="芬園鄉">芬園鄉</option>
                <option value="二林鎮">二林鎮</option>
                <option value="埤頭鄉">埤頭鄉</option>
                <option value="田尾鄉">田尾鄉</option>
                <option value="福興鄉">福興鄉</option>
                <option value="伸港鄉">伸港鄉</option>
                <option value="花壇鄉">花壇鄉</option>
                <option value="秀水鄉">秀水鄉</option>
                <option value="鹿港鎮">鹿港鎮</option>
                <option value="大城鄉">大城鄉</option>
                <option value="彰化市">彰化市</option>
                <option value="芳苑鄉">芳苑鄉</option>
                <option value="線西鄉">線西鄉</option>
                <option value="溪州鄉">溪州鄉</option>
                <option value="和美鎮">和美鎮</option>
                <option value="竹塘鄉">竹塘鄉</option>
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