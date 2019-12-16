<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>ログイン</title>
</head>
<style>
body {
    background-image: url(login2.jpg);
    background-size: cover;
}

form {
    margin:70px auto;
    width:347px;
    text-align:center;
}

form > h1 {
    color: #000080;
    height: 300px;
    margin-bottom:20px;
    text-align: center;
    display: block  ;
    background-image: url(usericon.png);
    background-repeat: no-repeat;
    background-position: center;
}

input {
    background-color: #F0F8FF;
    color:#696969;
    display:block;
    width:300px;
    padding:15px;
    margin-bottom:10px;
}
.button {
    position:relative;
    display:block;
    margin-top:15px;
    margin-bottom:15px;
    margin-left: 35px;
    padding:17px;
    width:270px;
    font-size:25px;
    cursor:pointer;
    border-radius:30px;
}

button:active {
    top:3px;
    box-shadow:none;
}
a{
    text-decoration: none;
    display: block;
    text-align: center;
    width:300px;
    margin: 0 auto;
    background-color: #F0F8FF;
    color: #696969;
    border-radius:20px;
    font-size: 25px;
    line-height: 1.5em;
    padding: 5px 5px 10px 70px;
    height: 30px;
    background-image: url(icon.png);
    background-repeat: no-repeat;
    background-position: 10px center;
    
}

</style>
<body>
<?php foreach ($err_msg as $value) { ?>
  <p><?php print $value; ?></p>
<?php } ?>    
<form method="post" action="login.php">
  <h1></h1>
  <input type="text" name="user_name"placeholder="Username"/>
  <input type="password" name="user_password" placeholder="Password"/>
  <input type="submit" value="login" class="button">
</form>
<a href="register.php" target="_blank" >新規登録</a>
</body>
</html>