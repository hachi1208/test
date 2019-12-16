<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="reset.css">
  <title>hahciya</title>
</head>
<style>

body{
    background-image: url(body3.jpg);
}
.all{
   display: flex;
   background-color:#FFFFFF;
   width: 960px;
   margin: 0 auto;
}
header{
    background-color: #F8F8FF;
}

img.logo_size{
    width: 150px;
    height: 75px;
}
img.cart_logo{
    width: 100px;
    height: 75px;
}

.top{
    position: relative;
   
}

.top p{
    position: absolute;
    font-size: 50px;
    color: #B0C4DE;
    font-weight: bold;
    top: 15%;
    left: 5%;
    
    
}
.parent{
    display: flex;
    justify-content: space-between;
    padding-left: 10px;
    
}
.parent p{
    display: block;
    font-weight: bold;
    margin-top: 20px;
    font-size: 18px;
    width: 250px;
    height: 50px;
    text-align: center
    color: #FFF5EE;
    padding-left: 60px;
    padding-top: 10px;
    background-image: url(topicon.png);
    background-repeat: no-repeat;
    background-position: 40px left;
    
}
.parent a{
    margin-right: 20px;
}
.logout{
    display: block;
}
h2{
    background-color: #FFFACD;
    color: #696969;
    border-radius:20px;
    display: block;
    font-size: 25px;
    line-height: 1.5em;
    padding: 5px 5px 10px 70px;
    height: 30px;
    background-image: url(icon.png);
    background-repeat: no-repeat;
    background-position: 10px center;
    
}
.item_list{
    clear: both;
}
.menu ul {
    width: 960px;
    display: flex;
    margin: auto;
}
.menu li{
    width: 25%;
    text-align: center;
    border-right: 2px dashed #8c8b8b;
    list-style: none; 
    padding: 20px;
    font-family: "Comic Sans MS";
    font-size: 20px;
    
}
.menu li:last-child{
    border-right: none;
}
.logobox a{
    text-decoration: none;
    display: block;
    background-color: #FFE4E1;
    color: #696969;
    text-decoration: none;
    border-radius:20px;
    margin-bottom: 10px;
    margin-top: 10px;
    display: block;
    width:150px;
    text-align: center;
    background-image: url(0212_7.png);
    background-repeat: no-repeat;
    background-position: 5px center;
    background-size: 10%; 
    padding: 3px;
    width:150px;
  
}
.small_item h2{
    background-color: #FFE4E1;
    color: #696969;
    border-radius:20px;
    display: block;
    font-size: 25px;
    line-height: 1.5em;
    padding: 5px 5px 10px 70px;
    height: 30px;
    background-image: url(icon.png);
    background-repeat: no-repeat;
    background-position: 10px center;
}
.sbox{
    width:200px;
    height:20px;
    margin-right:10px;
    margin-top: 25px;
}
.sbtn{
    height:60px;
    margin-top:25px;
    
}
li{
    list-style-type: none;
    text-align: center;
}
main{
    width: 960px;
}

.item {
    width: 280px;
    text-align: center;
    margin: 10px;
    padding: 10px;
    float: left;
}
span{
    color: red;
    font-weight: bold;
}
.small_item{
    clear: both;
}
.count{
    background-color: red;
    color: #FFFFFF;
    border-radius:20px;
    padding: 5px;
    height: 18px;
    margin-left: 60px;
    
}
    
img.img_size {
    height: 140px;
    width: 125px;
}

footer{
    background-color: #FFFFFF;
    text-align: center;
    padding: 10px;
    border-top: solid 1px #cccccc;
}

footer ul{
    display: flex;
    width: 491px;
    margin: 5px auto;
    padding: 5px;
    text-align: center;
    font-size: 16px;
}
 footer li{
    list-style: none; 
    border-right: 1px solid #7d7d7d;
    padding: 5px;

}
</style>
<div class="all" >
   <div class="container">
<header>
<div class="header_container">
 <div class="parent">
    <div class="logobox">
    <a href ="logout.php" class="logout">ログアウト</a>
    <a href="itemlist.php">Home</a>
    </div>
    <p>ようこそ！<?php print $name[0]['user_name'];?>  様</p>
    <form action="itemlist.php" method="get" >
        <input class="sbox" type="text" placeholder="キーワードで検索" name="keyword">    
        <input class="sbtn" type="submit" value="検索" >
    </form>
    <span class="count"><?php print h($total_count)?></span>
    <a href ="cart.php"><img src="cart.png" class ="cart_logo"></a>
  </div>      
</div>
</header>
<body>
<main>
<div class="small_item">
<h2>小型犬商品一覧</h2>
    <?php foreach ($small_item as $value) { ?>
    <form action="cart.php" method="post">
        <div class = "item">
        <img src="<?php print $img_dir . $value['img']; ?>"class="img_size">
    <ul>
        <li><?php print $value['name']; ?></li>
        <li><?php print $value['price']; ?>円</li>
        <?php if($value['stock'] <= 0) {?>
            <li><span>売り切れ！</span></li>
        <?php }else { ?>
        <select name = "num">
        <?php
        for ($i = 0; $i <= 100; $i++) {
        echo "<option>$i</option>";
        }?>
        </select>
        <input type = "submit" name = "into_cart"  value = "カートに追加">
        <input type="hidden" name ="sql_kind" value = "insert">
        <input type = "hidden" name = item_id value =  "<?php print $value['item_id']; ?>">
        <?php } ?>
        </div>
    </form>
    <?php }?>
    </ul>
</div>
</main>
</div>
</div>
<footer>
<p><small>Copyright &copy; CodeCamp All Rights Reserved.</small></p>
</footer>
</body>
</html>