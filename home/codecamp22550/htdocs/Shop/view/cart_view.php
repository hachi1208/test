<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>ショッピングカートページ</title>
</head>
<style>
body{
    display: flex;
    background-color:#FFFFE0;
}
img.logo{
    width:150px;
    margin-left: 20px;
    }
.header-box p{
    font-weight: bold;
    display: block;
    width: 300px;
    text-align: center;
    padding-top:10px;
}
.content {
    width: 960px;
    margin: 0 auto;
    display: block;
}
.title{
    border-bottom: ;
}
.cart-item li{
    list-style: none;
    display: inline;
    text-align: center;
    font-size: 20px;
    padding-left:40px;
    
}
h1{
    background-color: #E6E6FA;
    color: #696969;
    border-radius:20px;
    display: block;
    font-size: 16px;
    line-height: 1.5em;
    padding: 10px 10px 10px 35px;
    margin: 0 auto;
}
h2{
    background-color: #CC99FF;
    color: #696969;
    border-radius:20px;
    display: block;
    font-size: 16px;
    line-height: 1.5em;
    padding: 10px 10px 10px 35px;
    margin: 0 auto;
    margin-top: 10px;
}
img.img_size{
    width: 150px;
    height: 150px;
}
span{
    color: red;
    font-weight: bold;
}
a{
    background-color: #E6E6FA;
    color: #696969;
    text-decoration: none;
    border-radius:20px;
    display: block;
    width:150px;
    text-align: center;
}

.button {
  position:relative;
  display:block;
  margin-top:15px;
  margin-bottom:15px;
  margin-left: 20px;
  padding:17px;
  width:250px;
  font-size:1.2em;
  box-shadow:0px 3px 0px @bottom;
  cursor:pointer;
}

.cart-item{
    border-bottom:dotted 1px #7d7d7d;
    padding: 10px;
    
}
.history_list{
    list-style: none;
    border-bottom:dotted 1px #7d7d7d;
    margin: 10px;
    
}
img.history_img{
    width: 140px;
    height: 140px;
}

</style>
<body>
    <header>
    <div class="header-box">
    <img class="logo" src="logo.png">
    <a href="itemlist.php">買い物を続ける</a>
    <p>合計金額：<?php print $total_price; ?>円</p>
    <form action="finish.php" method="post">
        <input class="button" type="submit" value="購入する">
    </form>
    <a href="logout.php">ログアウト</a>
    </div>
    <h2>購入履歴</h2>
    <?php foreach ($history as $value)  { ?>
        <div class="history_list">
            <li><img src="<?php print $img_dir . $value['img']; ?>" class="history_img"></li>
            <li>【商品名】<?php print $value['name']; ?></li>
            <li>【価格】<?php print $value['price']; ?>円</li>
            <li>【個数】<?php print $value['amount']; ?></li>
            <li>【購入日時】<?php print $value['create_datetime']; ?></li>
        </div>
    <?php } ?>
        
  </header>
  <div class="content">
    <h1>ショッピングカート</h1>
    <?php foreach ($err_msg as $value) { ?>
        <p><?php print $value; ?></p>
    <?php } ?>
    <?php foreach ($msg as $value) { ?>
        <p><?php print $value; ?></p>
    <?php } ?>
    
    <ul class="cart-list">
        <?php foreach ($results as $value)  { ?>
        <div class="cart-item">
            <li><img src="<?php print $img_dir . $value['img']; ?>" class="img_size"></li>
            <li><?php print $value['name']; ?></li>
            <li><span><?php print $value['price']; ?>円</span></li>
            <form method ="post" action="cart.php" class="update">
                <input type="hidden" name ="sql_kind" value = "update">
                <input type="text"  name="update_count" value="<?php print h($value['amount']); ?>">個&nbsp;&nbsp;
                <input type="hidden" name="item_id" value="<?php print h($value['item_id']); ?>" >
                <input type="submit" value="変更">
            </form>
            <form method ="post" action="cart.php" class="delete" >
                <input type="hidden" name ="sql_kind" value = "delete">
                <input type ="submit" name="delete" value ="削除する">
                <input type="hidden" name="cart_id" value="<?php print h($value['id']); ?>" >
            </form>
        </div>
        <?php } ?>
    </ul>
    </div>
  </div>
</body>
</html>