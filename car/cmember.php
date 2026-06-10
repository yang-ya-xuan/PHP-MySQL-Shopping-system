<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>無標題文件</title>
<style type="text/css">
body 
{
	display: flex;
    justify-content: center; /* 水平置中 */
    /*align-items: center;  //垂直置中 */
    min-height: 100vh; /* 最小設定為視窗的高度，才不會超過 */
    margin: 0; /* 是將元素的外邊距設為零(沒有間距) */
    background-color: rgba(236,222,255,0.75);
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
	
#background
{
	position: relative;/*因為有這個，下面的#close才可以進行定在#background裡面*/
    width: 480px;
    height: 480px;
    background-color: rgba(255,255,255,0.75);
    display: flex;/*更靈活的方式控制元素的排列方式*/
    flex-direction: column;/*照垂直方向排列*/
    justify-content: center;/*垂直置中*/
    align-items: center;/*水平置中*/
	margin-top: 3cm; /* 設定上邊距為 10 公分 */
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
	
	$caccount = $_SESSION['caccount']; // 從 SESSION 中取得 caccount
	if(empty($caccount))
	{
		echo "<script> alert('查無此帳號'); window.location.href = 'login register.php'; </script>";
		exit;
	}
	
	$sql_query = "SELECT * FROM register WHERE caccount = '$caccount'";//如果使用者輸入的帳號與資料庫的帳號相等
	$result = mysqli_query($db_link, $sql_query);
	if($result)
	{
		$row = mysqli_fetch_assoc($result);
		$cname = $row['cname'];
		$cnumber = $row['cnumber'];
		$cgender = $row['cgender'];
		$caccount = $row['caccount'];
		$cpassword = $row['cpassword'];
	}
?>
<div id = "background">
	<form method="POST" action="">
	姓　　名：
	<input type = "text" name = "cname" value="<?php echo $cname;?>">
	<br/>
	<br/>
	手機號碼：   
	<input type="number" name="cnumber" value="<?php echo $cnumber;?>">
	<br/>
	<br/>
	性　　別：   
	<?php if ($cgender=="F") echo"女性";?>
	<?php if ($cgender=="M") echo"男性";?>
	<br/>
	<br/>
	帳　　號：   
	<?php echo $caccount;?>
	<br/>
	<br/>
	密　　碼：   
	<input type = "password" name = "cpassword" placeholder="至少3個英文字、5個數字" value="<?php echo $cpassword;?>" >
	<br/>
	<br/>
	確認密碼：
	<input type = "password" name = "cpassword2" placeholder="再輸入一次修改的密碼" >
	<br/>
	<br/>
	<input name = "cID" type="hidden" value="<?php echo $cID;?>">
	<input name = "action" type="hidden" value="update">
	<input name = "renew" type="submit" value="更新資料" style="width: 255px; height: 30px; font-size: 16px;">
	</from>
</div>
<?php
		
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
	
	if(isset($_POST['renew']))
	{
		$cname = $_POST['cname'];
		$cnumber = $_POST['cnumber'];
		$cgender = $_POST['cgender'];
		$cpassword = $_POST['cpassword'];
		$cpassword2 = $_POST['cpassword2'];
		
		if($cpassword == $caccount)
		{
			
			echo "<script>alert('帳號密碼請勿輸入一樣的'); window.location.href = 'cmember.php';</script>";
			//顯示錯誤，並且將頁面重新導入register.php裡面
			return;
		}
		
		if($cname === '' OR $cnumber === '' OR  $cgender === '' OR $cpassword === '')
		{
			
			echo "<script>alert('請確實填寫註冊資料'); window.location.href = 'cmember.php';</script>";
			//顯示錯誤，並且將頁面重新導入register.php裡面
			return;
		}
		
		if (!preg_match('/^09\d{8}$/', $cnumber))
		{
			echo "<script>alert('手機號碼：以09開頭輸入10位數字'); window.location.href = 'cmember.php';</script>";
			return;
		}
		
		if(preg_match('/[\p{Han}]/u',$cpassword))
		{
			echo"<script>alert('密碼請勿輸入中文'); window.location.href = 'cmember.php';</script>";
			return;
		}
		if(preg_match('/[\p{Han}]/u',$cpassword2))
		{
			echo"<script>alert('確認密碼請勿輸入中文'); window.location.href = 'cmember.php';</script>";
			return;
		}
		
		if (!preg_match('/^(?=(?:.*[a-zA-Z]){3})(?=(?:.*[0-9]){5})[a-zA-Z0-9]{8,}$/', $cpassword))
		//^(?=(?:.*[a-zA-Z]){3})：確保總共有3個英文字母，(?=(?:.*[0-9]){5})：確保5個數字，[a-zA-Z0-9]{8,}：確保包含至少八個英文字母和數字
		{
			echo"<script>alert('密碼至少輸入：3個英文字、5個數字'); window.location.href = 'cmember.php';</script>";
			return;
		}
		
		if($cpassword != $row['cpassword'])//如果有更改密碼
		{
			if($cpassword != $cpassword2)//密碼不等於確認密碼
			{
				echo"<script>alert('確認密碼請輸入正確'); window.location.href = 'cmember.php';</script>";
				return;
			}
		}
		if ($cpassword == $row['cpassword'] && $cpassword2 != '')//如果沒有修改密碼的話，確認密碼不可以輸入東西
		{
			echo "<script>alert('未修改密碼，請勿輸入確認密碼'); window.location.href = 'cmember.php';</script>";
			return;
		}

		$sql_query_update = "UPDATE register SET cname='$cname', cnumber='$cnumber', caccount='$caccount',cpassword='$cpassword' WHERE caccount = '$caccount'";
		$result_update = mysqli_query($db_link, $sql_query_update);
		echo"<script>alert('資料更新成功'); window.location.href = 'loginok.php';</script>";
	}
?>
</body>
</html>
<?php
	if (isset($stmt)) 
	{
		$stmt->close();
	}
	if (isset($db_link)) 
	{
		$db_link->close();
	}
?>