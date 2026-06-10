<?php
include("database.php");
$foodname = "SELECT name FROM commodity WHERE ud = 'up'";
$select_foodname = mysqli_query($db_link, $foodname);


// 檢查是否有 POST 資料
	if(isset($_POST["data"]))
	{
		$data_len = $_POST["data"];
		$equal = array();//儲存搜尋到的商品
		if (!empty($data_len))
		{
			foreach($select_foodname as $row)//一筆一筆資料檢查
			{
				if(stripos($row['name'], $data_len) !== false)//在$row['name']中找$data_len，如果找到了，就返回子字串在母字串中的位置
				{
					//$return_data = true;
					$equal[] = $row['name'];//將一樣的商品名稱放到$equal裡面
					//break;//中斷迴圈
				}
				else
				{
					//$return_data = false;
				}

			}
		}
		
		//echo json_encode($return_data);//再把值傳回前面
		echo json_encode($equal);
	}
?>

