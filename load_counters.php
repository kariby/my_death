<?php

if($_GET['q'] == '' or $_GET['userId'] == '') { exit; }
$servername = "localhost";
$username = "id16171045_user";
$password = "%L5Ib~rowX|ta_EA";
$database = "id16171045_test";
try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
catch(PDOException $e) {
    echo "Не удалось подключиться к БД. Попробуйте повторить попытку позднее ";
    exit;
    }

$counter_type = $_GET['q'];
$id_user = $_GET['userId'];

$sql = "SELECT * FROM counters WHERE counter_id = ? AND counter_type = ?";
$stmt= $conn->prepare($sql);
$stmt->execute(array($id_user, $counter_type));
// print_r($stmt->fetchAll());
echo json_encode($stmt->fetchAll(), JSON_UNESCAPED_UNICODE);
?>