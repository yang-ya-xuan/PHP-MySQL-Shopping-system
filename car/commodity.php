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

#product-list {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

.product {
    background-color: rgba(233,217,255,0.75);
    padding: 20px;/*設定區塊內容與邊框的間距*/
    border-radius: 10px;/*邊框為圓角*/
    width: calc(20% - 15px); /* 寬度佔頁面的25%(一排四個);20px：寬度中減去20像素(間距)*/
    text-align: center;/* 將商品置中 */
    margin-bottom: 20px; /* 設定與下方區塊的間距 */
    margin: 10px; /* 設定上下左右的間距，這裡設定為 10px */	
}
.product img {
        width: 100%;/*設定圖片的寬度為 100%，使圖片填滿其容器的寬度*/
        height: auto;/*高度自動調整，以保持原始比例*/
        margin-bottom: 10px;/*圖片與下方內容的間距*/
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
//==========前端商品==========
	
	include("database.php");
	
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
	
	$sql_query = "SELECT * FROM commodity WHERE ud = 'up'";//如果是上架狀態的話才會顯示
	$select_result = mysqli_query($db_link, $sql_query);
	
	// 初始化 session 變數
	if (!isset($_SESSION['uploaded_data'])) 
	{
		$_SESSION['uploaded_data'] = array();
	}

	if (isset($_POST['go'])) 
	{
		$uploadname = $_POST["uploadname"];
		$uploadprice = $_POST["uploadprice"];
		$uploadexplain = $_POST["uploadexplain"];
		
		$sql = "INSERT INTO commodity (name, price, cexplain) 
				VALUES ('$uploadname', '$uploadprice','$uploadexplain')";
		$result = mysqli_query($db_link, $sql);
		
		if ($result)//用來確認之前的資料插入操作是否成功
		{	
			$allimage = array("image/jpeg", "image/jpg", "image/png", "image/gif");
			if (in_array($_FILES["file"]["type"], $allimage)) 
			{
				$path = "upload/" . $_FILES["file"]["name"];
				move_uploaded_file($_FILES["file"]["tmp_name"], $path);
			}
			// 將上傳的資料保存到 session 中
			$_SESSION['uploaded_data'][] = array
			(
				"name" => $uploadname,
				"price" => $uploadprice,
				"explain" => $uploadexplain,
				"path" => $path
			);
		}
		else 
		{
			echo "無法從資料庫讀取資料：" . mysqli_error($db_link);
		}
	}
?>

	
<div id="product-list" style="display: flex; flex-wrap: wrap;"><!--flex-wrap: wrap超出格子寬度時換行-->
    <?php $count = 0; ?><!--追蹤目前有幾個商品被處理-->
    <?php while ($row = mysqli_fetch_assoc($select_result)): ?>
        <div class="product" style="flex-basis: 20%; padding: 12px; box-sizing: border-box;">
			<!--代表了每個商品的格子。CSS 樣式設定了每個格子的寬度為 20%，並添加了內邊距，不會增加框模型的寬度-->
			<a href="product_detail.php?cID=<?php echo $row["cID"]; ?>" style="text-decoration: none; color: black;">
        	<!-- 上面的連結會將 cID 以 GET 參數傳遞給 product_detail.php 頁面 -->
            <img src="<?php echo $row["image"]; ?>" alt="商品圖片" style="max-width: 100%;">
            <h2><?php echo $row["name"]; ?></h2>
            <p>價格：<?php echo $row["price"]; ?></p>
            <p>說明：<?php echo substr($row["cexplain"], 0, 21) . (strlen($row["cexplain"]) > 21 ? '...' : ''); ?></p>
        </div>
        
        <?php $count++; ?><!--在每次迴圈時，$count 變數增加，用來追蹤當前處理的商品數量-->
        <?php if ($count % 4 === 0): ?><!--有沒有處理4個商品-->
            <div style="flex-basis: 100%;"></div><!--確保下一排隊齊-->
        <?php endif; ?>
    <?php endwhile; ?>
</div>
	






	
	
</body>
</html>