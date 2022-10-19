<!DOCTYPE html>
<html>
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

function DeCode($Ingredients) {
	$DecodedIngredients = explode(',', "$Ingredients");
	return $DecodedIngredients;
	}
 ?>
<head>
<title>CookBook.com</title>
<link rel="icon" type="image/png" href="image/favicon.ico" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="styles/style.css">
<script src="scripts/sessions.js"></script>
</head>
<body class="body">
<header class="header">
<h1 align="left" class="h1text">CookBook</h1>
<a href="addrec.php" style = "margin-left:20px; ">Добавить рецепт</a>
</header>
<br>
<center>
	<form action="index.php" method="post" enctype="multipart/form-data">
	<div>
		Поиск по ингридиентам <br>
		<input type="search" name="search">
		<br> <input type="submit" name="searchButton" value="Найти">
	</div>
	</form>
	<?php
$Search = filter_var(trim($_POST['search']),FILTER_SANITIZE_STRING);

$CookBookBase = new DataBase($_SERVER['SERVER_ADDR'],"root","root","CookBook","book");
$charset = 'utf8';

$connection = new mysqli($CookBookBase->GetServer(),$CookBookBase->GetUsername(),$CookBookBase->GetPassword(),$CookBookBase->GetDbName());
$res = $connection->query("SELECT * FROM `book` ORDER BY 'ID' DESC");
$connection->close();
if (empty($Search)) {


while ($row = $res->fetch_assoc())
{
echo "<br> <p class = \"modle\"> <a style = \"font-size: 24px;\">";
echo $row['Recipe'];
echo "</a>";
echo "<br>";
echo "<br>";
$DecodedIngredients = DeCode($row['Ingredients']);
foreach ($DecodedIngredients as $rowI) {
	echo $rowI . "<br>\r\n";
}
echo "<br><br>";
echo "<a style = \"font-size: 18px;\">";
echo $row['Text'];
echo "</a>";
echo "<br>";
$ShowImage =  base64_encode($row['Image']);
$Name = $row['Name'];
?> <img width="600" src="data:image/jpeg;base64, <?php echo $ShowImage ?>" alt="Нет изображения"> <?php

echo "<a>$Name</a>";
echo "</p>";
	}
} else {
	$Counter = 0;
	while ($row = $res->fetch_assoc())
{
$DecodedIngredients = DeCode($row['Ingredients']);
foreach ($DecodedIngredients as $rowI) {
	$pos = strpos($rowI, $Search);
	if ($pos != false) {
		$SearchFlag = true;
		break;
	}
}
if ($SearchFlag) { 
echo "<br> <p class = \"modle\"> <a style = \"font-size: 24px;\">";
echo $row['Recipe'];
echo "</a>";
echo "<br>";
echo "<br>";
foreach ($DecodedIngredients as $rowI) {
	echo $rowI . "<br>\r\n";
}
echo "<br><br>";
echo "<a style = \"font-size: 18px;\">";
echo $row['Text'];
echo "</a>";
echo "<br>";
$ShowImage =  base64_encode($row['Image']);
$Name = $row['Name'];
?> <img width="600" src="data:image/jpeg;base64, <?php echo $ShowImage ?>" alt="Нет изображения"> <?php

echo "<a>$Name</a>";
echo "</p>";
	}
	$SearchFlag = false;
}
	if ($Counter == 0){
	echo "Ничего не найдено";
	}
}
	 ?>
	</center>

<footer class="footer">
	<hr class="hr">
  <p>Почта: <a href="mailto:sudaeto@yandex.ru">sudaeto@yandex.ru</a></p>
  <p id="phpsender"></p>
</footer>
</body>
</html>