<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>無標題文件</title>
<style type="text/css">

	
body {
	background-color: rgba(236,222,255,0.75);
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

#product 
{
    background-color: white;
    padding: 20px;/*設定區塊內容與邊框的間距*/
    border-radius: 50px;/*邊框為圓角*/
    width: calc(85%); /* 寬度佔頁面的85%(一排四個)*/
    text-align: center;/* 將商品置中 */
    margin: 40px auto;  /* 將上下左右的間距設為 40px，並將水平居中的間距自動調整 */
    box-shadow: 8px 8px 8px rgba(0, 0, 0, 0.3); /* 添加陰影效果 */
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
	include("database.php");
	session_start();
	
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
    //include("database.php");

    if (isset($_GET["cID"])) 
	{
        $cID = $_GET["cID"];

        $sql_query = "SELECT * FROM commodity WHERE cID = ? AND ud='up'";
        $stmt = $db_link->prepare($sql_query);
        $stmt->bind_param("i", $cID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) 
		{
            $row = $result->fetch_assoc();
        	$quantity = $row["quantity"];
            ?>
	<div id="product">
            <div style="display: flex; align-items: center;">
                <div>
                    <img src="<?php echo $row["image"]; ?>" alt="商品圖片" width="500">
                </div>
				
				<div style="text-align: left; margin-top: 20px; padding-left: 20px;">
					<h1><?php echo $row["name"]; ?></h1>
					<p style="background-color: #f0f0f0; padding: 20px; width: 400px; color: red; font-size: 30px;"><?php echo'$'. $row["price"]; ?></p>
					<p><?php echo $row["cexplain"]; ?></p>
				<form action="ccar.php" method="POST" >
					購買數量：
					<input type="number" value="1" name="quantity" max="<?=$quantity; ?>" min="1" required/>
					&nbsp; 庫存剩下<?=$quantity;?>個
					<br/>
					<br/>
					<input type="hidden" name="cID" value="<?php echo $cID; ?>"> <!-- 傳遞商品的 cID -->
					<?php //如果庫存0的話不要加入購物車 
					$sql_query_commodity = "SELECT quantity FROM commodity WHERE cID = '$cID'";
					$result_commodity = mysqli_query($db_link, $sql_query_commodity);
					while ($row_commodity = mysqli_fetch_assoc($result_commodity)) 
					{
						$quantityc = $row_commodity['quantity'];

					if($quantityc>0)
					{
						$sql_query = "SELECT * FROM commodity WHERE cID = ? AND ud='up'";//將commodity資料庫的cID取出
       
					?>
					<input type="submit" value="加入購物車" name="ccar" style="width: 222px; height: 30px; font-size: 16px;">
					<?php } }?>
				</form>
            	</div>
	</div>
    <?php
        }
		else 
		{
			echo "<script>alert('找不到該商品'); window.location.href = 'loginok.php';</script>";
        }
    } 
	else 
	{
        echo "<script>alert('缺少商品ID');window.location.href = 'loginok.php';</script>";
    }
    ?>
</body>
</html>