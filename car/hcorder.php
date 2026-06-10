<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>無標題文件</title>
<style type="text/css">
body {
    background-color: rgba(220,251,226,0.75);
}
</style>
</head>

<body>
<h1 align = "center">訂單管理_後端</h1>
	<p align = "center"><a href="hloginok.php">回到首頁</a></p>
		
<?php
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
	
	$sql_query_caccount = "SELECT * FROM corder";
	$stmt_caccount = $db_link->prepare($sql_query_caccount);
	$stmt_caccount->execute();
	$result_caccount = $stmt_caccount->get_result();
	
	//將總價跟tID資料儲存，後面比較好顯示
	$totals = array();//儲存總價
	$grouped_results = array();//$grouped_results用來將查詢結果按照每個tID分組
	
	while ($row = mysqli_fetch_assoc($result_caccount))
	{
		$tID = $row['tID'];//用來保存每個tid的總價
		
		if (!isset($grouped_results[$tID]))//如果tID不存在的話
		{
			$grouped_results[$tID] = array();//儲存每個tid的總價格
		}
		$grouped_results[$tID][] = $row;

		$totals[$tID] = isset($totals[$tID]) ? $totals[$tID] : 0;//如果tID有存的話
		$totals[$tID] += $row['quantity'] * $row['price'];//就將這個tID價格*數量
	}
	
	
	?>
