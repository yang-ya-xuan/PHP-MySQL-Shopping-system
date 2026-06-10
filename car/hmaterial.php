<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>無標題文件</title>
<style type="text/css">
body {
    background-color: #FAE9FA;
}
</style>
<?php
//==========後端查看所有會員資料==========
	include("database.php");
	$sql_query="select * FROM register";
	$select_result = mysqli_query($db_link, $sql_query);
	$total_record = $select_result -> num_rows;//計算有幾筆資料
?>
</head>
<body>
	<h1 align = "center">使用者資料_後端</h1>
	<p align = "center">目前共有：<?php echo $total_record; ?>位使用者
<table border="2" align="center" style="width: 70%; border-collapse: collapse;">
	<p align = "center"><a href="hloginok.php">回到首頁</a></p>

	<tr style="background-color: rgba(220,232,251,0.75);">
		<th height="40">編號</th>
		<th>姓名</th>
		<th>手機號碼</th>
		<th>性別</th>
		<th>帳號</th>
		<th>密碼</th>
		<th>使用狀態</th>
		<th>前/後端</th>
		<th>修改</th>
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
	
	while ($row = mysqli_fetch_assoc($select_result))
	{
		echo "<tr>";
		echo "<td>".$row['cID']."</td>";
		echo "<td>".$row['cname']."</td>";
		echo "<td>".$row['cnumber']."</td>";
		
		if ($row['cgender'] == "F") // 如果資料庫中的性別為女
		{
			echo "<td>女</td>"; // 在表格中顯示女生
		} 
		elseif ($row['cgender'] == "M") // 如果資料庫中的性別為男
		{
			echo "<td>男</td>"; // 在表格中顯示男生
		}
		
		echo "<td>".$row['caccount']."</td>";
		echo "<td>".$row['cpassword']."</td>";
		
		if($row['disabled'] === 'N')//如果還沒出過貨才可以在出貨，以及訂單沒有被取消才可以出貨
		{
			echo "<td>".'已被禁用'."</td>";
		}
		elseif($row['disabled'] === 'Y')//如果還沒出過貨才可以在出貨，以及訂單沒有被取消才可以出貨
		{
			echo "<td>".'沒禁用'."</td>";
		}
		
		if($row['promotion'] === '0')//如果還沒出過貨才可以在出貨，以及訂單沒有被取消才可以出貨
		{
			echo "<td>".'使用者'."</td>";
		}
		elseif($row['promotion'] === '1' or $row['promotion'] === '2')//如果還沒出過貨才可以在出貨，以及訂單沒有被取消才可以出貨
		{
			echo "<td>".'管理者'."</td>";
		}
		
		echo"<td><a href='hrevise.php?id=".$row['cID']."'>修改</a>";//附帶一個參數id，參數的值是該行資料的cID欄位的值
		echo "</tr>";
	}
		
?>
</body>
</html>