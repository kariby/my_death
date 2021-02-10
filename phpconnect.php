<!DOCTYPE html>
<html lang="ru">
<head>
 <link rel="stylesheet" type="text/css" href="styles.css">
 <title>Передача показаний приборов учета в компанию Байрам</title>
</head>
<script>
var str = "";
window.onpopstate = function () {
    alert('zdes'); //не работает
}
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
<body align="center" style="margin-top:30px;">
<div id="min"></div>
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
?>
<h2>Добро пожаловать в личный кабинет!</h2>
<h2>Внесение показаний прибора учета для субарендаторов <br>за месяц <u><?php echo $month; ?></u></h2>
<?php
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
<p><b>Наименование юр.лица: </b><?php echo $info_name; ?><br></p>
<p><b>ИНН: </b><?php echo $info_inn; ?><br></p>
<p><b>Адрес объекта: </b><?php echo $info_adress; ?><br></p>
</div>
<?php if ($flag):
$sql = "SELECT * FROM counters WHERE counter_id = ?";
$stmt= $conn->prepare($sql);
$stmt->execute(array($id_user));
?>
<form method="get">
<select name="users" onchange="showUser(this.value)">
<option value="">Выберите номер счетчика:</option><br>
<?php
while($row = $stmt->fetch(PDO::FETCH_LAZY)){
    $temp = $row['counter_number'];
    $type = $row['counter_type'];
?>
    <option id="option" value="<?php echo $row['counter_number']?>" data-type="<?= $row['counter_type']; ?>"><?php echo $row['counter_number'] ?></option> </p>
<?php
}
?>
</select>
</form>
<div id="txtHint"><b>Информация о предыдущих введенных показаниях будет указана тут...</b></div>
<form name="test" method="POST" action="addmessage.php">

  <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
  <input type="hidden" name="counter_number" value="" id="counter_number">
  <input type="hidden" name="counter_type" value="<?php echo $type; ?>" id="counter_type">
  <p>Текущее показание:<br>
   <input style="margin-top:5px;" name="result_number" type="text" size="40">
  </p>
  <p><input type="submit" value="Передать">
   <input type="reset" value="Очистить"></p>
 </form>
 <script>
     document.querySelector("body > form:nth-child(5) > select").addEventListener('input', ()=>{
         document.querySelector("#counter_number").value = event.target.value;
         document.querySelector("#counter_type").value = document.querySelector("body > form:nth-child(5) > select option:checked").dataset.type;

     })
     document.getElementById('counter_number').value = str;
 </script>
<?php
else: ?>
<h2 align="center">Неправильный логин или пароль. Повторите попытку авторизации!</h2>
<p><input type="submit" onclick="history.back();" value="Войти в личный кабинет"/></p>
<?php endif ?>
</body>
</html>
