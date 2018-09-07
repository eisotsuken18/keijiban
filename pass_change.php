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
      $name = $_POST['name'];
      $pass = $_POST['oldpass'];
      $newpass = $_POST['newpass'];

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
      $sql = "SELECT * FROM user WHERE name='".$name. "'";  //SQLの命令
      // データを取得
    	$stmt = $dbh->query($sql);
    	$stmt -> execute();
      // 1行ずつ取得
    	while($rec = $stmt->fetch(PDO::FETCH_ASSOC)){
    		// テーブルの項目名を指定して値を表示
        $inputpass = $rec['pass'];
    	}

      //パスワード
      $options = array(
      	'cost' => 10
      );
      $res = password_hash( $pass, PASSWORD_DEFAULT, $options);//パスワードの暗号化

      if (password_verify($pass, $inputpass) == 1) {//パスワードの照合
        print("パスワードを変更しました。");
        $newres = password_hash( $newpass, PASSWORD_DEFAULT, $options);
        $sql = "UPDATE `user` SET `pass`='".$newres."' WHERE name='".$name. "'";  //SQLの命令
        // データを取得
      	$stmt = $dbh->query($sql);
      	$stmt -> execute();
      }else {
        print("パスワードを変更できませんでした。");
      }

     ?>
  </body>
</html>
