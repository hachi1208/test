<?php 
$name ='';
$price ='';
$host     = 'localhost';
$username = 'codecamp22550';
$password = 'FRJQNRAV';
$dbname   = 'codecamp22550';
$charset  = 'utf8';
$dsn = 'mysql:dbname='.$dbname.';host='.$host.';charset='.$charset;
$img_dir    = './img/';
$err_msg    = array();
$rows = array();
$user_id="";
$name = array();
$new_item = array();
$large_item = array();
$small_item = array();
$keyword = "";
$count_cart = 0;
$total_count = 0;
function space_trim($str){
    $str = preg_replace('/^[ 　]+/u', '', $str);
    $str = preg_replace('/[ 　]+$/u', '', $str);
    return $str;
}
function h($value){
    return htmlspecialchars($value,ENT_QUOTES, "UTF-8");
}

session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}else{
    header('Location: login.php');
    exit;
}

if ( isset($_GET['keyword']) ) {
        $keyword = space_trim($_GET['keyword']);
}


try{
    $dbh = new PDO($dsn, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    if (empty($keyword) === TRUE){
        $sql = 'SELECT name, price,img,status,stock,ec_item_master.item_id FROM ec_item_master INNER JOIN ec_item_stock
                ON ec_item_master.item_id = ec_item_stock.item_id WHERE status=1';
    }else{
        $sql = 'SELECT name, price,img,status,stock,ec_item_master.item_id FROM ec_item_master INNER JOIN ec_item_stock
                ON ec_item_master.item_id = ec_item_stock.item_id WHERE status=1 AND name LIKE :keyword';
    }
    $stmt = $dbh->prepare($sql);
    if (empty($keyword) === FALSE){
        $keyword = '%'.$keyword.'%';
        $stmt -> bindParam(":keyword",$keyword);
    }
    $stmt->execute();
    $rows = $stmt->fetchAll();
    $sql = 'SELECT user_name FROM ec_user WHERE user_id=:user_id';
    $stmt = $dbh->prepare($sql);
    $stmt -> bindParam(":user_id",$user_id);
    $stmt->execute();
    $name = $stmt->fetchAll();
    $sql = 'SELECT name, price,img,status,stock,ec_item_master.item_id FROM ec_item_master INNER JOIN ec_item_stock
            ON ec_item_master.item_id = ec_item_stock.item_id WHERE category=1';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $large_item = $stmt->fetchAll();
    $sql = 'SELECT name, price,img,status,stock,ec_item_master.item_id FROM ec_item_master INNER JOIN ec_item_stock
            ON ec_item_master.item_id = ec_item_stock.item_id WHERE category=3';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $small_item = $stmt->fetchAll();
    $sql = 'SELECT amount FROM ec_cart WHERE user_id= :user_id';
    $stmt = $dbh->prepare($sql);
    $stmt -> bindParam(":user_id",$user_id);
    $stmt->execute();
    $count_cart = $stmt->fetchAll();
    $max = count($count_cart);
    for($i=0; $i<$max; $i++){
        $total_count+= $count_cart[$i]['amount'];
    }
}catch (PDOException $e) {
    $err_msg[] = 'データベースにてエラー発生。理由：'.$e->getMessage();
}

include_once './view/detail_view2.php';

?>