<!DOCTYPE html>
<html lang="ru ">
<?php

class DataBase {
	private $server;
	private $username;
	private $password;
	private $dbname;
	private $table;

	function __construct ($server,$username,$password,$dbname,$table){
		$this->server = $server;
		$this->username = $username;
		$this->password = $password;
		$this->dbname = $dbname;
		$this->table = $table;
	}

	function GetServer () {
		return $this->server;
	}

	function GetUsername () {
		return $this->username;
	}

	function GetPassword () {
		return $this->password;
	}

	function GetDbName () {
		return $this->dbname;
	}

	function GetTable () {
		return $this->table;
	}

	function SetServer ($server) {
		if (mb_strlen($server) > 0) {
			$this->server = $server;
		}
	}

	function SetUsername ($username) {
		if (mb_strlen($username) > 0) {
			$this->username = $username;
		}
	}

	function SetPassword ($password) {
		if (mb_strlen($password) > 0) {
			$this->password = $password;
		}
	}

	function SetDbName ($dbname) {
		if (mb_strlen($dbname) > 0) {
			$this->dbname = $dbname;
		}
	}

	function SetTable ($table) {
		if (mb_strlen($table) > 0) {
			$this->table = $table;
		}
	}

	function Connect () {
		return new mysqli($this->server,$this->username,$this->password,$this->dbname);
	}

	function __destruct () {}
}

function btw($b1) {
        $b1 = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $b1);
        $b1 = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $b1);
        return $b1;
    }

$charset = "UTF8";
$CookBookBase = new DataBase($_SERVER['SERVER_ADDR'],"root","root","CookBook","book");

$Recipe = filter_var(trim($_POST['Recipe']),FILTER_SANITIZE_STRING);
$Name = filter_var(trim($_POST['Name']),FILTER_SANITIZE_STRING);
$Text = filter_var(trim($_POST['Text']),FILTER_SANITIZE_STRING);
$File = $_FILES['Image']['tmp_name'];
$Ingredients = btw(filter_var(trim($_POST['Ingredients']),FILTER_SANITIZE_STRING));

$ErrorMessage = "<script>alert('Не верный ввод');</script>";
$CorrectMessage = "<script>
					const result = confirm('Рецепт добавлен. Вернуться?');
					if (result){
							document.location.replace(\"index.php\");
						}
				</script>";
?>
<head>
	<meta charset="utf-8">
	<title>AddForm</title>
	<link rel="stylesheet" type="text/css" href="styles/regstyle.css">
</head>
<body>
	<form action="addrec.php" method="post" enctype="multipart/form-data">
		<h1>Добавить рецепт</h1> 
		<div>
			<label class="maintxt">Название рецепта</label> <br><br>
			<input class="inputtxt" type="text" name="Recipe">
		</div>
		<div>
			<label class="maintxt">Имя автора</label> <br><br>
			<input class="inputtxt" type="text" name="Name">
		</div>
		<div>
			<label class="maintxt">Изображение</label> <br><br>
			<input class="inputtxt" type="file" accept="image/*" name="Image"> 
		</div> <br>
		<div>
			<label class="maintxt">Ингридиенты (через запятую)</label> <br><br>
			<textarea class="inputtxt" name="Ingredients"></textarea>
		</div>
		<div>
			<label class="maintxt">Текст рецепта</label> <br><br>
			<textarea class="inputtxt" name="Text"></textarea>
		</div>
		<div>
			<input class="maintxt" type="submit" value="Отправить рецепт" name="upload">
		</div>
<?php
if (!empty($File)) {
$Image = addslashes(file_get_contents($File));
}

$connection = $CookBookBase->Connect();

if ($connection->connect_error) {
	die("CONNECTION_ERROR".$connection->connect_error);
}

if (!$connection->set_charset($charset)) {
	echo "CHARSET_ERROR";
}
if (isset($_POST['upload'])){
	if (mb_strlen($Name) > 0 && mb_strlen($Name) < 30 && mb_strlen($Recipe) > 0 && mb_strlen($Recipe) < 50 && mb_strlen($Text) > 0 && mb_strlen($Text) < 10000 && mb_strlen($Text) > 0 && mb_strlen($Text) < 4294967295 && mb_strlen($Ingredients) > 0 && mb_strlen($Ingredients) < 1000)
	{
		$connection->query("INSERT INTO `book` (`Recipe`,`Name`,`Image`,`Text`,`Ingredients`) VALUES ('$Recipe','$Name','$Image','$Text','$Ingredients')");
		echo $CorrectMessage;
	} 
	else 
	{
		echo $ErrorMessage;
	}
}
?>
		</div> 
	</form>
</body>
</html>