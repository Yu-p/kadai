<?php
//1.POSTでParamを取得
//insert.phpからペースト＋id追記。
$bname   = $_POST["bname"];
$bcomment  = $_POST["bcomment"];
$breview = $_POST["breview"];
$id = $_POST["id"];

//2.DB接続など
try {
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DbConnectError:'.$e->getMessage());
}


//３．データ登録SQL作成 （変更したいところだけ変更）
$stmt = $pdo->prepare("UPDATE gs_bm_table SET bname=:bname,bcomment=:bcomment,breview=:breview WHERE id=:id");
$stmt->bindValue(':bname', $bname);
$stmt->bindValue(':bcomment', $bcomment);
$stmt->bindValue(':breview', $breview);
$stmt->bindValue(':id', $id);
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);
}else{
  //５．select.phpへリダイレクト
  header("Location: select.php");
  exit;
}


?>
