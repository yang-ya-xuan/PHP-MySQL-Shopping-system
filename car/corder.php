<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>無標題文件</title>
<style type="text/css">
body {
    display: flex;/*在內部輕鬆排列元素*/
    flex-direction: row;/*水平排列*/
    flex-wrap: wrap;/*當內容超出一行寬度時，自動換行*/
    justify-content: flex-start;/*將內容靠左對齊*/
    align-items: flex-start;/* 垂直靠上對齊 */
    gap: 400px;/*設定內容間的水平和垂直間距為 20 像素*/
    padding: 60px;/*在 body 邊緣留出 20 像素的內邊距*/
}

#up
{
	position: fixed;/*瀏覽器視窗進行定位(讓他保持相同位置)*/
    top: 0;/*因為有position，所以可以利用top、left、right這些來指定元素在視窗中的確切位置。*/
    left: 0;
    right: 0;
	width: auto;
    height: 45pt;
    background-color: #F3F4F4;
	display: flex;/*在內部輕鬆排列元素*/
	justify-content: space-between;/*讓第一個元素在開頭，後面的原素在後面(第一個：置左，後面的：置右)*/
	align-items: center;/*垂直居中對齊*/
	
}	
#up_login_register
{
	display: flex;
    justify-content: flex-end;/* 靠右對齊登入註冊 */
    align-items: center; /* 垂直居中對齊 */
    gap: 10px; /* 調整按鈕和會員資料之間的間距 */
}
th, td 
{
    text-align: center;
    vertical-align: middle; /* 垂直居中對齊 */
}
</style>
</head>

<body>
<div id="up">
	<div style="display: flex; align-items: center;">
		<a href="<?php echo 'loginok.php'; ?>"><img src="ha/top.png" width="65" height=65" alt=""/></a>
		<a href="<?php echo 'loginok.php'; ?>" style="color: green; font-size: 30px; text-decoration: none;">蔬</a>
		<a href="<?php echo 'loginok.php'; ?>" style="color: red; font-size: 30px; text-decoration: none;">果</a>
		<a href="<?php echo 'loginok.php'; ?>" style="color: purple; font-size: 30px; text-decoration: none;">行</a>
	</div>
			
	<?php
	session_start();
	
	if (isset($_SESSION['caccount']))
	{
		$caccount = $_SESSION['caccount'];//計錄目前登入的帳號
	}
	?>
	
		<div id="up_login_register">
		<?php
		$commodity = "commodity.php";
		echo '<a href="' . $commodity . '" style="color: #7A7A7A; text-decoration: none;">商品</a>';
		echo '<font color="#7A7A7A"> | </font>';
		$member_profile = "cmember.php";
		echo '<a href="' . $member_profile . '" style="color: #7A7A7A; text-decoration: none;">會員資料</a>';
		echo '<font color="#7A7A7A"> | </font>';
		$member_profile = "ccar.php";
		echo '<a href="' . $member_profile . '" style="color: #7A7A7A; text-decoration: none;">購物車</a>';
		echo '<font color="#7A7A7A"> | </font>';
		$member_profile = "corder.php";
		echo '<a href="' . $member_profile . '" style="color: #7A7A7A; text-decoration: none;">訂單管理</a>';
		if (strpos($_SESSION['caccount'], '@') !== false)//如果帳號裡面有@
		{
			echo '<font color="#7A7A7A"> | </font>';
			$hloginok = "hloginok.php";
			echo '<a href="' . $hloginok . '" style="color: #7A7A7A; text-decoration: none;">後端</a>';
			echo '<font color="#7A7A7A"> | </font>';
		}
		?>

		<form method="post" action="">
			<input type="submit" value="登出" name="logout" />
		</form>
		
		<?php
		if(isset($_POST["logout"]))
		{
			unset($_SESSION['caccount']);
			unset($_SESSION['loginnn']);
			header("Location:index.php");
		}
		if (isset($_SESSION['caccount']))
		{
			echo '<span style="font-size:10px; font-weight: bold ">' . $_SESSION['caccount'] . '，登入成功</span>';
		}
		if(!isset($_SESSION['caccount']))
		{
			echo "<script>alert('請先登入喔');</script>";
			echo "<script> window.location.href = 'index.php';</script>";
		}
		?>
	</div>
