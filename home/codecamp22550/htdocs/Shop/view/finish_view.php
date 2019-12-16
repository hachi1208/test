<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>購入完了ページ</title>
</head>
<style>
body{
    display: flex;
    background-color:#f5f5dd;
}
img.logo{
    width:150px;
    }
.header-box p{
    background-color: #FFE4E1;
    color: #000080;
    display: block;
    font-weight: bold;
    margin-left: 5px;
    border-radius:20px;
    
}
.content {
    width: 960px;
    margin: 0 auto;
    display: block;
}
.title{
    border-bottom: ;
}
li{
    list-style: none;
    display: inline;
    text-align: center;
    font-size: 20px;
    
}
h1{
    background-color: #E6E6FA;
    color: #696969;
    display: block;
    font-size: 22px;
    line-height: 2em;
    padding: 10px 10px 10px 10px;
    margin-bottom: 15px;
    display: block;
    width:920px;
    text-align: center;
    border-radius:20px;
    background-image: url(icon.png);
    background-repeat: no-repeat;
    background-position: 250px center;
    
}
img.img_size{
    width: 150px;
    height: 150px;
}
.cart-item{
    border-bottom:dotted 1px #7d7d7d;
    padding: 10px;
}
.cart-item li{
    display: inline-block;
    padding-left: 40px;
}
span{
    color: red;
    font-weight: bold;
}

.button {
  position:relative;
  display:block;
  margin-top:15px;
  margin-bottom:15px;
  margin-left: 35px;
  padding:17px;
  width:250px;
  font-size:1.2em;
  box-shadow:0px 3px 0px @bottom;
  cursor:pointer;
}
</style>
<body>
    <header>
    <div class="header-box">
    <img class="logo" src="logo.png">
    <a class="nemu" href="logout.php">ログアウト</a>
    <a href="cart.php" class="cart"></a>
    <p>合計金額：<?php print $total_price; ?>円</p>
    </div>
  </header>
  <div class="content">
    <h1>購入ありがとうございました！</h1>
    <?php foreach ($err_msg as $value) { ?>
        <p><?php print $value; ?></p>
    <?php } ?>
    <?php foreach ($msg as $value) { ?>
        <p><?php print $value; ?></p>
    <?php } ?>
    
    <ul class="cart-list">
        <?php foreach ($results as $value)  { ?>
        <div class="cart-item">
            <img src="<?php print $img_dir . $value['img']; ?>" class="img_size">
            <li><?php print $value['name']; ?></li>
            <li><span><?php print $value['price']; ?>円</span></li>
            <li><span><?php print $value['amount']; ?>個</span></li>
        </div>
        <?php } ?>
    </ul>
    </div>
  </div>
</body>
</html>