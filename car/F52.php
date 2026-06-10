<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>無標題文件</title>
</head>

<body>
<?php
	//session_start();
	
	if(isset($_POST['code']))
	{
		if($_POST['code'] == $_SESSION['code'])
		{
			$_SESSION['code']="";
			echo"第一次提交表單";
		}
		else
		{
			echo"重新整理頁面";
		}
	}
?>
</body>
</html>