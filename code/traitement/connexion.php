<?php
$dsn = "mysql:host=mysql_global;dbname=verification;charset=utf8";
$username = "root";
$password = "root";
try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    //throw $th;
    echo "ERROR" . $e->getMessage();
}