<table border="2" align="center" style="width: 70%; border-collapse: collapse;">
<!--外圍寬度。置中。寬度是整個頁面的70%，表格邊框合併-->
  <tr style="background-color: rgba(220,232,251,0.75);">
    <th height="40">使用者帳號</th>
	<th>訂單編號</th>
    <th>商品名稱</th>
    <th>商品價格</th>
    <th>圖片</th>
    <th>下單數量</th>
    <th>運送地址</th>
    <th>是否出貨</th>
  </tr>
			
	<?php
	//按照tID顯示所有消費這下訂單的商品
    foreach ($grouped_results as $tID => $items)
	//找完$grouped_results 陣列，將每個 tID 對應的資料取出，然後直放到$items上
	{
        $totalPrice = $totals[$tID];//總價
        
        foreach ($items as $row)//將上面按照tID分組的東西分成一個資料一格資料取出
		{
            echo "<tr>";
			echo "<td>".$row['caccount']."</td>";
			echo "<td>".$row['tID']."</td>";
			echo "<td>".$row['name']."</td>";
			echo "<td>".$row['price']."</td>";
			echo "<td><img src='".$row['image']."' alt='商品圖片' width='100'></td>";
			echo "<td>".$row['quantity']."</td>";
			echo "<td>".$row['address']."</td>";
			echo "<td>".($row['cancel'] === 'N' ? '不成立' : ($row['state'] === 'Y' ? '是' : '否'))."</td>";
			echo "</tr>";
        }
		
		echo '<tr>';
		echo '<td colspan="7" style="text-align: left; height: 35px; border-bottom: 3px solid black;"><strong>總價: ' . $totalPrice . '</strong></td>';
        echo '<td style="text-align: right; border-bottom: 3px solid black;">';
		
		if (strpos($caccount, '@admin') !== false)//如果帳號有@admin才可以出貨
		{
			if($row['state'] === 'N' AND $row['cancel'] === 'Y')//如果還沒出過貨才可以在出貨，以及訂單沒有被取消才可以出貨
			{
				echo '<form method="POST" action="">';
				echo '<input type="hidden" name="tID" value="' . $tID . '">';
				echo '<input type="submit" value="出貨" name="ship">';
				echo '<input type="submit" value="取消訂單" name="cancel">';
				echo '</form>';
			}
			
		}
        echo '</td>';
        echo '</tr>';
		
		/*echo '<tr>';
        echo '<td colspan="6" style="text-align: left;"><strong>總價: ' . $totalPrice . '</strong></td>';
        echo '<td style="text-align: right;">';
        echo '<form method="POST" action="">';
		echo"<a href='hcorder2.php?id=".$row['tID']."'>出貨</a>";
        echo '</td>';
        echo '</tr>';*/
    }
	$sql_query_q = "SELECT * FROM register" ;
	$stmt_q = $db_link->prepare($sql_query_q);
	$stmt_q->execute();
	$result_q = $stmt_q->get_result();
	if($result_q && $result_q->num_rows > 0)
	{
		$row_t = mysqli_fetch_assoc($result_q);
		$caccount_t = $row_t['caccount'];

	$sql_query = "SELECT * FROM register WHERE caccount = '$caccount_t'";
	$stmt_tt = $db_link->prepare($sql_query);
	$stmt_tt->execute();
	$result_tt = $stmt_tt->get_result();
	if($result_tt && $result_tt->num_rows > 0)
	{
		$row_tt = mysqli_fetch_assoc($result_tt);
		
	
	
	
	$sql_query_ship = "SELECT * FROM corder WHERE tID = ?";
	$stmt_ship = $db_link->prepare($sql_query_ship);
	$stmt_ship->bind_param("s", $_POST['tID']);
	$stmt_ship->execute();
	$result_ship = $stmt_ship->get_result();
	if($result_ship && $result_ship->num_rows > 0)
	{
		$row_ship = mysqli_fetch_assoc($result_ship);
		if($row_ship['cancel'] === 'Y' AND $row_tt['disabled'] ==='Y')//如果使用者霉取消訂的話才可以出貨
		{
			//如果按下出貨，要變成Y
			if(isset($_POST['ship']))
			{
				$update_query = "UPDATE corder SET state = 'Y' WHERE tID = ?";
				$update_stmt = $db_link->prepare($update_query);
				$update_stmt->bind_param("s", $_POST["tID"]);

				if ($update_stmt->execute())
				{
					echo"<script> alert('$tID 出貨成功'); window.location.href = 'hcorder.php';</script>";
				}
				else
				{
					echo"<script> alert('$tID 出貨失敗'); window.location.href = 'hcorder.php';</script>";
				}
				$update_stmt->close();
			}
		}
		elseif($row_tt['disabled'] ==='N')
		{
			echo"<script> alert('已經被禁用了')</script>";
		}
		}
			//如果取消訂單，要顯示不成立，cancel：Y：成立，N：不成立
			if(isset($_POST['cancel']))
			{
				$update_query = "UPDATE corder SET cancel = 'N' WHERE tID = ?";
				$update_stmt = $db_link->prepare($update_query);
				$update_stmt->bind_param("s", $_POST["tID"]);
				if ($update_stmt->execute())
				{
					echo "<script>alert('$tID 訂單取消成功'); window.location.href = 'hcorder.php';</script>";
				}
				else
				{
					echo"<script> alert('$tID 訂單取消失敗'); window.location.href = 'hcorder.php';</script>";
				}
				$update_stmt->close();

				//把取消的數量加回去庫存裡面
				$sql_query_plus = "SELECT cID, quantity FROM corder WHERE tID = ?";
				$stmt_plus = $db_link->prepare($sql_query_plus);
				$stmt_plus->bind_param("i", $_POST["tID"]);
				$stmt_plus->execute();
				$result_plus = $stmt_plus->get_result();
				while ($row_plus = mysqli_fetch_assoc($result_plus)) 
				{
					$cID = $row_plus['cID'];
					$quantity = $row_plus['quantity'];

					// 更新商品資料表的庫存
					$sql_update_quantity = "UPDATE commodity SET quantity = quantity + ? WHERE cID = ?";
					$stmt_update_quantity = $db_link->prepare($sql_update_quantity);
					$stmt_update_quantity->bind_param("ii", $quantity, $cID);
					$stmt_update_quantity->execute();
					$stmt_update_quantity->close();
				}
			}
		}
	}
    ?>
	</table>
</body>
</html>