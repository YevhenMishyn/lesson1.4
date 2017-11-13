<?php
header('Content-Type: text/html; charset=utf-8');
$city = 'Kiev';
$appid = '09e09949093650b9d3c003c269a6339c';
$lang = 'en';
$units = 'metric';
$url = 'http://api.openweathermap.org/data/2.5/weather?'."q=$city&appid=$appid&units=$units&lang=$lang";
$data = file_get_contents ($url);
$filename = 'templog.json';
if ($data) {
    $handle = fopen($filename, 'w');
    fwrite($handle, $data);
    fclose($handle);
}
$Weatherdata = [];
$handleWritten =  fopen($filename, 'r');
$dataWritten = file_get_contents ($filename);
$Weatherdata = json_decode($dataWritten, true);
switch ($Weatherdata['wind']['deg']) {
    case $Weatherdata['wind']['deg'] <= 20:
        $Wind="Cевер";
        break;
    case $Weatherdata['wind']['deg'] <= 70:
        $Wind="Cеверо-Восток";
        break;
    case $Weatherdata['wind']['deg'] <= 110:
        $Wind="Восток";
        break;
    case $Weatherdata['wind']['deg'] <= 160:
        $Wind="Юго-Восток";
        break;
    case $Weatherdata['wind']['deg'] <= 200:
        $Wind="г";
        break;
    case $Weatherdata['wind']['deg'] <= 250:
        $Wind="Юго-Запад";
        break;
    case $Weatherdata['wind']['deg'] <= 290:
        $Wind="Запад";
        break;
    case $Weatherdata['wind']['deg'] <= 340:
        $Wind="Северо-Запад";
        break;
    case $Weatherdata['wind']['deg'] > 340:
        $Wind="Юго-Запад";
        break;
}

$Sign = null;
If ($Weatherdata['main']['temp'] > 0) { $Sign = "+"; }
?>

<table border="1">
    <caption><h1>Текущая погода в городе <?= $city ?></h1></caption>
    <tr><td class="firstcol">Текущая погода</td><td class="secondcol"><?= $Weatherdata['weather'][0]['description'] ?></td></tr>
    <tr><td class="firstcol">Температура воздуха</td><td class="secondcol"><?= $Sign . $Weatherdata['main']['temp'] ?> градусов Цельсия</td></tr>
    <tr><td class="firstcol">Атмосферное давление</td><td class="secondcol"><?= $Weatherdata['main']['pressure']*0.75 ?> мм рт. столба</td></tr>
    <tr><td class="firstcol">Скорость ветра</td><td class="secondcol"><?= $Weatherdata['wind']['speed'] ?> м/с</td></tr>
    <tr><td class="firstcol">Направление ветра</td><td class="secondcol"><?= $Wind ?></td></tr>
</table>
<style>
    .firstcol {
        width: 300px;
        height: 30px;
        text-indent: 5px;
    }
    .secondcol {
        width: 200px;
        text-align:center;
    }
</style>
