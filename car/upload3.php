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
	<h1 align = "center">商品資料修改_後端</h1>
	<p align = "center"><a href="upload2.php">返回</a></p>
<?php
//==========後端修改商品資料==========
	include("database.php");
	
	
	
	$sql_select = "select cID, name, price, cexplain, quantity, ud FROM commodity WHERE cID=?";
	//只選取符合特定 cID 的資料。
	$stmt = $db_link -> prepare($sql_select);//將語句傳遞給資料庫連接，以便後續的執行。
	$stmt -> bind_param("i",$_GET["id"]);//i：整數，這樣查詢中的 cID=? 就會被實際的 $_GET["id"] 值替換。
	$stmt -> execute();//將綁定的值插入到查詢中
	$stmt -> bind_result($cID, $name, $price, $cexplain, $quantity, $ud);
	//將查詢結果的不同欄位值綁定到對應的變數中
	$stmt ->fetch();//取出資料
	$stmt->close();
?>
<form method="POST" action="">
	名稱：
	<input type = "text" name = "fname" value="<?php echo $name;?>">
	<br/>
	<br/>
	價格：
	<input type= "number" name="fprice" value="<?php echo $price;?>">
	<br/>
	<br/>
	說明： 
	<br/>
	<textarea name="fcexplain" rows="4" cols="27"><?php echo $cexplain; ?></textarea>
	<br/>
	<br/>
	庫存：
	<input type= "number" name="fquantity" value="<?php echo $quantity;?>">
	<br/>
	<br/>
	狀態：   
	<input type="radio" name="fud" value="up" <?php if ($ud=="up") echo"checked";?>> 上架
	<input type="radio" name="fud" value="down" <?php if ($ud=="down") echo"checked";?>> 下架
	<br/>
	<br/>
	<input name = "renew" type="submit" value="更新資料">
</from>

<?php
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
	
	if(isset($_POST['renew']))//按下更新資料
	{
		//更新商品資料庫的東西
		$sql_query = "UPDATE commodity SET name=?, price=?, cexplain=?, quantity=?, ud=? WHERE cID=?";
		$stmt = $db_link -> prepare($sql_query);
		//更新資料庫中的 commodity 表格。(?：之後會透過綁定參數將實際的值填入)
		$stmt -> bind_param("sisisi",$_POST["fname"],$_POST["fprice"],$_POST["fcexplain"], $_POST["fquantity"] , $_POST["fud"],$_GET["id"]);
		//將這裡的值(使用者輸入)給上面的問號，就可以更新了。"ssssssi" 是指這些值的型別，其中 "s" 表示字串，"i" 表示整數。
		
		$fname = $_POST["fname"];
		$fprice = $_POST["fprice"];
		$fcexplain = $_POST["fcexplain"];
		$fquantity = $_POST["fquantity"];
		$fud = $_POST["fud"];
		if($fquantity == 0)
		{
			echo "<script>window.location.href = 'upload2.php'; alert('庫存不能等於0'); </script>";
			return;
		}
		if($fname == $name && $fprice == $price && $fcexplain == $cexplain && $fquantity == $quantity && $fud == $ud)
		{
			echo "<script>window.location.href = 'upload2.php'; alert('資料尚未更新'); </script>";
		}
		if($stmt -> execute())
		{
			echo "<script> window.location.href = 'upload2.php'; alert('資料更新成功');</script>";
		}
		
		$stmt -> close();// 關閉已經執行的 SQL 查詢
		//$db_link ->close();//關閉資料庫連接
		
		//如果更新的話，也要購物車的資料
		$sql_query_ccar = "UPDATE ccar SET name=?, price=?, ud=? WHERE cID=?";
		$stmt_ccar = $db_link -> prepare($sql_query_ccar);
		//更新資料庫中的 commodity 表格。(?：之後會透過綁定參數將實際的值填入)
		$stmt_ccar -> bind_param("sisi",$_POST["fname"],$_POST["fprice"], $_POST["fud"],$_GET["id"]);
		$stmt_ccar -> execute();
		$stmt_ccar -> close();// 關閉已經執行的 SQL 查詢
		//$db_link ->close();//關閉資料庫連接
		
		//如果輸入價格不等於資料庫的價格，就代表有更改價格
		if($fprice != $price)
		{
			$sql_query_pricec = "UPDATE ccar SET pricec = 'C' WHERE cID=?";
			$stmt_pricec = $db_link -> prepare($sql_query_pricec);
			//更新資料庫中的 commodity 表格。(?：之後會透過綁定參數將實際的值填入)
			$stmt_pricec -> bind_param("i",$_GET["id"]);
			$stmt_pricec -> execute();
			$stmt_pricec -> close();// 關閉已經執行的 SQL 查詢
			//$db_link ->close();//關閉資料庫連接
		}
	}
	
	/*if($ud === 'up')//如果目前商品是上架的，就要有下架按紐
	{
		?>
		<form method="POST" action="">
		<input name = "down" type="submit" value="下架">
		</from>
		<?php
	}
	elseif($ud === 'down')//如果目前世下架的，要有上架按紐
	{
		?>
		<form method="POST" action="">
		<input name = "up" type="submit" value="上架">
		</from>
		<?php
	}*/
	
	//如果下架商品
	/*if(isset($_POST['down']))
	{
		$update_query = "UPDATE commodity SET ud = 'down' WHERE cID = ?";
    	$update_stmt = $db_link->prepare($update_query);
    	$update_stmt->bind_param("i", $_GET["id"]);
		
		if ($update_stmt->execute())
		{
			echo"<script> alert('$name 下架成功');</script>";
		}
		else
		{
			echo"<script> alert('$name 下架失敗');</script>";
		}
		$update_stmt->close();
		header("Location: upload2.php");
		
		//要刪除購物車裡面的那項資料
		$sql_query_ccar = "DELETE FROM ccar WHERE cID=?";
		$stmt_ccar = $db_link -> prepare($sql_query_ccar);
		$stmt_ccar -> bind_param("i", $_GET["id"]);
		$stmt_ccar -> execute();
		$stmt_ccar -> close();
		//$db_link -> close();
		//header("Location: upload2.php");
		
		//更改購物車上下架的狀態
		/*$sql_query_down = "UPDATE ccar SET ud = 'down' WHERE cID=?";
		$stmt_down = $db_link->prepare($sql_query_down);
		$stmt_down->bind_param("i", $_GET["id"]);
		$stmt_down->execute();
		$stmt_down->close();
	}*/
	
	//如果上架商品
	/*if(isset($_POST['up']))
	{
		$update_query = "UPDATE commodity SET ud = 'up' WHERE cID = ?";
    	$update_stmt = $db_link->prepare($update_query);
    	$update_stmt->bind_param("i", $_GET["id"]);
		if ($update_stmt->execute())
		{
			echo"<script> alert('$name 上架成功');</script>";
		}
		else
		{
			echo"<script> alert('$name 上架失敗');</script>";
		}
		$update_stmt->close();
		header("Location: upload2.php");
		
		/*$sql_query_up = "UPDATE ccar SET ud = 'up' WHERE cID=?";
		$stmt_up = $db_link->prepare($sql_query_up);
		$stmt_up->bind_param("i", $_GET["id"]);
		$stmt_up->execute();
		$stmt_up->close();
	}*/
?>
</body>
</html>
<?php
	//$stmt -> close();
    //$db_link -> close();
?>