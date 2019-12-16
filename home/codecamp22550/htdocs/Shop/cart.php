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
$update_count = 0;
$result=array();
$results=array();
$history = array();
$amount=0;
$new_amount=0;
$sql_kind ="";
$max = 0 ;
$total_price = 0;
$num=0;
$cart_id='';

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
    if ( isset($_POST['sql_kind']) ) {
    $sql_kind = space_trim($_POST['sql_kind']);
    }
    if ($sql_kind === 'insert') {
        if(isset($_POST['into_cart'])===TRUE){
            if (isset($_POST['num']) === TRUE){
                $num = space_trim($_POST['num']);
            }
            if(mb_strlen($num) === 0 && $num === "") {
                $err_msg[] = '数量を選択してください';
            }
            
            if (isset($_POST['item_id']) === TRUE){
                $item_id = space_trim($_POST['item_id']);
            }
            if(mb_strlen($item_id) === 0 && $item_id === "") {
                $err_msg[] = '商品を選択してください';
            }elseif(preg_match($value_regex, $item_id) !== 1){
                $err_msg[] = '半角数値で入力してください';
            }
         }
    }elseif ($sql_kind === 'update') {
        if (isset($_POST['update_count']) === TRUE){
            $new_amount = space_trim($_POST['update_count']);
        }
        if(mb_strlen($new_amount) === 0 && $new_amount === ""){
            $err_msg[] = '個数を入力してください';
        }elseif (preg_match($value_regex, $new_amount) === FALSE){
            $err_msg[] = '半角で入力してください';
        }
        if (isset($_POST['item_id']) === TRUE){
            $item_id = space_trim($_POST['item_id']);
        }
        if (preg_match($value_regex, $item_id) === FALSE) {
            $err_msg[] = '半角数値で入力してください';
        }elseif(mb_strlen($item_id) === 0 && $item_id === ""){
            $err_msg[] = 'idを入力してください';
        }
    }elseif ($sql_kind === 'delete') {
        if (isset($_POST['delete']) === TRUE){
            $delete = space_trim($_POST['delete']);
        }
        if (isset($_POST['cart_id']) === TRUE){
            $cart_id = space_trim($_POST['cart_id']);
        }
    }
}
    
try{
    $dbh = new PDO($dsn, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($err_msg) === TRUE ){
        if ($sql_kind === 'insert') {
            $sql = 'SELECT name, price,img,status,stock,ec_item_master.item_id FROM ec_item_master INNER JOIN ec_item_stock
            ON ec_item_master.item_id = ec_item_stock.item_id WHERE status=1 AND ec_item_master.item_id= :item_id';
            $stmt = $dbh->prepare($sql);
            $stmt -> bindParam(":item_id",$item_id);
            $stmt->execute();
            $rows = $stmt->fetchAll();
            if(empty($rows) === TRUE){
            $err_msg[] ='商品は購入出来ません';
            }
            $sql = 'SELECT item_id,amount FROM ec_cart WHERE item_id= :item_id AND user_id =:user_id';
            $stmt = $dbh->prepare($sql);
            $stmt -> bindParam(":item_id",$item_id);
            $stmt -> bindParam(":user_id",$user_id);
            $stmt->execute();
            $result = $stmt->fetchAll();
            /*カート数量をUPDATE*/
            if (empty($err_msg) === TRUE && empty($result) === FALSE){
                $update_count = $result[0]['amount']+$num;
                $sql = 'UPDATE ec_cart SET amount =:amount WHERE item_id = :item_id';
                $stmt = $dbh->prepare($sql);
                $stmt->bindParam(':amount',$update_count, PDO::PARAM_INT);
                $stmt->bindParam(':item_id',$item_id, PDO::PARAM_INT);
                $stmt->execute();
            }else{/*新規購入*/
                $datetime = date('Y-m-d H:i:s');
                $sql = 'insert into ec_cart (user_id,item_id,amount,create_datetime) values(:user_id,:item_id,:amount,:create_datetime)';
                $stmt = $dbh->prepare($sql);
                $stmt->bindParam(':user_id',$user_id, PDO::PARAM_STR);
                $stmt->bindParam(':item_id',$item_id, PDO::PARAM_INT);
                $stmt->bindParam(':amount',$num, PDO::PARAM_INT);
                $stmt->bindParam(':create_datetime',$datetime, PDO::PARAM_STR);
                $stmt->execute();
            }
                    /*数更新*/
        }elseif ($sql_kind === 'update') {
            $datetime = date('Y-m-d H:i:s');
            $sql = 'UPDATE ec_cart SET amount =:amount,update_datetime = :update_datetime WHERE item_id = :item_id';
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':amount',$new_amount, PDO::PARAM_INT);
            $stmt->bindParam(':update_datetime',$datetime, PDO::PARAM_STR);
            $stmt->bindParam(':item_id',$item_id, PDO::PARAM_INT);
            $stmt->execute();
            $msg[] = '数量変更しました！';
                
        }elseif($sql_kind === 'delete') {
            $sql = 'DELETE FROM ec_cart WHERE id = :id';
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':id',$cart_id, PDO::PARAM_INT);
            $stmt->execute();
            $msg[] = '削除しました！';
        }
    }
            /*最新カート情報取得*/
    $sql = 'SELECT name, price,img,ec_item_master.item_id,amount, ec_cart.id FROM ec_item_master INNER JOIN ec_cart
    ON ec_item_master.item_id = ec_cart.item_id WHERE ec_cart.user_id= :user_id';
    $stmt = $dbh->prepare($sql);
    $stmt -> bindParam(":user_id",$user_id);
    $stmt->execute();
    $results = $stmt->fetchAll();
    $max = count($results);
    for($i=0;$i<$max;$i++){
        $total_price+= $results[$i]['price']*$results[$i]['amount'];
    }
            /*購入履歴取得*/
    $sql = 'SELECT name, price,img,amount,cart_history.create_datetime FROM ec_item_master INNER JOIN cart_history
    ON ec_item_master.item_id = cart_history.item_id WHERE cart_history.user_id= :user_id';
    $stmt = $dbh->prepare($sql);
    $stmt -> bindParam(":user_id",$user_id);
    $stmt->execute();
    $history = $stmt->fetchAll();
            
}catch (PDOException $e) {
        $err_msg[] = 'データベースにてエラー発生。理由：'.$e->getMessage();
}

include_once './view/cart_view.php';
?>