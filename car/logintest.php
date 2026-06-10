<?php
include("database.php");
$test = "select caccount from register";
$select_test = mysqli_query($db_link, $test);//執行一個 MySQL 查詢，存在$select_test


	if(isset($_POST["data"]))
	{
		
		$data_len = $_POST["data"];
		foreach($select_test as $row)//一筆一筆資料檢查
		{
			if( $row['caccount'] === $data_len)
			{
				$return_data = true;
				break;//中斷迴圈
			}
			else
			{
				$return_data = false;
			}
				
		}
		echo json_encode($return_data);//再把值傳回前面
	}
?>