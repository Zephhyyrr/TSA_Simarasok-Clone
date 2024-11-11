<?php

$server = "10.20.29.222";
$user = "pbl";
$password = "nMMiTWLSItMZNrvUsDbZGKscuWgwrNr2HrkVlfHhN";
$nama_database = "laravel";
$db = mysqli_connect($server, $user, $password, $nama_database);

date_default_timezone_set('Asia/Jakarta');
$tgl_ = date('Y-m-d H:i:s');


$winddirection = $_GET['winddirection'] ?? 0;
$windspeedavg = $_GET['windspeedavg'] ?? 0;
$windspeedmax = $_GET['windspeedmax'] ?? 0;
$airtemperature = $_GET['airtemperature'] ?? 0;
$rainintensity1h = $_GET['rainintensity1h'] ?? 0;
$rainintensity1d = $_GET['rainintensity1d'] ?? 0;
$airhumidity = $_GET['airhumidity'] ?? 0;
$airpressure = $_GET['airpressure'] ?? 0;
$raindropstatus = $_GET['lightintensity'] ?? 0;
$lightintensity = $_GET['lightintensity'] ?? 0;
$raindropintensity = $_GET['raindropintensity'] ?? 0;
$uvintensity = $_GET['uvintensity'] ?? 0;
$uvindex = $_GET['uvindex'] ?? 0;

$sql = "INSERT INTO data_sensor
        VALUES
        (NULL,
        '$tgl_',
        $winddirection,
        $windspeedavg,
        $windspeedmax,
        $airtemperature,
        $rainintensity1h,
        $rainintensity1d,
        $airhumidity,
        $airpressure,
        $lightintensity,
        $raindropstatus,
        $raindropintensity,
        $uvintensity,
        $uvindex, '$tgl_', '$tgl_'
        )";

mysqli_query($db,$sql);







