<?php
require_once './model/common.php';
$host     = 'localhost';
$username = 'codecamp22550';
$password = 'FRJQNRAV';
$dbname   = 'codecamp22550';
$charset  = 'utf8';
$dsn = 'mysql:dbname='.$dbname.';host='.$host.';charset='.$charset;
$img_dir    = './img/';
$data       = array();
$err_msg    = array();
$msg    = array();
$new_img_filename = '';
$rows= array();
$new_name = '';
$new_price = '';
$new_count = '';
$status= '';
$category = '';
$new_status = '';
$new_category ='';
$item_id = '';
$value_regex = '/^[\d]$/';
$update_name = '';
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
        if(isset($_POST['name']) === TRUE){
            $new_name = space_trim($_POST['name']);
        }
        if (mb_strlen($new_name) === 0 && $new_name === ""){
            $err_msg[] = '名前を入力してください';
        }
        if (isset($_POST['price']) === TRUE){
            $new_price = space_trim($_POST['price']);
        }
        if(mb_strlen($new_price) === 0 && $new_price === ""){
            $err_msg[] = '価格を入力してください';
        }elseif (preg_match($value_regex, $new_price) === FALSE) {
            $err_msg[] = '半角で入力してください';
        }
        if (isset($_POST['count']) === TRUE){
            $new_count = space_trim($_POST['count']);
        }
        if(mb_strlen($new_count) === 0 && $new_count === "") {
            $err_msg[] = '個数を入力してください';
        }elseif (preg_match($value_regex, $new_count) === FALSE) {
            $err_msg[] = '半角で入力してください';
        }
        if (is_uploaded_file($_FILES['new_img']['tmp_name']) === TRUE) {
            $extension = pathinfo($_FILES['new_img']['name'], PATHINFO_EXTENSION);
            if ($extension === 'jpg' || $extension === 'jpeg'|| $extension === 'png') {
                $new_img_filename = sha1(uniqid(mt_rand(), true)). '.' . $extension;
                if (is_file($img_dir . $new_img_filename) !== TRUE) {
                    if (move_uploaded_file($_FILES['new_img']['tmp_name'], $img_dir . $new_img_filename) !== TRUE) {
                        $err_msg[] = 'ファイルアップロードに失敗しました';
                    }
                } else {
                    $err_msg[] = 'ファイルアップロードに失敗しました。再度お試しください。';
                }
            } else {
                $err_msg[] = 'ファイル形式が異なります。画像ファイルはJPEGのみ利用可能です。';
            }
        }else {
            $err_msg[] = 'ファイルを選択してください';
        }
        if(isset($_POST['status']) === TRUE){
            $status = $_POST['status'];
        }
        if(isset($_POST['category']) === TRUE){
            $category = $_POST['category'];
        }
    }elseif ($sql_kind === 'update') {
        if (isset($_POST['update_stock']) === TRUE){
            $update_stock = space_trim($_POST['update_stock']);
        }
        if(mb_strlen($update_stock) === 0 && $update_stock === ""){
            $err_msg[] = '個数を入力してください';
        }elseif (preg_match($value_regex, $update_stock) === FALSE){
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
    }elseif ($sql_kind === 'status_update') {
        if (isset($_POST['update_status']) === TRUE){
            $new_status = space_trim($_POST['update_status']);
        }
        if (isset($_POST['item_id']) === TRUE){
            $item_id = space_trim($_POST['item_id']);
        }
    }elseif ($sql_kind === 'delete') {
        if (isset($_POST['delete']) === TRUE){
            $delete = space_trim($_POST['delete']);
        }
        if (isset($_POST['item_id']) === TRUE){
            $item_id = space_trim($_POST['item_id']);
        }
    }elseif ($sql_kind === 'category_update') {
        if (isset($_POST['category_update']) === TRUE){
            $new_category = space_trim($_POST['category_update']);
        }
        if (isset($_POST['item_id']) === TRUE){
            $item_id = space_trim($_POST['item_id']);
        }
    }elseif ($sql_kind === 'name_update') {
        if (isset($_POST['update_name']) === TRUE){
            $update_name = space_trim($_POST['update_name']);
        }
        if (isset($_POST['item_id']) === TRUE){
            $item_id = space_trim($_POST['item_id']);
        }
    }
}

