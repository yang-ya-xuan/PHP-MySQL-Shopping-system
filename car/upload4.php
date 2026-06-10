<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>無標題文件</title>
<style type="text/css">
body {
    background-color: rgba(255,229,236,0.75);
}
</style>
</head>

<body>
	<h1 align = "center">商品資料刪除_後端</h1>
	<p align = "center"><a href="upload2.php">返回</a></p>
	
<?php
//==========後端刪除商品資料==========
	
	include("database.php");
	session_start();
	if (isset($_SESSION['caccount']))
	{
		$caccount = $_SESSION['caccount'];
	}
	if(!isset($_SESSION['caccount']))
	{
		echo "<script>alert('請先登入喔');</script>";
		echo "<script> window.location.href = 'index.php';</script>";
	}
	elseif(empty($_GET['id']))
	{
		echo "<script> alert('查無此商品'); window.location.href = 'hloginok.php'; </script>";
		exit;
	}
	
	$sql_query = "SELECT * FROM register WHERE caccount = '$caccount'";//如果使用者輸入的帳號與資料庫的帳號相等
	$result = mysqli_query($db_link, $sql_query);
	if($result)
	{
		$row = mysqli_fetch_assoc($result);
		$promotion = $row['promotion'];
	}
	
		
		if(isset($_SESSION['caccount']))//如果有帳號的話
		{
			if ($promotion === '0')//如果帳號裡面沒有@
			{
				echo "<script> alert('使用者帳號請勿登入管理員頁面');</script>";
				echo "<script> window.location.href = 'loginok.php';</script>";
			}
		}
		else
		{
			if ($promotion === '0')//如果帳號裡面沒有@
			{
				echo "<script>alert('使用者帳號請勿登入管理員頁面');</script>";
				unset($_SESSION['caccount']);
				unset($_SESSION['loginnn']);
				echo "<script> window.location.href = 'index.php';</script>";
			}
		}
	
	if(isset($_POST["action"])&&($_POST["action"]=="delete"))
	{
		//刪除商品資料庫的東西
		$sql_query = "DELETE FROM commodity WHERE cID=?";
		$stmt = $db_link -> prepare($sql_query);
		$stmt -> bind_param("i",$_POST["cID"]);
		if($stmt -> execute())
		{
			echo "<script> window.location.href = 'upload2.php'; alert('資料刪除成功');</script>";
		}
		$stmt -> close();
		//$db_link -> close();
		//header("Location: upload2.php");
		
		//如果刪除的話要改購物車的狀態
		$sql_query_ccar = "UPDATE ccar SET cdelete = 'Y' WHERE cID=?";
		$stmt_ccar = $db_link -> prepare($sql_query_ccar);
		$stmt_ccar -> bind_param("i",$_POST["cID"]);
		$stmt_ccar -> execute();
		$stmt_ccar -> close();
		$db_link -> close();
		
		//刪除購物車的東西
		/*$sql_query_ccar = "DELETE FROM ccar WHERE cID=?";
		$stmt_ccar = $db_link -> prepare($sql_query_ccar);
		$stmt_ccar -> bind_param("i",$_POST["cID"]);
		$stmt_ccar -> execute();
		$stmt_ccar -> close();
		$db_link -> close();
		header("Location: upload2.php");*/
		
		
		$db_link -> close();
	}
	
	$sql_select = "select cID, name, price, cexplain, quantity, image FROM commodity WHERE cID=?";
	//只選取符合特定 cID 的資料。
	$stmt = $db_link -> prepare($sql_select);//將語句傳遞給資料庫連接，以便後續的執行。
	$stmt -> bind_param("i",$_GET["id"]);//i：整數，這樣查詢中的 cID=? 就會被實際的 $_GET["id"] 值替換。
	$stmt -> execute();//將綁定的值插入到查詢中
	$stmt -> bind_result($cID, $name, $price, $cexplain, $quantity, $image);
	//將查詢結果的不同欄位值綁定到對應的變數中
	$stmt ->fetch();//取出資料
?>
<form method="POST" action="">
	<table border="2" align="center" style="width: 30%; border-collapse: collapse;">
	<tr style="background-color: rgba(220,232,251,0.75);">
    	<th height="40">欄位</th><th>資料</th>
	</tr>
	<tr>
		<td>名稱</td><td><?php echo $name;?></td>
	</tr>
	<tr>
		<td>價格</td><td><?php echo $price;?></td>
	</tr>
	<tr>
		<td>說明</td><td><?php echo $cexplain;?></td>
	<tr>
		<td>庫存</td><td><?php echo $quantity;?></td>
	</tr>
	</tr>
	<tr>
		<td>圖片</td><td><img src="<?php echo $image; ?>" alt="商品圖片" width="200"></td>
	</tr>
	
		
	<tr>
	<td colspan="2" align="center">
		<input name = "cID" type="hidden" value="<?php echo $cID;?>">
		<input name = "action" type="hidden" value="delete">
		<input name = "button" type="submit" value="確定刪除資料">
	</td>
	</tr>

	
</from>
	
</body>
</html>
<?php
	$stmt -> close();
    $db_link -> close();
?>