</div>
	
	
<?php
	include("database.php");
	
	if (isset($_SESSION['caccount']))
	{
		$caccount = $_SESSION['caccount'];//計錄目前登入的帳號
	}
	
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
	
	/*$sql_query_corder = "SELECT * FROM corder WHERE caccount = ?";
	$stmt_corder = $db_link->prepare($sql_query_corder);
	$stmt_corder->bind_param("s", $caccount);
	$stmt_corder->execute();
	$result_corder = $stmt_corder->get_result();

	if (!$result_corder && !mysqli_num_rows($result_corder) > 0)//確定資料庫是查詢成功，如果是空的護襪就不會進來
	{   !$result_corder || mysqli_num_rows($result_corder) == 0 ???上面的相反
		$row_corder = mysqli_fetch_assoc($result_corder);
	}
	
	else
	{
		echo "<script>alert('目前沒有下訂商品')</script>";
	}*/
	
	//如果他沒有在上架或者被刪除或者被更改價格的話就回到購物車
	$sql_query_caccount ="SELECT * FROM ccar WHERE caccount = ? AND (ud = 'down' OR cdelete = 'Y' OR pricec = 'C')";
	$stmt_caccount = $db_link->prepare($sql_query_caccount);
	$stmt_caccount->bind_param("s", $caccount);
	$stmt_caccount->execute();
	$result_caccount = $stmt_caccount->get_result();

	if ($result_caccount->num_rows > 0) 
	{
		echo"<script> window.location.href = 'ccar.php';</script>";
		return;
	}
	$stmt_caccount->close();
	
	if (isset($_POST['corder']))//如果按下提交的話商品庫存數量要減
	{
		//如果下單數量大於商品庫存
		$address = $_POST['address'];
		$canSubmitOrder = true; // 假設可以提交訂單
    	$errors = array(); // 用來存放錯誤訊息
		
		$sql_query_caccount = "SELECT * FROM ccar WHERE caccount = '$caccount' AND ud = 'up' ";
		$result_caccount = $db_link -> query($sql_query_caccount);
		
		//將剛剛下單那個帳號的所有資料全部從購物車的資料庫放到訂單的資料庫裡面
		while ($row = mysqli_fetch_assoc($result_caccount)) 
		{
			$cID = $row['cID'];
			//$tID = $row['tID'];
			$name = $row['name'];
			$price = $row['price'];
			$image = $row['image'];
			$quantity = $row['quantity'];//下單數量
			
			$sql_query_commodity = "SELECT quantity FROM commodity WHERE cID = '$cID'";
			$result_commodity = mysqli_query($db_link, $sql_query_commodity);
			while ($row_commodity = mysqli_fetch_assoc($result_commodity)) 
			{
				$quantityc = $row_commodity['quantity'];
				
				if($quantity > $quantityc)//如果下單數量大於庫存
				{
					//echo"<script>alert('庫存不夠， $name 的購買數量請勿超過 $quantityc 個喔 '); window.location.href = 'ccar.php';</script>";
					//return;
					$canSubmitOrder = false;
					$errors[] = "庫存不足，$name 的購買數量請勿超過 $quantityc 個";
					//$test = 1;
					
				}
			}
			
		}
		
		if ($canSubmitOrder) //如果沒有$test的話(因為沒有$test代表下單數量沒有大庫存)
		{
			foreach ($result_caccount as $row) 
			{
				$cID = $row['cID'];
				$name = $row['name'];
				$price = $row['price'];
				$image = $row['image'];
				$quantity = $row['quantity'];

				$tID = time().$caccount;

				//將購物車資料庫的東西放到訂單資料庫
				$insert_query = "INSERT INTO corder (tID, cID, caccount, name, price, image, quantity, address) 
								 VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
				$insert_stmt = $db_link->prepare($insert_query);
				$insert_stmt->bind_param("iissisis", $tID, $cID, $caccount, $name, $price, $image, $quantity, $address);
				$insert_stmt->execute();
				$insert_stmt->close();

				//購物車資料庫的東西
				$delete_query = "DELETE FROM ccar WHERE caccount = ? AND ud = 'up'";
				$delete_stmt = $db_link->prepare($delete_query);
				$delete_stmt->bind_param("s", $caccount);
				$delete_stmt->execute();
				$delete_stmt->close();

				//減掉商品資料庫的庫存
				$reduce_query = "UPDATE commodity SET quantity = quantity - ? WHERE cID = ?";
				//在商品資料庫裡面，減掉剛下單那個商品的庫存
				$reduce_stmt = $db_link->prepare($reduce_query);
				$reduce_stmt->bind_param("ii", $quantity, $cID);
				$reduce_stmt->execute();
				$reduce_stmt->close();
			}
		}
		
		else
		{
			if (!empty($errors))//顯示錯誤訊息
			{
				foreach ($errors as $error)
				{
					echo "<script>alert('$error');</script>";
				}
				echo "<script>window.location.href = 'ccar.php';</script>";
				return;
			}
		}
	}

			
			
	
	
	//顯示訂單資料
	$sql_query_caccount = "SELECT * FROM corder WHERE caccount = ?";
	$stmt_caccount = $db_link->prepare($sql_query_caccount);
	$stmt_caccount->bind_param("s", $caccount);
	$stmt_caccount->execute();
	$result_caccount = $stmt_caccount->get_result();
	
	$totals = array();
	$grouped_results = array();
	while ($row = mysqli_fetch_assoc($result_caccount))
	{
		$tid = $row['tID'];//用來保存每個tid的總價
		if (!isset($grouped_results[$tid]))//檢查目前有沒有這個tid
		{
			$grouped_results[$tid] = array();//儲存每個tid的總價格
		}
		$grouped_results[$tid][] = $row;//同樣的tid都會放到一起

		$totals[$tid] = isset($totals[$tid]) ? $totals[$tid] : 0;//如果沒有這個tid的話最開始先設定為0
		$totals[$tid] += $row['quantity'] * $row['price'];//有的話就價格*數量
	}
	
	if (empty($grouped_results))//檢查儲存tid的grouped_results是不是空的
	{
		echo "<script>  window.location.href = 'loginok.php'; alert('目前沒有下訂商品')</script>";
	}
	
	?>
