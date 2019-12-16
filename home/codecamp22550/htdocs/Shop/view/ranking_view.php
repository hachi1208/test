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
.conteinerbox{
    width: 960px;
    margin: 0 auto;
    display: block;
    background-color: #98FB98;
    background-image: url(l_e_event_1554.png);
    background-repeat: no-repeat;
    background-position: 40px left;
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
    </div>
    </header>
<div class="content">
    <h1>Ranking</h1>
    <?php foreach ($err_msg as $value) { ?>
        <p><?php print $value; ?></p>
    <?php } ?>
    <ul class="cart-list">
        <?php for($i=0;$i<5;$i++)  { ?>
        <div class="cart-item">
            <li><?php print $i+1;?>位</li>
            <li><img src="<?php print $img_dir . $ranking[$i]['img']; ?>" class="img_size"></li>
            <li><?php print $ranking[$i]['name']; ?></li>
            <li><span><?php print $ranking[$i]['price']; ?>円</span></li>
        </div>
        <?php } ?>
    </ul>
    </div>
  </div>
</body>
</html>