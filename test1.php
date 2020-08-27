<?php
header("content-type: text/html; charset=utf-8");

// 1. 初始設定
$ch = curl_init();

// 2. 設定 / 調整參數
curl_setopt($ch, CURLOPT_URL, "https://www.cwb.gov.tw/V8/C/W/County/MOD/wf7dayNC_NCSEI/ALL_Week.html?");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);

// 3. 執行，取回 response 結果
$pageContent = curl_exec($ch);


// 4. 關閉與釋放資源
curl_close($ch);

$doc = new DOMDocument();
libxml_use_internal_errors(true);
$doc->loadHTML($pageContent);
var_dump($doc);

$xpath = new DOMXPath($doc);
$entries = $xpath->query('//*[@id="table1"]/tbody[1]/td');
foreach ($entries as $entry) 
{
    $title = $xpath->query("./span/img[@alt]", $entry);
    echo "Title：" . $title->item(0)->nodeValue . "<br>";
}

?>
<!-- //*[@id="table1"]/tbody[1] -->