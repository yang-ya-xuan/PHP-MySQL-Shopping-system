<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>無標題文件</title>
<style type="text/css">
body {
    background-color: rgba(237,235,235,0.75);
}
</style>
</head>

<body>
	<h1 align = "center">購物車_後端</h1>
	<p align = "center"><a href="hloginok.php">回到首頁</a></p>
<?php
	include("database.php");
	$sql_query_order = "SELECT * FROM ccar ORDER BY caccount"; // 根據 caccount 排序
	$result_order = $db_link->query($sql_query_order);
?>

<table border="2" align="center" style="width: 70%; border-collapse: collapse;">
<!--外圍寬度。置中。寬度是整個頁面的70%，表格邊框合併-->
  	<tr style="background-color: rgba(220,232,251,0.75);">
    	<th height="40">使用者帳號</th>
		<th>商品名稱</th>
		<th>商品價格</th>
		<th>下單數量</th>
		<th>原因</th>
	</tr>

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
	
	$currentAccount = null; // 用於追蹤當前使用者帳號

	while ($row = mysqli_fetch_assoc($result_order)) 
	{
		if ($currentAccount !== $row['caccount']) //如果上一次的帳號，不等於現在的帳號的話
		{
			$currentAccount = $row['caccount'];//就把現在的帳號給$currentAccount
			echo '<tr style="border-top: 2px solid black;"><td colspan="5"><strong>使用者帳號: ' . $currentAccount . '</strong></td></tr>';
		}

		echo '<tr>';
		echo '<td>' . $row['caccount'] . '</td>';
		echo '<td>' . $row['name'] . '</td>';
		echo '<td>' . $row['price'] . '</td>';
		echo '<td>' . $row['quantity'] . '</td>';
		if($row['ud'] === 'down')
		{
			echo '<td>' . '目前商品下架，無法下單' . '</td>';
		}
		else
		{
			echo '<td>' . '使用者尚未下單' . '</td>';
		}
		echo '</tr>';
	}
	?>
</table>

</body>
</html>