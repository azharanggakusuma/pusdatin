<?php
$host = 'localhost';
$user = 'cirebon5';
$pass = ')6uSsP399w!TKd';
$db = 'cirebon5_pusdatin';

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}