<!DOCTYPE html>
<html lang="ru">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Передача показаний приборов учета в компанию Байрам</title>
<style>
* {
    box-sizing: border-box;
}

input[type=text], input[type=password], select, textarea {
	padding: 12px;
	border: 1px solid #ccc;
	border-radius: 4px;
	resize: vertical;
}

input[type=submit], input[type=reset] {
	background-color: #4CAF50;
	color: white;
	padding: 12px 20px;
	border: none;
	border-radius: 4px;
	cursor: pointer;
}
input[type=submit], input[type=reset]:hover {
	background-color: #45a049;
}

/* Add a gray background color with some padding */
body {
    font-family: Arial;
    padding: 20px;
    background: #f1f1f1;
}

.header {
    padding: 10px;
    text-align: center;
    background: white;
}

.leftcolumn {   
    float: left;
    width: 100%;
}

/* Fake image */
.fakeimg {
  width: 100%;
  padding: 20px;
}

.card {
     background-color: white;
     padding: 20px;
     margin-top: 20px;
}

/* Clear floats after the columns */
.row:after {
    content: "";
    display: table;
    clear: both;
}

/* Footer */
.footer {
    padding: 20px;
    text-align: center;
    background: #ddd;
    margin-top: 20px;
}

@media screen and (max-width: 800px) {
    .leftcolumn{   
        width: 100%;
        padding: 0;
    }
}
</style>
</head>
<body>
	<?php
	$servername = "localhost";
	$username = "id16171045_user";
	$password = "%L5Ib~rowX|ta_EA";
	$database = "id16171045_test";
	try {
	    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    }
	catch(PDOException $e) {
	    echo "Не удалось подключиться к БД. Попробуйте повторить попытку позднее <br>";
	    }
	$result_id = (int)$_POST['id_user'];
	if ($result_id >0):
	//этот код чтобы вернуться назад - ужас
	$sqli = "SELECT * FROM users WHERE user_id = ? LIMIT 1";
	$stmt= $conn->prepare($sqli);
	$stmt->execute(array($result_id));
	if (($stmt->rowCount())>0) {
	    while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
	        $log = $row['user_login'];
	        $pass = $row['user_password'];
	    }
	}
	?>
	<div class="header">
        <h2>Внесение показаний приборов учета для субарендаторов</h2>
    </div>
    <div class="row">
    <div class="leftcolumn" align="center">
    <div class="card">
	<form action="lk.php" method="post">
		<?php 
		    echo '<input type="hidden" name="user_login" value="'. $log .'">';
		    echo '<input type="hidden" name="user_password" value="'. $pass .'">';
		    ?><input type="submit" value="Назад">
	</form><?php
	//ужас закончился :)
	
	$result_type = $_POST['counter_type'];
	$result_number = $_POST['counter_number'];
	$result_res = (int)$_POST['result_number'];
	$result_date = date_create('now')->format('Y-m-d H:i:s');
	$sqli = "SELECT * FROM result WHERE result_id = ? AND result_number = ? ORDER BY result_date DESC LIMIT 1";
	$stmt= $conn->prepare($sqli);
	$stmt->execute([$result_id, $result_number]);
	//если таблица не пустая
	if (($stmt->rowCount()) > 0) {
	    //для каждого столбца таблицы result - я думаю нужно это будет удалить, у нас таблица result теперь из одной строки
	    foreach ($stmt as $row) {
	        if (($row['result_res'] >= $result_res) or (empty($result_number))) {
	            echo "<p><b>Произошла ошибка при вводе данных. Повторите ввод корректных показаний</b></p>";
	            break;
	        }
	        //если все показания в норме, то запишем их
	        else {
	            $sql = "INSERT INTO result (result_id, result_type, result_number, result_res, result_date) VALUES (?,?,?,?,?)";
	            $stmt= $conn->prepare($sql);
	            $stmt->execute([$result_id, $result_type, $result_number, $result_res, $result_date]);
	            echo "<p><b>Показания внесены успешно, спасибо!</b></p>";
	            break;
	        }
	    }
	}
	//если таблица пустая, то никаких проверок не нужно, забиваем сразу показания
	else {
	    $sql = "INSERT INTO result (result_id, result_type, result_number, result_res, result_date) VALUES (?,?,?,?,?)";
	    //проверка чтоб все показания были больше 0
	    if (($result_res>0) and (!empty($result_number))) {
	        $stmt= $conn->prepare($sql);
	        $stmt->execute([$result_id, $result_type, $result_number, $result_res, $result_date]);
	        echo "<p><b>Показания внесены успешно, спасибо!</b></p>";
	    }
	    else{
	        echo "<p><b>Произошла ошибка при вводе данных. Повторите ввод корректных показаний</b></p>";
	    }
	}
	?>
	<form action="index.php" method="post">
		<input type="submit" value="Выход">
	</form>
	</div>
	</div>
	</div>
	<div class="footer">
    <h3>По любым вопросам работы сайта обращайтесь на <a href="mailto:l.kabirova@bashpost.ru">почту</a></h3>
    <h3>По вопросам начисления коммунальных услуг обращайтесь на <a href="mailto:l.kabirova@bashpost.ru">почту</a></h3>
    </div>
	<?php
	else:
	?>
	<div class="header">
  <h2>Внесение показаний приборов учета для субарендаторов</h2>
</div>
<div class="row">
<div class="leftcolumn" align="center">
<div class="card">
<p><b>Не удалось войти в личный кабинет. Повторите попытку авторизации!</b></p>
<form method="post" action="index.php"><input type="submit" value="Войти в личный кабинет"/></form>
</div>
</div>
</div>
<div class="footer">
  <h3>По любым вопросам работы сайта обращайтесь на <a href="mailto:l.kabirova@bashpost.ru">почту</a></h3>
  <h3>По вопросам начисления коммунальных услуг обращайтесь на <a href="mailto:l.kabirova@bashpost.ru">почту</a></h3>
</div><?php
	endif;
	?>
</body>
</html>