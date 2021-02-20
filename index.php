<!DOCTYPE html>
<html>
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

<div class="header">
  <h2>Внесение показаний приборов учета для субарендаторов</h2>
</div>

<div class="row">
  <div class="leftcolumn" align="center">
    <div class="card">
      <form action="lk.php" method="post">
			<div class="fakeimg"><a href="http://batyr-rb.ru/" target="_blank"><img alt="Байрам" class="img-responsive" src="http://www.batyr-rb.ru/upload/medialibrary/8d2/8d215ee628d5b088725c24b049a8018c.png" width="200"></a></div>
			<p>Логин:<br>
			<input name="user_login" style="margin-top:5px;" type="text"></p>
			<p>Пароль:<br>
			<input name="user_password" style="margin-top:5px;" type="password"></p>
			<p><input type="submit" value="Войти"></p>
      </form>
    </div>
  </div>
</div>

<div class="footer">
  <h3>По любым вопросам работы сайта обращайтесь на <a href="mailto:l.kabirova@bashpost.ru">почту</a></h3>
</div>

</body>
</html>