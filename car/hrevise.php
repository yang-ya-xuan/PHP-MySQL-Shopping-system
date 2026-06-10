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
</head>

<body>
	
	<h1 align = "center">使用者資料修改_後端</h1>
	<p align = "center"><a href="hmaterial.php">返回</a></p>
<?php
//==========後端修改會員資料==========
	include("database.php");
	session_start();
	
	if (isset($_SESSION['caccount']))
	{
		$scaccount = $_SESSION['caccount'];//計錄目前登入的帳號
	}
	if(!isset($_SESSION['caccount']))
	{
		echo "<script>alert('請先登入喔');</script>";
		echo "<script> window.location.href = 'index.php';</script>";
	}
	
	elseif(empty($_GET['id']))
	{
		echo "<script> alert('查無此商品'); window.location.href = 'hloginok.php'; </script>";
		exit;
	}
	
	$sql_select = "select cID, cname, cnumber, cgender, caccount,cpassword, disabled FROM register WHERE cID=?";
	//只選取符合特定 cID 的資料。
	$stmt = $db_link -> prepare($sql_select);//將語句傳遞給資料庫連接，以便後續的執行。
	$stmt -> bind_param("i",$_GET["id"]);//i：整數，這樣查詢中的 cID=? 就會被實際的 $_GET["id"] 值替換。
	$stmt -> execute();//將綁定的值插入到查詢中
	$stmt -> bind_result($cID, $cname, $cnumber, $cgender, $caccount, $cpassword, $disabled);
	//將查詢結果的不同欄位值綁定到對應的變數中
	$stmt ->fetch();//取出資料
	$stmt->close();
?>
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
	<input type = "password" name = "cpassword" placeholder="至少3個英文字、5個數字" value="<?php echo $cpassword;?>" readonly>
	<br/>
	<br/>
	<input name = "renew" type="submit" value="確定更新" style="width: 255px; font-size: 16px;">
	<br/>
	<br/>
    
</form>
</from>
	
