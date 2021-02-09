<!DOCTYPE html>
<html>
<head>
<style>
table {
    width: 50%;
    border-collapse: collapse;
    margin-left:auto; 
    margin-right:auto;
}

table, td, th {
    border: 1px solid black;
    padding: 5px;
}

th {
    text-align: center;
}
</style>
</head>
<body>

<?php
$q = $_GET['q'];
$servername = "localhost";
$username = "id15961621_user";
$password = "(v)hglN9YfsE0&1f";
$database = "id15961621_bd_test20012021";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } 
catch(PDOException $e) { 
    echo "Не удалось подключиться к БД. Попробуйте повторить попытку позднее ";
    }
$stmt = $conn->prepare('SELECT * FROM result WHERE result_number = ? ORDER BY result_date DESC LIMIT 1');
$stmt->bindValue(1, $q, PDO::PARAM_STR);
$stmt->execute();
echo "<table><br>
<tr>
<th>Тип счетчика</th>
<th>Номер счетчика</th>
<th>Предыдущее показание</th>
<th>Дата ввода показания</th>
</tr>";

while ($row = $stmt->fetch(PDO::FETCH_LAZY)){
    echo "<tr>";
    echo "<td>" . $row['result_type'] . "</td>";
    echo "<td>" . $row['result_number'] . "</td>";
    echo "<td>" . $row['result_res'] . "</td>";
    echo "<td>" . $row['result_date'] . "</td>";
    echo "</tr>";
}
echo "</table>";
?>
</body>
</html>