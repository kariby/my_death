<!DOCTYPE html>
<html>
<head>
	<link href="styles.css" rel="stylesheet" type="text/css">
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
	<title></title>
</head>
<body align="center" style="margin-top:30px;">
	<?php
	$q = $_GET['q'];
	$servername = "localhost";
	$username = "id16171045_user";
	$password = "%L5Ib~rowX|ta_EA";
	$database = "id16171045_test";
	if (isset($q)):
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
	if (($stmt->rowCount())>0){
	    while ($row = $stmt->fetch(PDO::FETCH_LAZY)){
	        echo "<tr>";
	        echo "<td>" . $row['result_type'] . "</td>";
	        echo "<td>" . $row['result_number'] . "</td>";
	        echo "<td>" . $row['result_res'] . "</td>";
	        echo "<td>" . $row['result_date'] . "</td>";
	        echo "</tr>";
	    }
	}
	else {
	    echo "<tr>";
	        echo "<td colspan='4'>Данных не обнаружено</td>";
	        echo "</tr>";
	}
	echo "</table>";
	else:
	?>
	<h2 align="center">Не удалось войти в личный кабинет.<br>
	Повторите попытку авторизации!</h2>
	<form action="index.php" method="post">
		<input type="submit" value="Войти в личный кабинет">
	</form><?php
	endif;    
	?>
</body>
</html>
