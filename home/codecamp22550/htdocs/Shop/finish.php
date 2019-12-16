<?php
$item_id = "";
$user_id="";
$rows=array();
$value_regex = '/^[\d]+$/';
$err_msg    = array();
$msg    = array();
$host     = 'localhost';
$username = 'codecamp22550';
$password = 'FRJQNRAV';
$dbname   = 'codecamp22550';
$charset  = 'utf8';
$dsn = 'mysql:dbname='.$dbname.';host='.$host.';charset='.$charset;
$img_dir    = './img/';
$update_stock = array();
$results=array();
$sql_kind ="";
$max = 0 ;
$total_price = 0;
$stock = array();
$amount =array();


session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}else{
    header('Location: login.php');
    exit;
}

function h($value){
    return htmlspecialchars($value,ENT_QUOTES, "UTF-8");
}

function space_trim($str){
    $str = preg_replace('/^[ 　]+/u', '', $str);
    $str = preg_replace('/[ 　]+$/u', '', $str);
    return $str;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    try{
        $dbh = new PDO($dsn, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $sql = 'SELECT name, price,img,ec_item_master.item_id,amount,stock, ec_cart.id FROM ec_item_master JOIN ec_cart ON ec_item_master.item_id = ec_cart.item_id
        JOIN ec_item_stock ON ec_item_master.item_id  = ec_item_stock.item_id WHERE ec_cart.user_id= :user_id';
        $stmt = $dbh->prepare($sql);
        $stmt -> bindParam(":user_id",$user_id,PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll();
        $max = count($results);
        for($i=0;$i<$max;$i++){
            $dbh->beginTransaction();
            try{
                $datetime = date('Y-m-d H:i:s');
                $total_price+= $results[$i]['price']*$results[$i]['amount'];
                $update_stock = $results[$i]['stock']- $results[$i]['amount'];
                $sql = 'UPDATE ec_item_stock SET stock =:stock WHERE item_id = :item_id';
                $stmt = $dbh->prepare($sql);
                $stmt->bindParam(':stock',$update_stock, PDO::PARAM_INT);
                $stmt->bindParam(':item_id',$results[$i]['item_id'], PDO::PARAM_INT);
                $stmt->execute();
                $sql = 'DELETE FROM ec_cart WHERE id = :id';
                $stmt = $dbh->prepare($sql);
                $stmt->bindParam(':id',$results[$i]['id'], PDO::PARAM_INT);
                $stmt->execute();
                //履歴を作る
                $sql = 'insert into cart_history (user_id,item_id,amount,create_datetime) values(:user_id,:item_id,:amount,:create_datetime)';
                $stmt = $dbh->prepare($sql);
                $stmt -> bindParam(":user_id",$user_id,PDO::PARAM_INT);
                $stmt -> bindParam(":item_id",$results[$i]['item_id'],PDO::PARAM_INT);
                $stmt -> bindParam(":amount",$results[$i]['amount'],PDO::PARAM_INT);
                $stmt->bindParam(':create_datetime',$datetime, PDO::PARAM_STR);
                $stmt->execute();
            }catch (PDOException $e) {
            $dbh->rollback();
            throw $e;
            }
                $dbh->commit();
        }
    }catch (PDOException $e) {
        $err_msg[] = 'データベースにてエラー発生。理由：'.$e->getMessage();
    }
}
include_once './view/finish_view.php';
?>