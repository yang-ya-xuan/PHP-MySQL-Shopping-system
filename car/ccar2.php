<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>無標題文件</title>
<style type="text/css">
th, td 
{
    text-align: center;
    vertical-align: middle; /* 垂直居中對齊 */
}	
</style>
</head>

<body>
<p align = "center"><a href="ccar.php">回到購物車</a></p>
<?php
//==========修改購物車東西==========
	include("database.php");
	session_start();
	
	if (isset($_SESSION['caccount']))
	{
		$caccount = $_SESSION['caccount'];//計錄目前登入的帳號
	}
	if(!isset($_SESSION['caccount']))
	{
		echo "<script>alert('請先登入喔');</script>";
		echo "<script> window.location.href = 'index.php';</script>";
	}
	
	//如果在登入的途中被升為管理員
	$sql_query_h = "SELECT * FROM register WHERE caccount = '$caccount'";//如果使用者輸入的帳號與資料庫的帳號相等
	$result_h = mysqli_query($db_link, $sql_query_h);
	if($result_h)
	{
		$row_h = mysqli_fetch_assoc($result_h);
		if ($row_h['promotion'] === '1')//如果帳號裡面沒有@
		{
			echo "<script> alert('$caccount 被晉升為管理員，請重新登入'); window.location.href = 'index.php'; </script>";
			unset($_SESSION['caccount']);
			unset($_SESSION['loginnn']);
			return;
		}
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
			if ($promotion === '2' or $promotion === '1')//如果是管理者帳號
			{
				echo "<script> alert('管理者請勿登入使用者頁面');</script>";
				echo "<script> window.location.href = 'hloginok.php';</script>";
			}
		}
		else
		{
			if ($promotion === '2' or $promotion === '1')//如果帳號裡面沒有@
			{
				echo "<script>alert('管理者請勿登入使用者頁面');</script>";
				unset($_SESSION['caccount']);
				unset($_SESSION['loginnn']);
				echo "<script> window.location.href = 'index.php';</script>";
			}
		}
	
	//檢查資料庫看使用者有沒有被禁用
	$sql_query = "SELECT * FROM register WHERE caccount = '$caccount'";//如果使用者輸入的帳號與資料庫的帳號相等
	$result = mysqli_query($db_link, $sql_query);
	if($result)
	{
		$row = mysqli_fetch_assoc($result);
		// 如果是被禁用的人
		if ($row['disabled'] === 'N') 
		{
			echo "<script> alert('$caccount 被禁用，請聯絡管理者'); window.location.href = 'index.php'; </script>";
			unset($_SESSION['caccount']);
			unset($_SESSION['loginnn']);
			return;
		}
	}
	if(empty($_GET['id']))
	{
		echo "<script> alert('查無此商品'); window.location.href = 'ccar.php'; </script>";
		exit;
	}
	
	$sql_select = "select cID, caccount, name, price, image, quantity FROM ccar WHERE cID=? AND caccount = '$caccount'";
	//只選取符合特定 cID 的資料。
	$stmt = $db_link -> prepare($sql_select);//將語句傳遞給資料庫連接，以便後續的執行。
	$stmt -> bind_param("i", $_GET["id"]);//i：整數，這樣查詢中的 cID=? 就會被實際的 $_GET["id"] 值替換。
	$stmt -> execute();//將綁定的值插入到查詢中
	$stmt -> bind_result($cID, $caccount, $name, $price, $image, $quantity);
	//將查詢結果的不同欄位值綁定到對應的變數中
	$stmt ->fetch();//取出資料
	$stmt->close();
	
	//修改的下單數不能超過庫存
	$sql_query = "SELECT * FROM commodity WHERE cID = ?";
    $stmt = $db_link->prepare($sql_query);
    $stmt->bind_param("i", $cID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) 
	{
        $row = $result->fetch_assoc();
		$quantityc = $row["quantity"];//商品庫存
	}
?>

<form method="POST" action="">
<table border="2" align="center" style="width: 30%; border-collapse: collapse;">
		<!--外圍寬度。置中。寬度是整個頁面的70%，表格邊框合併-->
<tr style="background-color: rgba(220,232,251,0.75);">
  <th height="40">欄位</th><th>資料</th>
	</tr>
	<tr>
		<td>使用者帳號</td><td><?php echo $caccount;?></td>
	</tr>
	<tr>
		<td>商品名稱</td><td><?php echo $name;?></td>
	</tr>
	<tr>
		<td>商品價格</td><td><?php echo $price;?></td>
	<tr>
		<td>圖片</td><td><img src="<?php echo $image; ?>" alt="商品圖片" width="200"></td>
	</tr>
	</tr>
	<tr>
		<td>下單數量</td>
	  <td><input type="number" name="quantity2" value="<?php echo $quantity;?>" min="1"  max="<?=$quantityc; ?>"></td>
	</tr>
	
		
	<tr>
	<td colspan="2" align="center">
	  <input name = "revise" type="submit" value="確定修改商品數量">
	</td>
	</tr>
</from>
<?php
	if(isset($_POST['revise']))
	{
		$quantity2 = $_POST['quantity2'];
		
		$sql_query_revise = "UPDATE ccar SET quantity=? WHERE cID=? AND caccount = '$caccount'";
		$stmt_revise = $db_link->prepare($sql_query_revise);
		//更新資料庫中的 commodity 表格。(?：之後會透過綁定參數將實際的值填入)
		$stmt_revise->bind_param("ii",$quantity2 ,$_GET["id"]);
		//將這裡的值(使用者輸入)給上面的問號，就可以更新了。"ssssssi" 是指這些值的型別，其中 "s" 表示字串，"i" 表示整數。
		$stmt_revise -> execute();//將綁定的值插入到資料庫中
		$stmt_revise -> close();// 關閉已經執行的 SQL 查詢
		$db_link ->close();//關閉資料庫連接
		header("Location: ccar.php");
	}
	
?>
</body>
</html>
<?php
	
    $db_link -> close();
?>
</body>
</html>