<table border="2" align="center" style="width: 70%; border-collapse: collapse;">
<!-- 外圍寬度。置中。寬度是整個頁面的70%，表格邊框合併 -->
  <tr style="background-color: rgba(220,232,251,0.75);">
    <th height="40">使用者帳號</th>
	  	<th>訂單編號</th>
		<th>商品名稱</th>
		<th>商品價格</th>
		<th>圖片</th>
		<th>商品數量</th>
		<th>運送地址</th>
		<th>訂單處理</th>
	</tr>
			
	<?php
    foreach ($grouped_results as $tid => $items)//以tid分組的資料放進items
	{
        $totalPrice = $totals[$tid];//得到每個tid的總價
        
        foreach ($items as $row)//將資料放到row
		{
            echo "<tr>";
            echo "<td>".$row['caccount']."</td>";
			echo "<td>".$row['tID']."</td>";
            echo "<td>".$row['name']."</td>";
            echo "<td>".$row['price']."</td>";
            echo "<td><img src='".$row['image']."' alt='商品圖片' width='100'></td>";
            echo "<td>".$row['quantity']."</td>";
            echo "<td>".$row['address']."</td>";
            echo "<td>".($row['cancel'] === 'N' ? '不成立' : ($row['state'] === 'Y' ? '已出貨' : '未出貨'))."</td>";
			echo "</tr>";
        }
		
		echo '<tr>';
		echo '<td colspan="7" style="text-align: left; height: 35px; border-bottom: 3px solid black;"><strong>總價：' . $totalPrice . '</strong></td>';
       
		
		if($row['state'] === 'N' AND $row['cancel'] === 'Y')//如果還沒出貨要讓使用者可以取消訂單，訂單不成立的話(管理者按的)不要有取消訂單
		{
			echo '<td style="text-align: right; border-bottom: 3px solid black;">';
			echo "<form method='POST' action=''>";
			echo "<input name='cancel' type='submit' value='取消訂單'>";
			?>
			<input type='hidden' name='tID' value='<?php echo $tid;?>'>
			<?php
			echo "</form>";
			"</td>";
		}
		else
		{
			 echo '<td style="text-align: right; border-bottom: 3px solid black;">無法取消</td>';
		}
        echo '</tr>';
    }
	
	
	$sql_query = "SELECT state, cancel FROM corder WHERE tID = ?";
	$stmt = $db_link->prepare($sql_query);
	$stmt->bind_param("i", $_POST["tID"]);
	$stmt->execute();
	$result = $stmt->get_result();
	if ($result && $result->num_rows > 0) 
	{
		$row = mysqli_fetch_assoc($result);
		if($row['state'] === 'N' AND $row['cancel'] === 'Y')//如果還沒出或或者管理者沒有取消訂單的話，使用者才可以取消訂單
		{
			if(isset($_POST['cancel']))//如果按下取消訂單的話，要刪除訂單
			{
				$tID = $_POST['tID'];// 確保您接收到 tID 的值

				//把取消的數量加回去庫存裡面
				$sql_query_plus = "SELECT cID, quantity FROM corder WHERE tID = ?";
				$stmt_plus = $db_link->prepare($sql_query_plus);
				$stmt_plus->bind_param("i", $tID);
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

				//刪掉訂單管理資料庫的資料
				$sql_query_corder = "DELETE FROM corder WHERE tID=?";
				$stmt_corder = $db_link -> prepare($sql_query_corder);
				$stmt_corder -> bind_param("i", $tID);
				if ($stmt_corder->execute()) 
				{
					echo"<script> window.location.href = 'corder.php'; alert('$tID 訂單取消成功');</script>";
				} 
				else 
				{
					echo"<script> window.location.href = 'corder.php'; alert('$tID 訂單取消失敗');</script>";
				}
				$stmt_corder -> close();


				//$db_link -> close();
				//header("Location: loginok.php");
			}
		}
	}
    ?>
	</table>
</body>
</html>
<?php
	$db_link -> close();
?>