try{
$dbh = new PDO($dsn, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($err_msg) === TRUE ){
    $datetime = date('Y-m-d H:i:s');
    if ($sql_kind === 'insert') {
        $dbh->beginTransaction();
        try{
            $sql = 'insert into ec_item_master (name,price,img,status,category,create_datetime) values(:name,:price,:img,:status,:category,:create_datetime)';
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':name',$new_name, PDO::PARAM_STR);
            $stmt->bindParam(':price',$new_price, PDO::PARAM_INT);
            $stmt->bindParam(':img',$new_img_filename, PDO::PARAM_STR);
            $stmt->bindParam(':status',$status, PDO::PARAM_INT);
            $stmt->bindParam(':category',$category, PDO::PARAM_INT);
            $stmt->bindParam(':create_datetime',$datetime, PDO::PARAM_STR);
            $stmt->execute();
            $sql = 'insert into ec_item_stock (item_id,stock,create_datetime) values(:item_id,:stock,:create_datetime)';
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':item_id',$item_id, PDO::PARAM_INT);
            $stmt->bindParam(':stock',$new_count, PDO::PARAM_INT);
            $stmt->bindParam(':create_datetime',$datetime, PDO::PARAM_STR);
            $stmt->execute();
            }catch (PDOException $e) {
            $dbh->rollback();
            throw $e;
        }
        $dbh->commit();
        $msg[] = '商品登録しました！';
    }elseif ($sql_kind === 'update') {
        $sql = 'UPDATE ec_item_stock SET stock =:stock,update_datetime = :update_datetime WHERE item_id = :item_id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':stock',$update_stock, PDO::PARAM_INT);
        $stmt->bindParam(':update_datetime',$datetime, PDO::PARAM_STR);
        $stmt->bindParam(':item_id',$item_id, PDO::PARAM_INT);
        $stmt->execute();
        $msg[] = '数量変更しました！';
    }elseif($sql_kind === 'status_update') {
        $sql = 'UPDATE  ec_item_master SET status = :status,update_datetime = :update_datetime WHERE item_id = :item_id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':status',$new_status, PDO::PARAM_INT);
        $stmt->bindParam(':update_datetime',$datetime, PDO::PARAM_STR);
        $stmt->bindParam(':item_id',$item_id, PDO::PARAM_INT);
        $stmt->execute();
        $msg[] = '公開ステータス変更しました！';
    }elseif($sql_kind === 'delete') {
        $sql = 'DELETE FROM ec_item_master WHERE item_id = :item_id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':item_id',$item_id, PDO::PARAM_INT);
        $stmt->execute();
        $msg[] = '削除しました！';
    }elseif($sql_kind === 'category_update') {
        $sql = 'UPDATE  ec_item_master SET category = :category,update_datetime = :update_datetime WHERE item_id = :item_id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':category',$new_category, PDO::PARAM_INT);
        $stmt->bindParam(':update_datetime',$datetime, PDO::PARAM_STR);
        $stmt->bindParam(':item_id',$item_id, PDO::PARAM_INT);
        $stmt->execute();
        $msg[] = 'カテゴリー変更しました！';
    }elseif ($sql_kind === 'name_update') {
        $sql = 'UPDATE  ec_item_master SET name = :name,update_datetime = :update_datetime WHERE item_id = :item_id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':name',$update_name, PDO::PARAM_INT);
        $stmt->bindParam(':update_datetime',$datetime, PDO::PARAM_STR);
        $stmt->bindParam(':item_id',$item_id, PDO::PARAM_INT);
        $stmt->execute();
        $msg[] = '名前変更しました！';
    }
}
$sql = 'SELECT name, price,img,status,category,stock,ec_item_master.item_id FROM ec_item_master INNER JOIN ec_item_stock
        ON ec_item_master.item_id = ec_item_stock.item_id';
$stmt = $dbh->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll();
}catch (PDOException $e) {
    $err_msg[] = 'データベースにてエラー発生。理由：'.$e->getMessage();
}
include_once './view/admin_view.php';
?>