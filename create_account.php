<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php
      define('DB_HOST', 'localhost');
      define('DB_NAME', 'account');
      define('DB_USER', 'root');
      define('DB_PASSWORD', 'asdasd');
      $name = $_POST['c_name'];
      $pass = $_POST['c_pass'];




      // 文字化け対策
      $options = array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET CHARACTER SET 'utf8'");

      // PHPのエラーを表示するように設定
      error_reporting(E_ALL & ~E_NOTICE);

      // データベースの接続
      try {
         $dbh = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASSWORD, $options);
         // echo "SUCCESS";
         $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (PDOException $e) {
         // echo $e->getMessage();
         exit;
      }

      $name_check_sql = "SELECT `name` FROM `user` WHERE `name` = '" . $name . "'";
      // データを取得
    	$stmt = $dbh->query($name_check_sql);
      $stmt -> execute();
      // 1行ずつ取得
    	while($rec = $stmt->fetch(PDO::FETCH_ASSOC)){
    		// テーブルの項目名を指定して値を表示
        $check_name = $rec['name'];
    	}

      if ($check_name != $name) {
        $options = array(
        	'cost' => 10
        );
        $res = password_hash( $pass, PASSWORD_DEFAULT, $options);

        $sql = "INSERT INTO `user`(`name`, `pass`) VALUES ('" . $name . "','" . $res . "')";  //SQLの命令
        // データを取得
      	$stmt = $dbh->query($sql);
        print("アカウント登録が完了しました。<br>アカウント名：" . $name . "<br>");
        print("<a href=\"account_login.html\">ログイン ＞</a>");
      }else {
        print("そのアカウント名は既に使用されています。<br>別のアカウント名をお試しください。<br>");
        print("<a href=\"create_account.html\">＜ アカウント作成に戻る</a>");
      }







    ?>
  </body>
</html>
