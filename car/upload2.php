<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>無標題文件</title>
<style type="text/css">
	
body 
{
    background-color: rgba(255,229,236,0.75);
}
td.description 
{
    max-width: 150px;
    word-wrap: break-word;
}
td, th 
{
    text-align: center;
    vertical-align: middle; /* 垂直居中對齊 */
}
</style>
</head>

<body>
	
<?php
//==========後端查看所有商品==========
	session_start();
	include("database.php");
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
	
	$sql_query="select * FROM commodity";
	$select_result = mysqli_query($db_link, $sql_query);
	
	// 初始化 session 變數
	if (!isset($_SESSION['uploaded_data'])) 
	{
		$_SESSION['uploaded_data'] = array();
	}

	if (isset($_POST['go'])) 
	{
		//如果沒有確實填寫上傳資料
		$name = $_POST['name'];
		$price = $_POST['price'];
		$cexplain = $_POST['cexplain'];
		$quantity = $_POST['quantity'];
		if($name === '' OR $price === '' OR  $cexplain === '' OR $quantity === '')
		{
			echo "<script>alert('請確實填寫註冊資料'); window.location.href = 'upload.php';</script>";
			return;
		}
		
		//檢查圖片副檔名
		$allimage = array("image/jpeg", "image/jpg", "image/png", "image/gif");
		if (!in_array($_FILES["image"]["type"], $allimage)) 
		{
			echo "<script>alert('只允許上傳JPEG、JPG、PNG和GIF格式的圖片'); window.location.href = 'upload.php';</script>";
			return;
		}
		
		// 檢查是否為正方形
		list($width, $height) = getimagesize($_FILES["image"]["tmp_name"]);
		if ($width !== $height) 
		{
			echo "<script>alert('圖片必須是正方形'); window.location.href = 'upload.php';</script>";
			return;
		}
		
		$maxFileSize = 1 * 1024 * 1024 ; // 1MB，以位元組為單位
		if ($_FILES["image"]["size"] > $maxFileSize) 
		{
			echo "<script>alert('檔案請勿超過1MB'); window.location.href = 'upload.php';</script>";
			return;
		}
		
		// 如果通過所有檢查，則上傳圖片
		$filename = $_FILES["image"]["name"];
		$path = "upload/" . $filename;
		move_uploaded_file($_FILES["image"]["tmp_name"], $path);

		

		
		$name = $_POST["name"];
		$price = $_POST["price"];
		$cexplain = $_POST["cexplain"];
		$quantity = $_POST["quantity"];
		
		$sql_insert = "INSERT INTO commodity (name, price, cexplain, quantity, image) VALUES (?, ?, ?, ?,?)";
        $stmt = $db_link->prepare($sql_insert);
        $stmt->bind_param("sisis", $name, $price, $cexplain, $quantity, $path);
        $stmt->execute();//將綁定的值插入到查詢中
        $stmt->close();
        $db_link->close();
	}
		
		
		/*if ($result)//用來確認之前的資料插入操作是否成功
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
	}*/
	
//==========刪除商品==========
	/*if (isset($_POST['delete'])) 
	{
		$deletetext = $_POST["deletetext"];
		$updated_uploaded_data = array();//是一個空的 PHP 陣列變數，用於暫存更新後的商品資料
		foreach ($_SESSION['uploaded_data'] as $data)//檢查所有資料並將資料放入$data
		{
			if ($deletetext != $data["name"])//如果使用者輸入要刪除的資料不等於原本的姓名資料的話(相反：如果使用者要刪掉的姓名=原本就有的資料姓名，就刪除那項資料)
			{
				$updated_uploaded_data[] = $data;//將不需刪除的商品重新加入到新陣列中(因為不等於所以if出來的東西是不用刪的)
				
				//刪除料庫東西
				$delete_sql = "DELETE FROM commodity WHERE name = '$deletetext'";//刪除那些：名字=輸入的名字的資料
				$delete_result = mysqli_query($db_link, $delete_sql);
				if (!$delete_result) 
				{
					echo "<script>alert('無法從資料庫刪除')</script>";
				}
			}
		}
		$_SESSION['uploaded_data'] = $updated_uploaded_data;//將不需要刪除的商品資料加入到這個新的陣列中
	}*/
	
?>

<?php
//==========後端查看所有會員資料==========
	include("database.php");
	$sql_query="select * FROM commodity";
	$select_result = mysqli_query($db_link, $sql_query);
	$total_record = $select_result -> num_rows;//計算有幾筆資料
?>
	<h1 align = "center">商品資料_後端</h1>
	<p align = "center">目前共有：<?php echo $total_record; ?>種商品
	<table border="2" align="center" style="width: 70%; border-collapse: collapse;">
	<p align = "center"><a href="hloginok.php">回到首頁</a></p>

  <tr style="background-color: rgba(220,232,251,0.75);">
    <th height="40">編號</th>
	<th>名稱</th>
  	<th>價格</th>
  	<th>說明</th>
	<th>庫存</th>
	<th>圖片</th>
	<th>上架/下架</th>
  	<th>功能</th>
	</tr>
<?php
	
	
	while ($row = mysqli_fetch_assoc($select_result))
	{
		echo "<tr>";
		echo "<td>".$row['cID']."</td>";
		echo "<td>".$row['name']."</td>";
		echo "<td>".$row['price']."</td>";
		echo "<td class='description'>".$row['cexplain']."</td>";//要讓他一行不能太長
		echo "<td>".$row['quantity']."</td>";
		echo "<td><img src='".$row['image']."' alt='商品圖片' width='100'></td>"; // 顯示圖片
		
		if ($row['ud'] == "up")
		{
			echo "<td>上架中</td>";
		} 
		elseif ($row['ud'] == "down")
		{
			echo "<td>下架中</td>";
		}
		
		echo"<td><a href='upload3.php?id=".$row['cID']."'>修改</a>";//附帶一個參數id，參數的值是該行資料的cID欄位的值
		echo '　|　';
		echo"<a href='upload4.php?id=".$row['cID']."'>刪除</a></td>";
	}
	
?>
	

</body>
</html>