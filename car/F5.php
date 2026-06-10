<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>無標題文件</title>
</head>

<body>
<?php
	//session_start();
	$code = mt_rand(0,1000000);
	$_SESSION['code'] = $code;
?>
<form action="F52.php" method="POST">
	<input type="submit">
	<input type = "hidden" name = "code" value="<?php echo $code;?>">
</form>
</body>
</html>