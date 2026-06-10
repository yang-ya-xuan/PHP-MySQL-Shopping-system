<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>無標題文件</title>
<style type="text/css">
body {
    display: flex;
    justify-content: center; /* 水平置中 */
    /*align-items: center; //垂直置中 */
    min-height: 100vh; /* 最小設定為視窗的高度，才不會超過 */
    margin: 0; /* 是將元素的外邊距設為零(沒有間距) */
    background-color: #FEECFF;
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
    width: 480px;
    height: 480px;
    background-color: rgba(255,255,255,0.75);
    display: flex;/*更靈活的方式控制元素的排列方式*/
    flex-direction: column;/*照垂直方向排列*/
    justify-content: center;/*垂直置中*/
    align-items: center;/*水平置中*/
	margin-top: 3cm; /* 設定上邊距為 10 公分 */
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
		<a href="<?php echo 'loginok.php'; ?>"><img src="ha/top.png" width="65" height="65" alt=""/></a>
		<a href="<?php echo 'loginok.php'; ?>" style="color: green; font-size: 30px; text-decoration: none;">蔬</a>
		<a href="<?php echo 'loginok.php'; ?>" style="color: red; font-size: 30px; text-decoration: none;">果</a>
		<a href="<?php echo 'loginok.php'; ?>" style="color: purple; font-size: 30px; text-decoration: none;">行</a>
	</div>
</div>
	
<div id = "background">
	<a id="close" href="index.php">返回</a>
	<span style="font-size: 22px; font-weight: bold;">帳號註冊</span>
	<br/>
	
<form method="POST" action="">
	姓　　名：
	<input type = "text" name = "cname" value="<?php echo isset($_POST['cname']) ? $_POST['cname'] : ''; ?>" required>
	<br/>
	<br/>
	手機號碼：   
	<input type="number" name="cnumber" placeholder="台灣地區" value="<?php echo isset($_POST['cnumber']) ? $_POST['cnumber'] : ''; ?>" required>
	<br/>
	<br/>
	性　　別：   
	<input type="radio" name="cgender" value="F" checked>女性
	<input type="radio" name="cgender" value="M"> 男性
	<br/>
	<br/>
	帳　　號：   
	<input type = "text" name = "caccount" id="caccount" value="<?php echo isset($_POST['caccount']) ? $_POST['caccount'] : ''; ?>" required>
	<br/>
	<br/>
	密　　碼：   
  	<input type = "password" name = "cpassword" id = "cpassword" placeholder="至少3個英文字+5個數字">
	<br/>
	<br/>
	確認密碼：
  	<input type = "password" name = "cpassword2" id = "cpassword2" placeholder="再輸入一次密碼">
	<br/>
	<br/>
	<br/>
	<input type="submit" value="註冊" name="register" style="width: 255px; height: 30px; font-size: 16px;">
</form>
</div>
<?php
//===============按下註冊按鈕後(註冊的東西)===============
	session_start();
	
	if (isset($_POST['register']))//如果按下註冊
	{
		include("database.php");
		
		$cname = $_POST["cname"];
		$cnumber = $_POST["cnumber"];
		$cgender = $_POST["cgender"];
		$caccount = $_POST["caccount"];
		$cpassword = $_POST["cpassword"];
		$cpassword2 = $_POST["cpassword2"];
		
		if($cname === '' OR $cnumber === '' OR  $caccount === '' OR $cpassword === '' OR $cpassword2 === '')
		{
			
			echo "<script>alert('請確實填寫註冊資料')</script>";
			//顯示錯誤，並且將頁面重新導入register.php裡面
			return;
		}
		
		if (!preg_match('/^09\d{8}$/', $cnumber))
		{
			echo "<script>alert('手機號碼：以09開頭輸入10位數字')</script>";
			return;
		}
		
		$sql_query_check = "SELECT * FROM register WHERE caccount = '$caccount'";//如果帳號一樣
		$result_check = mysqli_query($db_link, $sql_query_check);
		if (mysqli_num_rows($result_check) > 0)//如果帳號資料大於0
		{
			echo"<script>alert('請勿重複註冊相同的帳號')</script>";
			return;
		}
		
		if (!preg_match('/^(?=(?:.*[a-zA-Z]){3})(?=(?:.*[0-9]){5})[a-zA-Z0-9]{8,}$/', $cpassword))
		//^(?=(?:.*[a-zA-Z]){3})：確保總共有3個英文字母，(?=(?:.*[0-9]){5})：確保5個數字，[a-zA-Z0-9]{8,}：確保包含至少八個英文字母和數字
		{
			echo"<script>alert('密碼至少輸入：3個英文字、5個數字')</script>";
			return;
		}	
		
		if($cpassword != $cpassword2)
		{
			echo"<script>alert('確認密碼請輸入正確')</script>";
			return;
		}
		
		if($caccount == $cpassword)
		{
			echo"<script>alert('帳號密碼請勿輸入相同')</script>";
			return;
		}
		
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
		if(preg_match('/[\p{Han}]/u',$cpassword2))
		{
			echo"<script>alert('確認密碼請勿輸入中文')</script>";
			return;
		}
		
		if (strpos($caccount, '@') !== false)//如果帳號裡面有@
		{
        	echo"<script>alert('帳號請勿輸入@')</script>";
			return;
    	}
		
		//如果上面都對
		echo"<script>alert('註冊成功，請登入帳號'); window.location.href = 'login.php';</script>";
			
		$sql_query="select * FROM register";

		if ($cgender === "F")//如果按了女生
		{
			$cgender = "F";//就將整個性別變成女生後代入資料庫
		} 
		elseif ($cgender === "M")
		{
			$cgender = "M";
		}

		$sql = "INSERT INTO register (cname,cnumber,cgender,caccount,cpassword) 
				VALUES ('$cname', '$cnumber','$cgender','$caccount','$cpassword')";
		//將使用者輸入的資料放入資料表的各個欄位
		mysqli_query($db_link, $sql);//將sql裡的資料送到資料庫裡面
		$stmt -> execute();
	}	
?>

</body>
	<script>
	$('#caccount, #cpassword').on("keyup", function()
	{
		var target_data = $('#caccount').val();
		var password_data = $('#cpassword').val();
		
		console.log("target:", target_data);
		console.log("password:", password_data);
		
		$.ajax({
			url: 'registertest.php',
			type: 'POST',
			dataType: 'json',
			data: {'data': target_data, 'cpassword': password_data}// 將密碼也傳遞到後端
		}).done(function(data) {
			if (data)
			{
				$("#caccount").removeClass("No").addClass("Yes");
			}
			else
			{
				$("#caccount").removeClass("Yes").addClass("No");
			}
			console.log("data:", data);
			
		}).fail(function(error) {
			console.log("error", error);
		});
	})
</script>

	
<script>
	$('#caccount,#cpassword, #cpassword2').on("keyup", function()
	{
		var target_data = $('#caccount').val();
		var cpassword1_data = $('#cpassword').val();
		var cpassword2_data = $('#cpassword2').val();
		
		console.log("target:", target_data);
		console.log("cpassword1:", cpassword1_data);
		console.log("cpassword2:", cpassword2_data);

		$.ajax({
			url: 'registertest2.php',
			type: 'POST',
			dataType: 'json',
			data: {'data': target_data, 'cpassword1': cpassword1_data, 'cpassword2': cpassword2_data}
		}).done(function(data) {
        if (data)
		{
			$("#cpassword").removeClass("No").addClass("Yes");
		}
		else
		{
			$("#cpassword").removeClass("Yes").addClass("No");
		}


        console.log("cpassword1:", data);

		}).fail(function(error) {
			console.log("error", error);
		});
	})

</script>
	
</html>