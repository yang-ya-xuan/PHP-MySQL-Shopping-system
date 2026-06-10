<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>無標題文件</title>
</head>

<body>
<?php
	include("database.php");
	$sql_query_caccount = "SELECT * FROM corder";
	$stmt_caccount = $db_link->prepare($sql_query_caccount);
	$stmt_caccount->execute();
	$result_caccount = $stmt_caccount->get_result();
	
	$totals = array();
	
	$grouped_results = array();
	while ($row = mysqli_fetch_assoc($result_caccount))
	{
		$tID = $row['tID'];
	}
	echo $tID;
	$update_query = "select cID, caccount, name, price, image, quantity, address, state FROM corder WHERE tID=?";
    $update_stmt = $db_link->prepare($update_query);
    $update_stmt->bind_param("s", $_GET["tID"]);
	$update_stmt -> execute();//將綁定的值插入到資料庫中
	$update_stmt -> bind_result($cID, $caccount, $name, $price, $image, $quantity, $address, $state);
	$update_stmt ->fetch();
	$db_link ->close();//關閉資料庫連接
	
	
?>
<form method="POST" action="">
	<table border = "1" align="center" cellpadding="4">
	<tr>
		<th>欄位</th><th>資料</th>
	</tr>
	<tr>
		<td>帳號</td><td><?php echo $caccount;?></td>
	</tr>
	<tr>
		<td>名稱</td><td><?php echo $name;?></td>
	</tr>
	<tr>
		<td>價格</td><td><?php echo $price;?></td>
	</tr>
	<tr>
		<td>圖片</td><td><img src="<?php echo $image; ?>" alt="商品圖片" width="200"></td>
	</tr>
	
		
	<tr>
	<td colspan="2" align="center">
		<input name = "cID" type="hidden" value="<?php echo $cID;?>">
		<input name = "action" type="hidden" value="delete">
		<input name = "button" type="submit" value="確定刪除刪除資料">
	</td>
	</tr>
</body>
</html>