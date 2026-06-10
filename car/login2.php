<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>無標題文件</title>
</head>

<body>
<?php
//===============按下登入按鈕後(登入的東西)===============
	session_start();
	include("database.php");
	if(isset($_SESSION['caccount']))
	{
		$url="loginok.php";
		echo "<script>alert('目前" . $_SESSION['caccount'] . "正在登入，請稍後再試');</script>";
		echo"<script>window.location.href = '$url';</script>";
	}
	else
	{
		if(isset($_POST["login"]))
		{
			

			$caccount = $_POST["caccount"];
			$cpassword = $_POST["cpassword"];

			$_SESSION['caccount'] = $caccount;
			$_SESSION['cpassword'] = $cpassword;


			$sql_query = "SELECT * FROM register WHERE caccount ='$caccount' AND cpassword ='$cpassword'";
			$result = mysqli_query($db_link, $sql_query);

			$sql_query_caccount = "select * from register WHERE caccount ='$caccount'";
			$result_caccount = mysqli_query($db_link, $sql_query_caccount);

			$sql_query_cpassword = "select * from register WHERE cpassword ='$cpassword'";
			$result_cpassword = mysqli_query($db_link, $sql_query_cpassword);

			if($caccount === '' OR $cpassword === '')
			{

				echo "<script>alert('請確實填寫註冊資料'); window.location.href = 'login.php';</script>";
				//顯示錯誤，並且將頁面重新導入register.php裡面
				unset($_SESSION['caccount']);
				return;
			}

			if(mysqli_num_rows($result) == 0)//如果帳號跟密碼沒找到一樣的
			{
				if (mysqli_num_rows($result_caccount) == 0) //如果帳號錯誤
				{
					echo"<script>alert('找不到此帳號'); window.location.href = 'login.php';</script>";
				}
				if (mysqli_num_rows($result_cpassword) == 0) //如果密碼錯誤
				{
					echo"<script>alert('密碼錯誤'); window.location.href = 'login.php';</script>";
				}
				echo"<script>alert('帳號密碼請輸入正確'); window.location.href = 'login.php';</script>";
				//如果輸入資料庫有的資料但兩個是不一樣的話，不會顯示(兩個不一樣的意思是 a帳號對上b密碼)
				return;
			}

			//後端
			if (strpos($caccount, '@admin') !== false)
			{
				echo"<script>alert('後端登入成功'); window.location.href = 'hloginok.php';</script>";
			}

			else
			{
				//如果上面都對
				echo"<script>alert('登入成功'); window.location.href = 'index.php';</script>";
			}
		}
	}
	
	if(!isset($_SESSION['caccount']))
	{
		echo"<script>alert('請先登入帳號'); window.location.href = 'index.php';</script>";
	}
	
?>
</body>
</html>