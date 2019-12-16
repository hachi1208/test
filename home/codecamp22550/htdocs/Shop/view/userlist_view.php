<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>ユーザ管理ページ</title>
  <link type="text/css" rel="stylesheet" href="./lib/admin.css">
</head>
<body>
  <h1>DOG SHOP 管理ページ</h1>
  <div>
    <a href="./admin.php" target="_blank">商品管理ページ</a>
  </div>
<h2>ユーザ情報一覧</h2>
<table border="2">
    <tr>
      <td>ユーザID</td>
      <td>登録日</td>
    </tr>
    <tr>
    <?php foreach ($rows as $value) { ?>
        <td><?php print h($value['user_name']); ?></td>
        <td><?php print h($value['create_datetime']); ?></td>
    </tr>
    <?php } ?>
</table>
</html>