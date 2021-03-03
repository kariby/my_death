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
function showCounters(counterType) {
    document.getElementById('all_counters').innerHTML = '<option value="">Выберите номер счетчика:</option><br>';
    if (counterType == "") {
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
              let selectedCounters = JSON.parse(this.responseText);
              console.log(selectedCounters);
              if(selectedCounters.length > 0){

                selectedCounters.forEach((item, i) => {
                  let node = '<option id="option" value="'+item.counter_number+'" data-type="'+item.counter_type+'">';
                  node += item.counter_number+'</option>';
                  document.getElementById('all_counters').innerHTML += node;
                });
                document.getElementById('after_checking_type').style.display="block";
              }
            }
        };
        let userId = document.getElementById('global_user_id').value;
        xmlhttp.open("GET","load_counters.php?q="+encodeURI(counterType)+"&userId="+userId,true);
        xmlhttp.send();
    }
}
</script>
<!-- <option id="option" value="<?php //echo $row['counter_number']?>" data-type="<?php //echo $row['counter_type']; ?>">
  <?php //echo $row['counter_number'] ?>
</option> -->
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
?>
<?php if ($flag):
?>
<div class="header">
  <h2>Внесение показаний приборов учета для субарендаторов</h2>
</div>
<?php
$stmt = $conn->prepare('SELECT info_adress FROM information WHERE info_id = ?');
$stmt->execute(array($id_user));
while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
    $flag = true;
    $info_adress = $row['info_adress'];
}
?>
<div class="row">
<div class="leftcolumn" align="center">
<div class="card">
<p><b>Адрес объекта: </b><?php echo $info_adress; ?><br></p>

<?php
$sql = "SELECT DISTINCT result_type FROM result";
$stmt= $conn->prepare($sql);
$stmt->execute(array());
?>
<p><input type="hidden" id="global_user_id" value="<?= $id_user; ?>">
  <select name="service_type" onchange="showCounters(this.value)">
  <option value="" disabled selected>Выберите тип показаний:</option>
  <?php
  while($row = $stmt->fetch(PDO::FETCH_LAZY)){
  ?>
    <option value="<?= $row['result_type'] ?>">
      <?= $row['result_type'] ?>
    </option>
  <?php
  }
  ?>
</select></p>

<div style="display: none;" id="after_checking_type">
  <form method="get">
  <select id="all_counters" name="users" onchange="showUser(this.value)">
    <option value="">Выберите номер счетчика:</option><br>
  </select>
  </form>
  <div id="txtHint"><b>Информация о предыдущих введенных показаниях</b></div>
  <div class="testtt">
  <form name="test" method="POST" action="add.php">

    <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
    <input type="hidden" name="counter_number" value="" id="counter_number">
    <input type="hidden" name="counter_type" value="<?php echo $type; ?>" id="counter_type">
    <p>Текущее показание:<br>
     <input style="margin-top:5px;" name="result_number" type="text">
    </p>
    <p><input type="submit" value="Передать">
     <input type="reset" value="Очистить"></p>
   </form>
   <form method="post" action="index.php">
      <input type="submit" value="Выход" />
  </form>
  </div>
</div>
</div>
</div>
</div>
<div class="footer">
  <h3>По любым вопросам работы сайта обращайтесь на <a href="mailto:l.kabirova@bashpost.ru">почту</a></h3>
  <h3>По вопросам начисления коммунальных услуг обращайтесь на <a href="mailto:l.kabirova@bashpost.ru">почту</a></h3>
</div>
 <script>
     document.querySelector("#all_counters").addEventListener('input', ()=>{
         document.querySelector("#counter_number").value = event.target.value;
         document.querySelector("#counter_type").value = document.querySelector("#all_counters option:checked").dataset.type;

     })
     document.getElementById('counter_number').value = str;
 </script>
<?php
else: ?>
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
</div>
<?php endif ?>
</body>
</html>
