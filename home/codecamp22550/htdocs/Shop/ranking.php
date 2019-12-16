
<?php 
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
$ranking = array();

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
try{
    $dbh = new PDO($dsn, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $sql = 'SELECT cart_history.item_id, SUM(amount),name, price,img FROM cart_history INNER JOIN ec_item_master ON cart_history.item_id = ec_item_master.item_id GROUP BY item_id ORDER BY SUM(amount) DESC'; 
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $ranking = $stmt->fetchAll();
}catch (PDOException $e) {
    $err_msg[] = 'データベースにてエラー発生。理由：'.$e->getMessage();
}
include_once './view/ranking_view.php';


?>