<?php
	
		
	$sql_query = "SELECT * FROM register WHERE caccount = '$scaccount'";//如果使用者輸入的帳號與資料庫的帳號相等
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
	
	$sql_query = "SELECT * FROM register WHERE caccount = '$caccount'";//如果使用者輸入的帳號與資料庫的帳號相等
	$result = mysqli_query($db_link, $sql_query);
	if($result)
	{
		$row = mysqli_fetch_assoc($result);
		$promotion = $row['promotion'];
	}
	//如果不是最大管理者的話，沒辦法處理要變成使用者還是管理者，只能更改資料
	if (strpos($scaccount, '@admin') !== false)
	{
		if (strpos($caccount, '@admin') === false &&  $promotion === '0' && $disabled === 'Y')
		//如果帳號不包含@admin(不是最大的管理者)，以及沒有@(沒有升級過)，才需要升級
		{
			?>
			<form method="POST" action="">
			<input type="submit" name="upgrade" value="變為管理者" style="width: 127px;font-size: 16px;">
			</from>
			<?php
		}
		if (strpos($caccount, '@admin') === false && $promotion === '1' && $disabled === 'Y')
		//如果帳號不包含@admin(不是最大的管理者)並且有@
		{
			?>
			<form method="POST" action="">
			<input type="submit" name="down" value="變為使用者" style="width: 127px;font-size: 16px;">
			</from>
			<?php
		}
		
		//是要最大管理者才可以禁用別人，N:禁用，Y：沒禁用
		if (strpos($caccount, '@admin') === false && $disabled === 'Y' && $promotion === '0')
		{
			?>
			<form method="POST" action="">
			<input type="submit" name="disabled" value="禁用" style="width: 127px;font-size: 16px;">
			</from>
			<?php
		}
		//解禁
		if (strpos($caccount, '@admin') === false && $disabled === 'N')
		{
			?>
			<form method="POST" action="">
			<input type="submit" name="noban" value="解禁" style="width: 127px;font-size: 16px;">
			</from>
			<?php
		}
		
		//使用者變成管理者
		if (isset($_POST['upgrade'])) 
		{
			//$upcaccount = '@'.$caccount;
			$sql_query = "UPDATE register SET caccount=? WHERE cID=?";
			$stmt = $db_link->prepare($sql_query);
			//更新資料庫中的 register 表格。(?：之後會透過綁定參數將實際的值填入)
			$stmt->bind_param("si",$caccount,$_GET["id"]);
			//將這裡的值(使用者輸入)給上面的問號，就可以更新了。"ssssssi" 是指這些值的型別，其中 "s" 表示字串，"i" 表示整數。
			$stmt -> execute();//將綁定的值插入到資料庫中
			$stmt -> close();// 關閉已經執行的 SQL 查詢
			
			//更新購物車的帳號名稱
			/*$sql_query_ccar = "UPDATE ccar SET caccount=? WHERE caccount=?";
			$stmt_ccar = $db_link->prepare($sql_query_ccar);
			$stmt_ccar->bind_param("ss", $upcaccount, $caccount);
			$stmt_ccar->execute();
			$stmt_ccar->close();*/
			
			//更新訂單管理的帳號名稱
			/*$sql_query_corder = "UPDATE corder SET caccount=? WHERE caccount=?";
			$stmt_corder = $db_link->prepare($sql_query_corder);
			$stmt_corder->bind_param("ss", $upcaccount, $caccount);
			$stmt_corder->execute();
			$stmt_corder->close();*/
			
			//把帳號狀態改為管理者狀態
			$sql_query_register = "UPDATE register SET promotion = '1' WHERE caccount=?";
			$stmt_register = $db_link->prepare($sql_query_register);
			$stmt_register->bind_param("s", $caccount);
			$stmt_register->execute();
			$stmt_register->close();
			
			$db_link ->close();//關閉資料庫連接
			echo"<script>alert('$caccount 變為管理者'); window.location.href = 'hmaterial.php';</script>";
		}

		//管理者變成使用者
		if (isset($_POST['down'])) 
		{
			//$downcaccount = str_replace('@', '', $caccount);
			
			$sql_query = "UPDATE register SET caccount=? WHERE cID=?";
			$stmt = $db_link->prepare($sql_query);
			//更新資料庫中的 register 表格。(?：之後會透過綁定參數將實際的值填入)
			$stmt->bind_param("si",$caccount,$_GET["id"]);
			//將這裡的值(使用者輸入)給上面的問號，就可以更新了。"ssssssi" 是指這些值的型別，其中 "s" 表示字串，"i" 表示整數。
			$stmt -> execute();//將綁定的值插入到資料庫中
			$stmt -> close();// 關閉已經執行的 SQL 查詢
			
			/*$sql_query_ccar = "UPDATE ccar SET caccount=? WHERE caccount=?";
			$stmt_ccar = $db_link->prepare($sql_query_ccar);
			$stmt_ccar->bind_param("ss", $downcaccount, $caccount);
			$stmt_ccar->execute();
			$stmt_ccar->close();*/
			
			/*$sql_query_corder = "UPDATE corder SET caccount=? WHERE caccount=?";
			$stmt_corder = $db_link->prepare($sql_query_corder);
			$stmt_corder->bind_param("ss", $downcaccount, $caccount);
			$stmt_corder->execute();
			$stmt_corder->close();*/
			
			//把帳號狀態改為使用者狀態
			$sql_query_register = "UPDATE register SET promotion = '0' WHERE caccount=?";
			$stmt_register = $db_link->prepare($sql_query_register);
			$stmt_register->bind_param("s", $caccount);
			$stmt_register->execute();
			$stmt_register->close();
			
			$db_link ->close();//關閉資料庫連接
			echo"<script>alert('$caccount 變為使用者'); window.location.href = 'hmaterial.php';</script>";
		}
	}
	if(isset($_POST['renew']))
	{
		$caccount = $_POST['caccount'];
	$cpassword = $_POST['cpassword'];
	
	
	if(preg_match('/[\p{Han}]/u',$caccount))
		{
			echo"<script>alert('帳號請勿輸入中文')</script>";
			return;
		}
		if(preg_match('/[\p{Han}]/u',$cpassword))
		{
			echo"<script>alert('密碼請勿輸入中文')</script>";
			return;
		}
		
		$sql_query_update = "UPDATE register SET cname='$cname', cnumber='$cnumber', cgender='$cgender', caccount='$caccount',cpassword='$cpassword' WHERE caccount = '$caccount'";
		$result_update = mysqli_query($db_link, $sql_query_update);
		echo"<script>alert('資料更新成功'); window.location.href = 'hmaterial.php';</script>";
		
	}
	
	//如果禁用別人
	if(isset($_POST['disabled']))
	{
		$update_query = "UPDATE register SET disabled = 'N' WHERE cID = ?";
    	$update_stmt = $db_link->prepare($update_query);
    	$update_stmt->bind_param("s", $_GET["id"]);
		if ($update_stmt->execute())
		{
			echo "<script>alert('$cname 已被禁用'); window.location.href = 'hmaterial.php';</script>";
		}
		else
		{
			echo"<script> alert('$cname 禁用失敗'); window.location.href = 'hmaterial.php';</script>";
		}
		$update_stmt->close();
	}
	
	if(isset($_POST['noban']))
	{
		$update_query = "UPDATE register SET disabled = 'Y' WHERE cID = ?";
    	$update_stmt = $db_link->prepare($update_query);
    	$update_stmt->bind_param("s", $_GET["id"]);
		if ($update_stmt->execute())
		{
			echo "<script>alert('$cname 解禁成功'); window.location.href = 'hmaterial.php';</script>";
		}
		else
		{
			echo"<script> alert('$cname 解禁失敗'); window.location.href = 'hmaterial.php';</script>";
		}
		$update_stmt->close();
	}
?>
</body>
</html>

<?php
	//$stmt->close();
    //$db_link -> close();
?>