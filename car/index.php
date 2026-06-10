<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>無標題文件</title>
<style type="text/css">
body {
    display: flex;/*在內部輕鬆排列元素*/
    flex-direction: row;/*水平排列*/
    flex-wrap: wrap;/*當內容超出一行寬度時，自動換行*/
    justify-content: flex-start;/*將內容靠左對齊*/
    align-items: flex-start;/* 垂直靠上對齊 */
    gap: 400px;/*設定內容間的水平和垂直間距為 20 像素*/
    padding: 60px;/*在 body 邊緣留出 20 像素的內邊距*/
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

#product-list {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
		width: 100%;
    }

.product {
    background-color: rgba(233,217,255,0.75);
    padding: 20px;/*設定區塊內容與邊框的間距*/
    border-radius: 10px;/*邊框為圓角*/
    width: calc(20% - 15px); /* 寬度佔頁面的25%(一排四個);20px：寬度中減去20像素(間距)*/
    text-align: center;/* 將商品置中 */
    margin-bottom: 20px; /* 設定與下方區塊的間距 */
    margin: 10px; /* 設定上下左右的間距，這裡設定為 10px */	
}
.product img {
        width: 100%;/*設定圖片的寬度為 100%，使圖片填滿其容器的寬度*/
        height: auto;/*高度自動調整，以保持原始比例*/
        margin-bottom: 10px;/*圖片與下方內容的間距*/
    }

</style>
</head>
	<script src="http://code.jquery.com/jquery-3.4.1.min.js">
	</script>
	
	
<body>
<div id="up">
    <div style="display: flex; align-items: center; justify-content: flex-end;">
        <a href="<?php echo 'index.php'; ?>"><img src="ha/top.png" width="65" height="65" alt=""/></a>
        <a href="<?php echo 'index.php'; ?>" style="color: green; font-size: 30px; text-decoration: none;">蔬</a>
        <a href="<?php echo 'index.php'; ?>" style="color: red; font-size: 30px; text-decoration: none;">果</a>
        <a href="<?php echo 'index.php'; ?>" style="color: purple; font-size: 30px; text-decoration: none;">行</a>
    </div>

    <?php
    include("database.php");
    $sql_query = "SELECT * FROM commodity WHERE ud = 'up'";
    $select_result = mysqli_query($db_link, $sql_query);

    if (!isset($_SESSION['caccount'])) {
        ?>
	 
	
        <div id="up_login_register">
			<form action="" method="POST">
            <input type="text" id="input_text" required="required" placeholder="搜尋商品" list="searchResults">
            <datalist id="searchResults"></datalist>
        </form>
            <?php
            $login = "login.php";
            echo '<a href="' . $login . '" style="color:#7A7A7A; text-decoration: none;">登入</a>';
            echo '<font color="#7A7A7A"> | </font>';
            $register = "register.php";
            echo '<a href="' . $register . '" style="color: #7A7A7A; text-decoration: none;">註冊</a>';
            ?>
        </div>
    <?php } ?>
</div>
	
	<div id="product-list" style="display: flex; flex-wrap: wrap;"><!--flex-wrap: wrap超出格子寬度時換行-->
    <?php $count = 0; ?><!--追蹤目前有幾個商品被處理-->
    <?php while ($row = mysqli_fetch_assoc($select_result)): ?>
        <div class="product" style="flex-basis: 20%; padding: 12px; box-sizing: border-box;"> 
			<!--代表了每個商品的格子。CSS 樣式設定了每個格子的寬度為 20%，並添加了內邊距，不會增加框模型的寬度-->
			<a style="text-decoration: none; color: black;">
            <img src="<?php echo $row["image"]; ?>" alt="商品圖片" style="max-width: 100%;">
            <h2><h2 style="margin-top: auto;"><?php echo $row["name"]; ?></h2>
            <p>價格：<?php echo $row["price"]; ?></p>
            <p>說明：<?php echo substr($row["cexplain"], 0, 21) . (strlen($row["cexplain"]) > 21 ? '...' : ''); ?></p>
        </div>
        
        <?php $count++; ?><!--在每次迴圈時，$count 變數增加，用來追蹤當前處理的商品數量-->
        <?php if ($count % 4 === 0): ?><!--有沒有處理4個商品-->
            <div style="flex-basis: 100%;"></div><!--確保下一排隊齊-->
        <?php endif; ?>
    <?php endwhile; ?>
	
</div>


</body>
</html>
	
<script>
	$('#input_text').on("keyup", function () {
        var target_data = $(this).val(); // this是處理input_text(取得輸入框的值)
        console.log("target:", target_data);
        $.ajax({
            url: 'indextest.php', // 連結到什麼地方
            type: 'POST',
            dataType: 'json',
            data: { 'data': target_data } // 資料內容
        }).done(function (data) { // 把資料傳到這個網頁後
            var datalist = $("#searchResults");
            datalist.empty(); // 清空datalist

            if (data && data.length > 0)
			{
                // 如果$data有資料，將每個資料加入datalist
                data.forEach(function (item) {
                    datalist.append("<option value='" + item + "'>");
                });
				
				
				$(".product").hide();//隱藏所有商品

				// 顯示匹配的商品
				data.forEach(function (item) {
					$(".product:contains('" + item + "')").show();//根據搜尋到的商品名稱，找到匹配的商品，然後顯示
				});
            }
			 else
			 {
				$(".product").show();//如果沒有匹配的商品，顯示所有商品
			 }
            console.log("data:", data);
        }).fail(function (error) {
            console.log("error", error);
        });
    });
	
</script>