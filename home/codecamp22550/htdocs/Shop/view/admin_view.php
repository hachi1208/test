<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>商品管理ツール</title>
  <style>
    table {
      width 1500px;
      border-collapse: collapse;
    }
    table, tr, th, td {
      border: solid 1px;
      padding: 10px;
      text-align: center;
    }
    img.img{
        height: 200px;
    }
    
  </style>
</head>
<body>
<a href="./userlist.php" target="_blank">ユーザー管理ページ</a>
    <?php foreach ($err_msg as $value) { ?>
      <p><?php print $value; ?></p>
    <?php } ?>    
    <?php foreach ($msg as $value) { ?>
      <p><?php print $value; ?></p>
    <?php } ?>    
    <h2>新規商品追加</h2>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name ="sql_kind" value = "insert">
        <div>商品名：<input type="text" name="name"></div>
        <div>価格：<input type="text" name="price"></div>
        <div>個数：<input type="text" name="count"></div>
        <div><input type="file" name="new_img" ></div>
        <div><select name="status">
            <option value="0">非公開</option>
            <option value="1">公開</option>
        </div></select>
        <div><select name="category">
            <option value="0">消耗品</option>
            <option value="1">大型犬・中型犬用</option>
            <option value="2">共用</option>
            <option value="3">小型犬用</option>
            <option value="4">その他</option>
            <option value="5">最新</option>
        </div></select>
        <div><input type="submit" value="商品を追加"></div>
    </form>
    <h2>商品情報変更</h2>
    <table border="1">
    <tr>
        <td>商品画像</td>
        <td>商品名</td>
        <td>価格</td>
        <td>在庫数</td>
        <td>ステータス</td>
        <td>操作</td>
        <td>カテゴリー</td>
    </tr>
    <tr>
        <?php foreach ($rows as $value)  { ?>
            <td><img src="<?php print h($img_dir . $value['img']); ?>" class="img"></td>
            <td>
            <form method ="post" >
                <input type="hidden" name ="sql_kind" value = "name_update">
                <?php print h($value['name']); ?>
                <input type="text"  name="update_name" value="<?php print h($value['name']); ?>">
                <input type="hidden" name="item_id" value="<?php print h($value['item_id']); ?>" >
                <input type="submit" value="変更">
            </form>
            </td>
            <td><?php print h($value['price']); ?>円</td>
            <td>
            <form method ="post" >
                <input type="hidden" name ="sql_kind" value = "update">
                <input type="text"  name="update_stock" value="<?php print h($value['stock']); ?>">個&nbsp;&nbsp;
                <input type="hidden" name="item_id" value="<?php print h($value['item_id']); ?>" >
                <input type="submit" value="変更">
            </form>
            </td>
            <td>
            <form method ="post">
                <input type="hidden" name ="sql_kind" value = "status_update">
                <?php if($value['status'] === "0") { ?>
                <input type="hidden" name="update_status" value="1" >
                <input type= "submit"  value = "非公開⇨公開">
                <?php } elseif ($value['status'] === "1") { ?>
                <input type="hidden" name="update_status" value="0" >
                <input type= "submit"  value = "公開⇨非公開">
                <?php } ?>
                <input type="hidden" name="item_id" value="<?php print h($value['item_id']); ?>" >
            </form>
            </td>
            <td>
            <form method ="post">
                <input type="hidden" name ="sql_kind" value = "delete">
                <input type ="submit" name="delete" value ="削除する">
                <input type="hidden" name="item_id" value="<?php print h($value['item_id']); ?>" >
            </form>
            </td>
            <td>
            <form method ="post">
            <input type="hidden" name ="sql_kind" value = "category_update">
                <input type="radio" name="category_update" value="0">消耗品 
                <input type="hidden" name="item_id" value="<?php print h($value['item_id']); ?>" >
                
                <input type="radio" name="category_update" value="1" >大型犬・中型犬
                <input type="hidden" name="item_id" value="<?php print h($value['item_id']); ?>" >
                
                <input type="radio" name="category_update" value="2" >共用
                <input type="hidden" name="item_id" value="<?php print h($value['item_id']); ?>" >
                <input type="radio" name="category_update" value="3" >小型犬
                <input type="hidden" name="item_id" value="<?php print h($value['item_id']); ?>" >
                <input type="radio" name="category_update" value="4" >その他
                <input type="hidden" name="item_id" value="<?php print h($value['item_id']); ?>" >
                <input type="radio" name="category_update" value="5" >最新
                <input type="hidden" name="item_id" value="<?php print h($value['item_id']); ?>" >
                <input type="submit" value="変更">
            </form>
            </td>
    </tr>
        <?php } ?>
    </table>
</body>
</html>