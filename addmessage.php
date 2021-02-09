<!DOCTYPE html>
<html lang="ru">
<head>
<link rel="stylesheet" type="text/css" href="styles.css">
<title>Передача показаний приборов учета в компанию Байрам</title>
</head>
<body align="center" style="margin-top:30px;">
<?php
$servername = "localhost";
$username = "id15961621_user";
$password = "(v)hglN9YfsE0&1f";
$database = "id15961621_bd_test20012021";
try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } 
catch(PDOException $e) { 
    echo "Не удалось подключиться к БД. Попробуйте повторить попытку позднее <br>";
    }
$result_id = (int)$_POST['id_user'];
$result_type = $_POST['counter_type'];
$result_number = $_POST['counter_number'];
$result_res = (int)$_POST['result_number'];
$result_date = date_create('now')->format('Y-m-d H:i:s');
$sqli = "SELECT * FROM result WHERE result_id = ? ORDER BY result_date DESC LIMIT 1";
$stmt= $conn->prepare($sqli);
$stmt->execute([$result_id]);
//если таблица не пустая
if (($stmt->rowCount()) > 0) {
    //для каждого столбца таблицы result - я думаю нужно это будет удалить, у нас таблица result теперь из одной строки
    foreach ($stmt as $row) {
        if ($row['result_res']>=$result_res) {
            echo "<h2>Внимание! Текущие показания меньше или равны <br>показаниям за предыдущие месяцы. <br>Повторите ввод корректных показаний<br></h2>";
                echo "<p><input type='submit' onclick='history.back();' value='Ввести показания'/></p>";
        break;
        }
        //если все показания в норме, то запишем их
        else {
            $sql = "INSERT INTO result (result_id, result_type, result_number, result_res, result_date) VALUES (?,?,?,?,?)";
            $stmt= $conn->prepare($sql);
            $stmt->execute([$result_id, $result_type, $result_number, $result_res, $result_date]);
            echo "<h2>Показания внесены успешно, спасибо!<br></h2>";
            break;
        }
    }
}
//если таблица пустая, то никаких проверок не нужно, забиваем сразу показания
else {
    $sql = "INSERT INTO result (result_id, result_type, result_number, result_res, result_date) VALUES (?,?,?,?,?)";
    //проверка чтоб все показания были больше 0
    if ($result_res>0) {
        $stmt= $conn->prepare($sql);
        $stmt->execute([$result_id, $result_type, $result_number, $result_res, $result_date]);
        echo "<h2><b>Показания внесены успешно, спасибо!</b></h2>";
    }
    else{
        echo "<h2><b>Вы не ввели никаких данных! <br>Вернитесь назад и повторите попытку </b><br></h2>";
        echo "<p><input type='submit' onclick='history.back();' value='Ввести показания'/></p>";
    }
}
?>
<br>
<input type="submit" onclick='history.back();' value='Назад'/>
<form method="post" action="index.php">
    <br><input type="submit" value="Выход" />
</form>    
</body>