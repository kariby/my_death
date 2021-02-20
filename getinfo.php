<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
<title>Передача показаний приборов учета в компанию Байрам</title>
	<style>
table.table-3 {
    border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
}
table.table-3 tr {
		background-color: #f8f8f8;
		text-align: center;
}

table.table-3 th,
table.table-3 td {
	text-align: center;
	padding: 8px;
	border: 1px solid #ddd;
}
@media screen and (max-width: 600px) {
  	table.table-3 {
		border: 0;
  	}

  
  
  	table.table-3 thead {
	    border: none;
	    clip: rect(0 0 0 0);
	    height: 1px;
	    margin: -1px;
	    overflow: hidden;
	    padding: 0;
	    position: absolute;
	    width: 1px;
  	}
  
  	table.table-3 tr {
    	border-bottom: 1px solid #ddd;
    	display: block;
  	}
  
	table.table-3 td {
    	display: block;
    	text-align: right;
	}
  
	table.table-3 td::before {
	    content: attr(data-label);
	    float: left;
	    font-weight: bold;
	    text-transform: uppercase;
	}
  
  	table.table-3 td:last-child {
    	border-bottom: 0;
  	}
}
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
	<title></title>
</head>
<body align="center">
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
	echo "<table class='table-3'><br>
	<thead>
	<tr>
	<th>Тип счетчика</th>
	<th>Номер счетчика</th>
	<th>Предыдущее показание</th>
	<th>Дата ввода показания</th>
	</tr></thead><tbody>";
	if (($stmt->rowCount())>0){
	    while ($row = $stmt->fetch(PDO::FETCH_LAZY)){
	        echo "<tr>";
	        echo "<td data-label='Тип'>" . $row['result_type'] . "</td>";
	        echo "<td data-label='Номер'>" . $row['result_number'] . "</td>";
	        echo "<td data-label='Пред. показ.'>" . $row['result_res'] . "</td>";
	        echo "<td data-label='Дата'>" . $row['result_date'] . "</td>";
	        echo "</tr>";
	    }
	    echo "</tbody>";
	}
	else {
	    echo "<tr>";
	    echo "<td colspan='4' align='center' data-label='Пред. показ.'>Данных нет</td>";
	    echo "</tr>";
	    echo "</tbody>";
	}
	echo "</table>";
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
</div><?php
	endif;    
	?>
</body>
</html>