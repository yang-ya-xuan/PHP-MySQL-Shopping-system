<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>無標題文件</title>
<style type="text/css">
body {
    background-color: #FFFFFF;
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
    align-items: center;
    gap: 10px;
}
	
</style>
</head>

<body>
<div id="up">
	<div style="display: flex; align-items: center;">
		<a href="<?php echo 'hloginok.php'; ?>"><img src="ha/top.png" width="65" height=65" alt=""/></a>
		<a href="<?php echo 'hloginok.php'; ?>" style="color: green; font-size: 30px; text-decoration: none;">蔬</a>
		<a href="<?php echo 'hloginok.php'; ?>" style="color: red; font-size: 30px; text-decoration: none;">果</a>
		<a href="<?php echo 'hloginok.php'; ?>" style="color: purple; font-size: 30px; text-decoration: none;">行</a>
	</div>
			
	<?php
	//==========後端登入成功==========
	include("database.php");
	session_start();
	
	if(!isset($_SESSION['caccount']))
	{
		echo "<script>alert('請先登入喔');</script>";
		echo "<script> window.location.href = 'index.php';</script>";
	}
	?>
	
	<div id = "up_login_register">
		
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
			$caccount = $_SESSION['caccount'];
			echo '<span style="font-size:10px; font-weight: bold ">' . $_SESSION['caccount'] . '，登入成功</span>';
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
		
		?>
	</div>
</div>
	
<div style="display: flex; justify-content: space-between; margin: 80px auto 0; width: 100%;">
    <a href="hmaterial.php" style="text-decoration: none;">
        <div style="width: 250px; height: 250px; background-color: rgba(254,229,255,0.75); padding: 20px; border-radius: 50px; text-align: center; box-shadow: 8px 8px 8px rgba(0, 0, 0, 0.1); position: relative;">
            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                <img src="ha/hmaterial.png" alt="圖片1" style="max-width: 100%; max-height: 100%;">
            </div>
            <p style="position: absolute; left: 50%; transform: translateX(-50%); bottom: 5%; width: 100%; text-align: center; font-weight: bold;">使用者資料</p>
        </div>
    </a>
	
	
	<a href="upload.php" style="text-decoration: none;">
        <div style="width: 250px; height: 250px; background-color: rgba(211,248,255,0.75); padding: 20px; border-radius: 50px; text-align: center; box-shadow: 8px 8px 8px rgba(0, 0, 0, 0.1); position: relative;">
            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                <img src="ha/upload.png" alt="圖片2" style="max-width: 100%; max-height: 100%;">
            </div>
            <p style="position: absolute; left: 50%; transform: translateX(-50%); bottom: 5%; width: 100%; text-align: center; font-weight: bold;">商品上傳</p>
        </div>
    </a>
	
		
    <a href="upload2.php" style="text-decoration: none;">
        <div style="width: 250px; height: 250px; background-color: rgba(255,229,236,0.75); padding: 20px; border-radius: 50px; text-align: center; box-shadow: 8px 8px 8px rgba(0, 0, 0, 0.1); position: relative;">
            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                <img src="ha/upload2.png" alt="圖片3" style="max-width: 100%; max-height: 100%;">
            </div>
            <p style="position: absolute; left: 50%; transform: translateX(-50%); bottom: 5%; width: 100%; text-align: center; font-weight: bold;">商品資料</p>
        </div>
    </a>
	
    <a href="hcart.php" style="text-decoration: none;">
        <div style="width: 250px; height: 250px; background-color: rgba(237,235,235,0.75);; padding: 20px; border-radius: 50px; text-align: center; box-shadow: 8px 8px 8px rgba(0, 0, 0, 0.1); position: relative;">
            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                <img src="ha/car.png" alt="圖片4" style="max-width: 100%; max-height: 100%;">
            </div>
            <p style="position: absolute; left: 50%; transform: translateX(-50%); bottom: 5%; width: 100%; text-align: center; font-weight: bold;">購物車</p>
        </div>
    </a>
</div>
	
<div style="display: flex; justify-content: space-between; margin: 20px auto 0; width: 100%;">
    <a href="hcorder.php" style="text-decoration: none;">
        <div style="width: 250px; height: 250px; background-color: rgba(220,251,226,0.75);; padding: 20px; border-radius: 50px; text-align: center; box-shadow: 8px 8px 8px rgba(0, 0, 0, 0.1); position: relative;">
            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                <img src="ha/hcorder.png" alt="圖片5" style="max-width: 100%; max-height: 100%;">
            </div>
            <p style="position: absolute; left: 50%; transform: translateX(-50%); bottom: 5%; width: 100%; text-align: center; font-weight: bold;">訂單管理</p>
        </div>
    </a>
</div>
	
	
	
	

</body>
</html>