<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>登録する</title>
</head>
<style>
body {
    font:20px/1.25 'Alef';
    background-image: url(p0147_s.png);
    background-size: cover;
    
    
}

form {
  margin:70px auto;
  width:347px;
  text-align:center;
  font-size: 20px
}

form > h1 {
    height: 300px;
    color: #9400D3;
    font-weight:600;
    margin-bottom:20px;
    text-align: center;
    background-image: url(usericon.png);
    background-repeat: no-repeat;
    background-position: center;
}

input {
  background:rgba(0, 0, 0, 0.2);
  color:#F08080;
  display:block;
  width:300px;
  padding:15px;
  margin-bottom:10px;
}
.button {
  position:relative;
  display:block;
  margin-top:15px;
  margin-left: 35px;
  padding:17px;
  width:270px;
  font-size:1.2em;
  box-shadow:0px 3px 0px @bottom;
  cursor:pointer;
  background-color: #E6E6FA;
  border-radius:30px;
}

button:active {
  top:3px;
  box-shadow:none;
}
a{
    display:block;
    margin: 0 auto;
    width:347px;
    font-size:1.2em;
    cursor:pointer;
    text-align: center;
    background-color: #E6E6FA;
    color: #696969;
    text-decoration: none;
    border-radius:20px;
    padding: 10px;
    
}
</style>
<body>
<?php foreach ($err_msg as $value) { ?>
  <p><?php print $value; ?></p>
<?php } ?>
<?php foreach ($msg as $value) { ?>
  <p><?php print $value; ?></p>
<?php } ?>    
<form method="post" action="register.php">
  <h1></h1>
  <input type="text" name="user_name"placeholder="Username"/>
  <input type="password" name="password" placeholder="Password"/>
  <input type="submit" value="登録" class="button">
</form>
<a href ="login.php" class="login">loginする</a>
</body>
</html>