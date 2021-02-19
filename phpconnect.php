<!DOCTYPE html>
<html lang="ru">
<head>
	<link href="styles.css" rel="stylesheet" type="text/css">
	<title>Передача показаний приборов учета в компанию Байрам</title>
	<script>
	var str = "";
	function showUser(str) {
	   if (str == "") {
	       document.getElementById("txtHint").innerHTML = "";
	       return;
	   } else {
	       if (window.XMLHttpRequest) {
	           // код для IE7+, Firefox, Chrome, Opera, Safari
	           xmlhttp = new XMLHttpRequest();
	       } else {
	           // код для IE6, IE5
	           xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	       }
	       xmlhttp.onreadystatechange = function() {
	           if (this.readyState == 4 && this.status == 200) {
	               document.getElementById("txtHint").innerHTML = this.responseText;
	           }
	       };
	       xmlhttp.open("GET","getinfo.php?q="+str,true);
	       xmlhttp.send();
	   }
	}
	</script>
</head>
<body align="center" style="margin-top:30px;">
	<div id="min"></div><?php
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
	    }
	$flag = false;
	$id_user = array();
	$stmt = $conn->prepare('SELECT * FROM users WHERE user_login = ? AND user_password = ?');
	$stmt->execute(array($_POST['user_login'], $_POST['user_password']));
	while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
	    $flag = true;
	    $id_user = $row['user_id'];
	}
	$_monthsList = array(
	"1"=>"январь","2"=>"февраль","3"=>"март",
	"4"=>"апрель","5"=>"май", "6"=>"июнь",
	"7"=>"июль","8"=>"август","9"=>"сентябрь",
	"10"=>"октябрь","11"=>"ноябрь","12"=>"декабрь");
	$month = $_monthsList[date("n")];
	?><?php if ($flag):
	?>
	<h2>Добро пожаловать в личный кабинет!</h2>
	<h2>Внесение показаний прибора учета для субарендаторов<br>
	за месяц <u><?php echo $month; ?></u></h2><?php
	$stmt = $conn->prepare('SELECT * FROM information WHERE info_id = ?');
	$stmt->execute(array($id_user));
	while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
	    $flag = true;
	    $info_name = $row['info_name'];
	    $info_inn = $row['info_inn'];
	    $info_adress = $row['info_adress'];
	}
	?>
	<div>
		<p><b>Наименование юр.лица:</b> <?php echo $info_name; ?><br></p>
		<p><b>ИНН:</b> <?php echo $info_inn; ?><br></p>
		<p><b>Адрес объекта:</b> <?php echo $info_adress; ?><br></p>
	</div><?php
	$sql = "SELECT * FROM counters WHERE counter_id = ?";
	$stmt= $conn->prepare($sql);
	$stmt->execute(array($id_user));
	?>
	<form method="get">
		<select name="users" onchange="showUser(this.value)">
			<option value="">
				Выберите номер счетчика:
			</option><?php
			while($row = $stmt->fetch(PDO::FETCH_LAZY)){
			    $temp = $row['counter_number'];
			    $type = $row['counter_type'];
			?>
			<option data-type="&lt;?= $row['counter_type']; ?&gt;" id="option" value="<?php echo $row['counter_number']?>">
				<?php echo $row['counter_number'] ?>
			</option><?php
			}
			?>
		</select>
	</form>
	<div id="txtHint">
		<b>Информация о предыдущих введенных показаниях</b>
	</div>
	<form action="addmessage.php" id="test" method="post" name="test">
		<input name="id_user" type="hidden" value="<?php echo $id_user; ?>"> <input id="counter_number" name="counter_number" type="hidden" value=""> <input id="counter_type" name="counter_type" type="hidden" value="<?php echo $type; ?>">
		<p>Текущее показание:<br>
		<input name="result_number" size="40" style="margin-top:5px;" type="text"></p>
		<p><input type="submit" value="Передать"> <input type="reset" value="Очистить"></p>
	</form><!--
<form name="test" method="POST" action="addcounter.php">
  <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
  <input type="submit" value="Добавить новый счетчик" />
</form>
<br>
-->
	<form action="index.php" method="post">
		<input type="submit" value="Выход">
	</form>
	<script>
	    document.querySelector("body > form:nth-child(5) > select").addEventListener('input', ()=>{
	        document.querySelector("#counter_number").value = event.target.value;
	        document.querySelector("#counter_type").value = document.querySelector("body > form:nth-child(5) > select option:checked").dataset.type;

	    })
	    document.getElementById('counter_number').value = str;
	</script> <?php
	else: ?>
	<h2 align="center">Не удалось войти в личный кабинет.<br>
	Повторите попытку авторизации!</h2>
	<form action="index.php" method="post">
		<input type="submit" value="Войти в личный кабинет">
	</form><?php endif ?>
</body>
</html>
