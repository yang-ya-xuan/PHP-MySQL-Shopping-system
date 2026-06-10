<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>無標題文件</title>
<style type="text/css">
body {
    /*display: flex;/*在內部輕鬆排列元素*/
    flex-direction: row;/*水平排列*/
    flex-wrap: wrap;/*當內容超出一行寬度時，自動換行*/
    ustify-content: flex-start;/*將內容靠左對齊*/
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
td, th 
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
	
    if (isset($_POST["cID"]) && isset($_POST["quantity"]))
	{
        $cID = $_POST["cID"];
        $quantity = $_POST["quantity"];//商品頁面輸入的數量記住

        $sql_query = "SELECT * FROM commodity WHERE cID = ?";//將commodity資料庫的cID取出
        $stmt = $db_link->prepare($sql_query);
        $stmt->bind_param("i", $cID);//將選擇商品的編號放到上面
        $stmt->execute();//將實際的值插入到 SQL 查詢中並向資料庫發送查詢
        $result = $stmt->get_result();//讀取查詢的結果
		
        if ($result ->num_rows > 0)//如果資料庫有資料
		{
            $row = $result->fetch_assoc();
            $name = $row["name"];//將剛剛下單commodity資料庫裡的資料放到購物車的資料庫
            $price = $row["price"];
			$image = $row["image"];
			$ud = $row["ud"];
			$cdelete = 'N';
			//$pricec = 'N';
			
			// 檢查是否已存在相同 cID 的商品在購物車中，就加在數量上不需要再新增一筆資料
			$sql_query_existing = "SELECT * FROM ccar WHERE caccount = ? AND cID = ?";
			$stmt_existing = $db_link->prepare($sql_query_existing);
			$stmt_existing->bind_param("si", $caccount, $cID);//將要判斷的帳號跟編號帶入
			$stmt_existing->execute();
			$result_existing = $stmt_existing->get_result();
			
			
			
			$sql_query = "SELECT * FROM commodity WHERE cID = '$cID'";
			$result = mysqli_query($db_link, $sql_query);
			$row = mysqli_fetch_assoc($result);
			$ud = $row['ud'];
			if ($result_existing ->num_rows > 0)//如果上面都成功寫入
			{
				$existing_row = $result_existing->fetch_assoc();
				$existing_quantity = $existing_row["quantity"];//原本資料庫的商品數量

				$new_quantity = $existing_quantity + $quantity;//新的數量為原有數量加上剛下單的數量

				// 更新原有商品的數量
				$update_query = "UPDATE ccar SET quantity = ? WHERE caccount = ? AND cID = ?";
				$update_stmt = $db_link->prepare($update_query);
				$update_stmt->bind_param("isi", $new_quantity, $caccount, $cID);
				$update_result = $update_stmt->execute();
				
				echo"<script> window.location.href = 'loginok.php'; alert('$name 已成功加入購物車，請繼續選購');</script>";
			}
			else if($row['ud'] == 'up')//如果沒有一樣的帳號跟商品編號(沒有一樣的商品下單兩次)
			{
				$insert_query = "INSERT INTO ccar (cID, caccount, name, price, image, quantity, ud, cdelete) VALUES (?, ?, ?, ?, ? ,?, ?, ?)";
				$insert_stmt = $db_link->prepare($insert_query);
				$insert_stmt->bind_param("issisiss", $cID, $caccount, $name, $price, $image, $quantity, $ud, $cdelete);

				
				if ($insert_stmt -> execute()) 
				{
					echo"<script> window.location.href = 'loginok.php'; alert('$name 已成功加入購物車，請繼續選購');</script>";
					
					$sql_query_caccount = "SELECT * FROM ccar WHERE caccount = $caccount";
					$result_caccount = $db_link -> query($sql_query_caccount);
					?>
					<!-- <table border="1" align="center">
						<tr>
							<th>使用者帳號</th>
							<th>商品名稱</th>
							<th>商品單價</th>
							<th>圖片</th>
							<th>下單數量</th>
						</tr> -->

					<?php
					/*while ($row = mysqli_fetch_assoc($result_caccount))
					{
						echo "<tr>";
						echo "<td>".$row['caccount']."</td>";
						echo "<td>".$row['name']."</td>";
						echo "<td>".$row['price']."</td>";
						echo "<td><img src='".$row['image']."' alt='商品圖片' width='100'></td>";
						echo "<td>".$row['quantity']."</td>";
						echo "</tr>";
					}*/

					?>
					 <!-- </table> -->
				<?php
				} 
				else 
				{
					echo "<script> window.location.href = 'loginok.php'; alert('加入購物車失敗')</script>";
				}
			}else 
				{
					echo "<script> window.location.href = 'loginok.php'; alert('加入購物車失敗')</script>";
				}
        }
		else 
		{
			header("Location:loginok.php");
			echo "<script>alert('找不到該商品')</script>";
        }
    } 
	
	else 
	{
		$sql_query_caccount = "SELECT * FROM ccar WHERE caccount = ?";
		$stmt_caccount = $db_link->prepare($sql_query_caccount);
		$stmt_caccount->bind_param("s", $caccount);
		$stmt_caccount->execute();
		$result_caccount = $stmt_caccount->get_result();
			
		$tt = "SELECT * FROM commodity";
		$tt2 = $db_link->prepare($tt);
		//$tt2->bind_param("s", $caccount);
		$tt2->execute();
		$tttttt = $tt2->get_result();
		
		$total_price = 0;//總價最開始新設定是0
		?>
		<table border="2" align="center" style="width: 70%; border-collapse: collapse;">
		<!--外圍寬度。置中。寬度是整個頁面的70%，表格邊框合併-->
  			<tr style="background-color: rgba(220,232,251,0.75);">
    			<th height="40">使用者帳號</th>
				<th>商品名稱</th>
				<th>商品價格</th>
				<th>圖片</th>
				<th>商品數量</th>
				<th>功能</th>
			</tr>
			
		<?php
		$test = mysqli_fetch_assoc($tttttt);
		while ($row = mysqli_fetch_assoc($result_caccount))
		{
			echo "<tr>";
			echo "<td>".$row['caccount']."</td>";
			echo "<td>".$row['name']."</td>";
			echo "<td>".$row['price']."</td>";
			echo "<td><img src='".$row['image']."' alt='商品圖片' width='100'></td>";
			echo "<td>".$row['quantity']."</td>";
			echo"<td><a href='ccar2.php?id=".$row['cID']."'>修改";
			echo" | ";
			echo"<a href='ccar3.php?id=".$row['cID']."'>刪除</a>";
			echo "</tr>";
			
			
			//如果價格有被更改過的話
			if($row['pricec'] === 'C')
			{
				$cID = $row['cID'];
				$name = $row['name'];
				$price = $row['price'];
				echo "<script> alert('$name 商品價格更改成 $price')</script>";
				
				//在把狀態設成沒有被更改過
				$sql_query_ccar = "UPDATE ccar SET pricec = 'N' WHERE cID=? AND caccount = '$caccount'";
				$stmt_ccar = $db_link -> prepare($sql_query_ccar);
				$stmt_ccar -> bind_param("i",$cID);
				$stmt_ccar -> execute();
				$stmt_ccar -> close();
				//$db_link -> close();
			}
			
			if ($row['cdelete'] == 'Y') 
			{
				$name = $row['name'];
				$sql_query_delete = "DELETE FROM ccar WHERE cdelete='Y' AND caccount = ?";
				$stmt_delete = $db_link->prepare($sql_query_delete);
				$stmt_delete->bind_param("s", $caccount);
				if ($stmt_delete->execute()) 
				{
					echo "<script> window.location.href = 'ccar.php'; alert('$name 已被管理者刪除');</script>";
				}
				$stmt_delete->close();
			}
			
			//如果商品被下架的話，登入後把他刪掉
			if ($row['ud'] === 'down') 
			{
				$name = $row['name'];
				$sql_query_ud = "DELETE FROM ccar WHERE ud='down' AND caccount = ?";
				$stmt_ud = $db_link->prepare($sql_query_ud);
				$stmt_ud->bind_param("s", $caccount);
				if ($stmt_ud->execute()) 
				{
					echo "<script> window.location.href = 'ccar.php'; alert('$name 已被管理者下架');</script>";
				}
				$stmt_ud->close();	
			}
			
			$total_price += $row['quantity'] * $row['price'];//總價
			
		}
		echo '<tr><td colspan="6"><strong>總價: ' . $total_price . '</strong></td></tr>';
		
		?>
		</table> 
		<?php
    }
?>
<?php
	$sql_query_caccount = "SELECT * FROM ccar WHERE caccount = ?";
	$stmt_caccount = $db_link->prepare($sql_query_caccount);
	$stmt_caccount->bind_param("s", $caccount);
	$stmt_caccount->execute();
	$result_caccount = $stmt_caccount->get_result();

	if ($result_caccount && mysqli_num_rows($result_caccount) > 0)//確定資料庫是查詢成功，如果是空的護襪就不會進來
	{
		$row = mysqli_fetch_assoc($result_caccount);

		echo '<br>';
		?>
		<div style="display: flex; justify-content: center; align-items: center;">
			<form method="POST" action="">
				<input type="submit" value="確定下單" name="sure" style="width: 255px;font-size: 16px;">
			</form>
		</div>
		<?php
	}
	else
	{
		echo "<script> window.location.href = 'loginok.php'; alert('購物車目前沒有商品')</script>";
	}
		$sql_query = "SELECT * FROM commodity WHERE cID = ? AND ud = 'down'";
		$stmt = $db_link->prepare($sql_query);
		$stmt->bind_param("i", $cID);
		$stmt->execute();
		$result = $stmt->get_result();
		
		if(isset($_POST['sure']))
		{
			echo '<br>';
?>
		<div style="display: flex; justify-content: center; align-items: center;">
			<form method="POST" action="corder.php">
				請輸入地址：
				<input type="text" name="address" style="width: 255px;" required pattern="^([\u4e00-\u9fa5]*)市([\u4e00-\u9fa5]*)區([\u4e00-\u9fa5]*)路([0-9]*)號([1-9]*)樓$" placeholder="oo市oo區oo路oo號oo樓">
				<input type = "submit" name = "corder" value="提交">
			</form>
		</div>
<?php
		}
		else //如果資料庫的值是下架
		{
			/*$sql_query = "SELECT * FROM commodity WHERE cID = ? AND ud = 'up'";
			$stmt = $db_link->prepare($sql_query);
			$stmt->bind_param("i", $_POST["cID"]);
			$stmt->execute();
			$result = $stmt->get_result();*/
			
			/*$sql_query = "SELECT * FROM commodity WHERE cID = '$cID'";
			$result = mysqli_query($db_link, $sql_query);
			if($result)
			{
				$row = mysqli_fetch_assoc($result);
				$ud = $row['ud'];
				if($ud = 'down')
				{
					echo "<script>  window.location.href = 'ccar.php'; alert('我是測試的')</script>";
				}
				
			}*/
		}
?>
</body>
</html>