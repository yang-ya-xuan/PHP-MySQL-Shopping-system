<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>無標題文件</title>
<style type="text/css">
body {
    background-color: rgba(211,248,255,0.75);
}
	
	
#background
{
    position: relative;/*因為有這個，下面的#close才可以進行定在#background裡面*/
    width: 450px;
    height: 450px;
    background-color: rgba(255,255,255,0.75);
    display: flex;/*更靈活的方式控制元素的排列方式*/
    flex-direction: column;/*照垂直方向排列*/
    justify-content: center;/*垂直置中*/
    align-items: center;/*水平置中*/
	margin-top: 3cm; /* 設定上邊距為 3公分 */
	margin: 0 auto; /* 將 div 水平置中 */
}

#background form {
    text-align: center; /* 將表單內容文字水平置中 */
}
	
</style>
</head>

<body>
	<h1 align = "center">商品上傳_後端</h1>
	<p align = "center"><a href="hloginok.php">回到首頁</a></p>
<?php
    include("database.php");
    session_start();
    if (isset($_SESSION['caccount']))
    {
        $caccount = $_SESSION['caccount'];
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
	
?>
<div id="background">
	<form action="upload2.php" method="POST" enctype="multipart/form-data">
		名稱：
		<input type="text" name="name"/>
		<br/>
		<br/>
		價格：
		<input type="number" name="price"/>
		<br/>
		<br/>
		說明：
		<textarea name="cexplain" rows="4" cols="20"></textarea>
		<br/>
		<br/>
		庫存：
	  	<input type="number" name="quantity"/>
		<br/>
		<br/>
		圖片：
		<input type='file' name='image' accept='image/*' required/>
		<br/>
		<br/>
		<input type="submit" value="送出" name="go" style="width: 222px; height: 30px; font-size: 16px;">
	</form>
</div>
</body>

</html>