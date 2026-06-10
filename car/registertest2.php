<?php
include("database.php");

if(isset($_POST["cpassword1"]))
{
	$password_data = $_POST["data"];
   $cpassword1_len = $_POST["cpassword1"];
   $cpassword2_len = $_POST["cpassword2"];
	
	
    $sql_query_check = "SELECT * FROM register WHERE caccount = '$cpassword1_len'";
    $result_check = mysqli_query($db_link, $sql_query_check);
    
    $return1_data = true; // 預設值為 true，只有在檢查條件時發現問題時才設置為 false
    

	if (!preg_match('/^(?=(?:.*[a-zA-Z]){3})(?=(?:.*[0-9]){5})[a-zA-Z0-9]{8,}$/', $cpassword1_len))
	{
		$return1_data = false;
	}
	
	if($cpassword1_len != $cpassword2_len)
	{
		$return1_data = false;
	}
	
	if($password_data == $cpassword1_len)
	{
		$return1_data = false;
	}
	
	if(preg_match('/[\p{Han}]/u',$cpassword1_len))
	{
		$return1_data = false;
	}
	
    echo json_encode($return1_data);
}
?>
