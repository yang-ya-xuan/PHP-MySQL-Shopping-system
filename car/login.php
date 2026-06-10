<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>無標題文件</title>
<style type="text/css">
	
body {
    display: flex;
    justify-content: center; /* 水平置中 */
    /*align-items: center;  //垂直置中 */
    min-height: 100vh; /* 最小設定為視窗的高度，才不會超過 */
    margin: 0; /* 是將元素的外邊距設為零(沒有間距) */
    background-color: #C2E4FD;
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
	
#background
{
    position: relative;/*因為有這個，下面的#close才可以進行定在#background裡面*/
    width: 400px;
    height: 400px;
    background-color: rgba(255,255,255,0.75);
    display: flex;/*更靈活的方式控制元素的排列方式*/
    flex-direction: column;/*照垂直方向排列*/
    justify-content: center;/*垂直置中*/
    align-items: center;/*水平置中*/
	margin-top: 3cm; /* 設定上邊距為 3公分 */
}

#close
{
	position: absolute;/*相對於#background的位置進行定位，絕對定位的元素不會影響其他元素的佈局。*/
    top: 10px;
    right: 10px;
    text-decoration: none;/*取消超連結的下劃線效果*/
    color: blue;
    font-size: 14px;
}

</style>

</head>

	<script src="http://code.jquery.com/jquery-3.4.1.min.js">
	</script>
	
<style type ="text/css">
	.Yes{
		border:#3F0 5px solid;
		color:#3F0;
	}
	.No{
		border:#F00 5px solid;
		color:#F00;
	}
</style>

<body>

<div id="up">
	<div style="display: flex; align-items: center;">
		<a href="index.php"><img src="ha/top.png" width="65" height="65" alt=""/></a>
		<a href="index.php" style="color: green; font-size: 30px; text-decoration: none;">蔬</a>
		<a href="index.php" style="color: red; font-size: 30px; text-decoration: none;">果</a>
		<a href="index.php" style="color: purple; font-size: 30px; text-decoration: none;">行</a>
	</div>
</div>

	
<div id="background">
	
	<a id="close" href="index.php">返回</a>
	<span style="font-size: 22px; font-weight: bold;">帳號登入</span>
	<br/>
<?php
	session_start();
	if(!isset($_SESSION['caccount']))//如果沒有帳號
	{
?>
<form method="POST" action="">
	帳號：
  	<input type="text" name="caccount" id = "name_text" value="<?php echo isset($_POST['caccount']) ? $_POST['caccount'] : ''; ?>" required>
	<br/>
	<br/>
	密碼：
  	<input type = "password" name = "cpassword"/>
	<br/>
	<br/>
	<br/>
  	<input type="submit" value="登入" name="login" style="width: 222px; height: 30px; font-size: 16px;">
	<br/>
</form>
<?php
	}
?>
</div>

<?php
//===============按下登入按鈕後(登入的東西)===============
	if(isset($_SESSION['caccount']))
	{
		if (strpos($_SESSION['caccount'], '@') !== false)
		{
			$hurl="hloginok.php";
			echo "<script>alert('目前" . $_SESSION['caccount'] . "正在登入，請稍後再試');</script>";
			echo"<script>window.location.href = '$hurl';</script>";
		}
		else
		{
			$url="loginok.php";
			//echo "<script>alert('目前" . $_SESSION['caccount'] . "正在登入，請稍後再試');</script>";
			//echo"<script>window.location.href = 'loginok.php';</script>";
			echo"<script> window.location.href = '$url'; alert('目前" . $_SESSION['caccount'] . "正在登入，請稍後再試');</script>";
		}
		
		
	}//如果沒有帳號正在登入
	else
	{
		if(isset($_POST["login"]))
		{
			include("database.php");

			$caccount = $_POST["caccount"];
			$cpassword = $_POST["cpassword"];

			
			$sql_query = "SELECT * FROM register WHERE caccount ='$caccount' AND cpassword ='$cpassword'";
			$result = mysqli_query($db_link, $sql_query);

			$sql_query_caccount = "select * from register WHERE caccount ='$caccount'";
			$result_caccount = mysqli_query($db_link, $sql_query_caccount);

			$sql_query_cpassword = "select * from register WHERE cpassword ='$cpassword'";
			$result_cpassword = mysqli_query($db_link, $sql_query_cpassword);

			if($caccount === '' OR $cpassword === '')
			{
				echo "<script>alert('請確實填寫註冊資料');</script>";
				//顯示錯誤，並且將頁面重新導入register.php裡面
				return;
			}

			if(mysqli_num_rows($result) == 0)//如果帳號跟密碼沒找到一樣的
			{
				if (mysqli_num_rows($result_caccount) == 0) //如果帳號錯誤
				{
					echo"<script>alert('找不到此帳號');</script>";
					$acaccount = '';
					return;
				}
				if (mysqli_num_rows($result_cpassword) == 0) //如果密碼錯誤
				{
					echo"<script>alert('密碼錯誤');</script>";
					return;
				}
				echo"<script>alert('帳號密碼請輸入正確');</script>";
				//如果輸入資料庫有的資料但兩個是不一樣的話，不會顯示(兩個不一樣的意思是 a帳號對上b密碼)
				return;
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
					echo "<script> alert('$caccount 被禁用，請聯絡管理者');</script>";
					return;
				}
			}

			//後端
			$sql_query = "SELECT * FROM register WHERE caccount = '$caccount'";//如果使用者輸入的帳號與資料庫的帳號相等
			$result = mysqli_query($db_link, $sql_query);
			if($result)
			{
				$row = mysqli_fetch_assoc($result);
				$promotion = $row['promotion'];
			}
			if ($promotion === '1' or $promotion === '2')
			{
				echo"<script>alert('$caccount 後端登入成功'); window.location.href = 'hloginok.php';</script>";
				$_SESSION['caccount'] = $caccount;
				$_SESSION['cpassword'] = $cpassword;
			}

			else
			{	//如果上面都對
				$url="loginok.php";
				//echo "<script>alert('目前" . $_SESSION['caccount'] . "正在登入，請稍後再試');</script>";
				//echo"<script>window.location.href = 'loginok.php';</script>";
				echo"<script> window.location.href = '$url'; alert('登入成功');</script>";
				//echo"<script>alert('登入成功'); window.location.href = 'loginok.php';</script>";
				$_SESSION['caccount'] = $caccount;
				$_SESSION['cpassword'] = $cpassword;
				
			}
		}
	}
	
	
?>

</body>
			
</html>
<script>
	$('#name_text').on("keyup",function()
	{
		var target_data = $(this).val();//this是處理name_text(取得輸入框的值)
		console.log("target:",target_data);
		$.ajax({
			url:'logintest.php',//連結到什麼地方
			type:'POST',
			dataType:'json',
			data:{'data':target_data}//資料內容
		}).done(function(data){//把資料傳到這個網頁後
		
		if(data)
		{
			$("#name_text").removeClass("No").addClass("Yes");//如果$return_data是true的話(登入的帳號等於資料庫裡的帳號)就把no刪掉，加上yes
		}
		else
		{
			$("#name_text").removeClass("Yes").addClass("No");
		}
		console.log("data:",data);
		
	}).fail(function(rerror){
			console.log("error",error);
			})
	})
</script>
			
