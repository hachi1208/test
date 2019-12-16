<?php
$user_name = "";
$user_password ="";
$value_regex = '/^[0-9A-Za-z]{6,}$/';
$host     = 'localhost';
$username = 'codecamp22550';
$password = 'FRJQNRAV';
$dbname   = 'codecamp22550';
$charset  = 'utf8';
$dsn = 'mysql:dbname='.$dbname.';host='.$host.';charset='.$charset;
$err_msg    = array();
$msg = array();
$rows = array();

function h($value){
    return htmlspecialchars($value,ENT_QUOTES, "UTF-8");
}

function space_trim($str){
    $str = preg_replace('/^[ 　]+/u', '', $str);
    $str = preg_replace('/[ 　]+$/u', '', $str);
    return $str;
}
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}else{
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    if ( isset($_POST['user_name']) ) {
        $user_name = space_trim($_POST['user_name']);
    }
    if ( isset($_POST['password']) ) {
        $user_password =space_trim($_POST['password']);
    }
    if(mb_strlen($user_name) === 0 && $user_name === ""){
        $err_msg[] = 'usernameを入力してください';
    }elseif (preg_match($value_regex, $user_name) !== 1) {
            $err_msg[] = 'usernameは半角英数・６文字以上で入力してください';
    }
    if(mb_strlen($user_password) === 0 && $user_password === ""){
        $err_msg[] = 'passwordを入力してください';
    }elseif (preg_match($value_regex, $user_password) !== 1) {
            $err_msg[] = 'passwordは半角英数・６文字以上で入力してください';
    }
    if (empty($err_msg) === TRUE){
        $datetime = date('Y-m-d H:i:s');
        try{
            $dbh = new PDO($dsn, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $sql = 'SELECT user_name, password FROM ec_user WHERE user_name= :user_name AND password = :password';
            $stmt = $dbh->prepare($sql);
            $stmt -> bindParam(":user_name",$user_name);
            $stmt -> bindParam(":password",$user_password);
            $stmt->execute();
            $rows = $stmt->fetchAll();
        }catch (PDOException $e) {
            $err_msg[] = 'データベースにてエラー発生。理由：'.$e->getMessage();
        }
        if (empty($rows) === FALSE){
            $err_msg[] = '既にユーザー登録されています';
        }else{
            try{
                $sql = 'insert into ec_user (user_name,password,create_datetime) values(:user_name,:password,:create_datetime)';
                $stmt = $dbh->prepare($sql);
                $stmt->bindParam(':user_name',$user_name, PDO::PARAM_STR);
                $stmt->bindParam(':password',$user_password, PDO::PARAM_STR);
                $stmt->bindParam(':create_datetime',$datetime, PDO::PARAM_STR);
                $stmt->execute();
                $msg[] = '登録完了しました！';
            }catch (PDOException $e) {
                $err_msg[] = 'データベースにてエラー発生。理由：'.$e->getMessage();
            }
        }
    }
}
include_once'./view/register_view.php';
?>