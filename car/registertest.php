<?php
include("database.php");

if(isset($_POST["data"]))
{
   $data_len = $_POST["data"];
   $password_data = $_POST["cpassword"];
	
    $sql_query_check = "SELECT * FROM register WHERE caccount = '$data_len'";
    $result_check = mysqli_query($db_link, $sql_query_check);
    
    $return_data = true; // 預設值為 true，只有在檢查條件時發現問題時才設置為 false
    
    if (mysqli_num_rows($result_check) > 0)
    {
        $return_data = false;
    }
    
    if($password_data === $data_len)
    {
        $return_data = false;
    }

    if(preg_match('/[\p{Han}]/u',$data_len))
    {
        $return_data = false;
    }

    if (strpos($data_len, '@') !== false)
    {
        $return_data = false;
    }
	
	 
	
    echo json_encode($return_data);
}
?>
