<?php
//1. POSTデータ取得

$bname   = $_POST["bname"];
$burl  = $_POST["burl"];
$breview = $_POST["breview"];
$bcomment = $_POST["bcomment"];

//2. DB接続します（DB接続は以下の記述をコピー。mysqlはdatabase名。host=はレンタルサーバーなどのmysqlアドレスを記述。）
try {
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DbConnectError:'.$e->getMessage()); // エラーが出た時にexit以下を表示させる。不要な場合は空に();
}


//３．データ登録SQL作成
$stmt = $pdo->prepare("INSERT INTO gs_bm_table(id, bname, burl, bcomment, breview,
indate )VALUES(NULL, :bname, :burl, :bcomment, :breview, sysdate())"); // セキュリティ的の考慮でバインド変数を使用。危険な値の無効化。
$stmt->bindValue(':bname', $bname, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT) 変数に接続。
$stmt->bindValue(':burl', $burl, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':breview', $breview, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':bcomment', $bcomment, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute(); //SQLの実行。errorがあったら、statusにfalseの値を返す

//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]); //基本的には変更しない。エラー文を出さない場合は消去。
}else{
  //５．index.phpへリダイレクト
  header("Location: index.php"); 
  exit;

}
?>
