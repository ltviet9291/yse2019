<?php
/* 
【機能】
入荷で入力された個数を表示する。入荷を実行した場合は対象の書籍の在庫数に入荷数を加
えた数でデータベースの書籍の在庫数を更新する。

【エラー一覧（エラー表示：発生条件）】
なし
*/

session_start();
function getByid($id,$con){
	$sql = "select * from books where books.id=$id ";
		$result = $con->query($sql);

		return $result->fetch_assoc();

}

function updateByid($id,$con,$total){
	$sql = "UPDATE books SET stock = stock+$total WHERE books.id=$id ";
}

if ($_SESSION["login"] == false){
	$_SESSION ["error2"] = 'ログインしてください';
	header ( "Location:login.php" );
}

 $con = mysqli_connect("localhost" , "zaiko2019_yse" , "2019zaiko" , "zaiko2019_yse");
	mysqli_set_charset($con,"UTF8");
$books1=0;
foreach($_POST["books"] as $g){
	if (is_numeric($_POST["stock"] as $books1)) {
		$_SESSION["error"] = "数値以外が入力されています";
		include'nyuka.php';
		exit;
	}
		$rock= getByid($g,$con);
	//⑰ ⑯で取得した書籍の情報の「stock」と、⑩の変数を元にPOSTの「stock」から値を取り出し、足した値を変数に保存する。

	//⑱ ⑰の値が100を超えているか判定する。超えていた場合はif文の中に入る。
	if(/* ⑱の処理を行う */){
		$_SESSION["error"] = "最大在庫数を超える数は入力できません";
		include'nyuka.php';
		exit;
	}
	
	$books1++;
}

if(@$_POST['add']){
$books1=0;
	$books=$_POST["books"];
	foreach($goods as $g){
		//㉗ ㉖で取得した書籍の情報の「stock」と、㉔の変数を元にPOSTの「stock」から値を取り出し、足した値を変数に保存する。
		//㉘「updateByid」関数を呼び出す。その際に引数に㉕の処理で取得した値と⑧のDBの接続情報と㉗で計算した値を渡す。
		//㉙ ㉔で宣言した変数をインクリメントで値を1増やす。
		$rock= getByid($books,$con);
		
	}

		$_SESSION["success"] = "入荷が完了しました";
		header ('Location:zaiko_ichiran.php');
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>入荷確認</title>
	<link rel="stylesheet" href="css/ichiran.css" type="text/css" />
</head>
<body>
	<div id="header">
		<h1>入荷確認</h1>
	</div>
	<form action="nyuka_kakunin.php" method="post" id="test">
		<div id="pagebody">
			<div id="center">
				<table>
					<thead>
						<tr>
							<th id="book_name">書籍名</th>
							<th id="stock">在庫数</th>
							<th id="stock">入荷数</th>
						</tr>
					</thead>
					<tbody>
						<?php
$books1=0;
						foreach($books as $q){
						$rock= getByid($books1,$con);
						?>
						<tr>
							<td><?php echo	$rock['title'];?></td>
							<td><?php echo	$rock['stock'];?></td>
							<td><?php echo	$books1=$_POST["stock"];?></td>
						</tr>
						<input type="hidden" name="books[]" value="<?php echo $q; ?>">
						<input type="hidden" name="stock[]" value='<?php echo $books1=$_POST["stock"];?>'>
						<?php
							$books1++;
						}
						?>
					</tbody>
				</table>
				<div id="kakunin">
					<p>
						上記の書籍を入荷します。<br>
						よろしいですか？
					</p>
					<button type="submit" id="message" formmethod="POST" name="add" value="ok">はい</button>
					<button type="submit" id="message" formaction="nyuka.php">いいえ</button>
				</div>
			</div>
		</div>
	</form>
	<div id="footer">
		<footer>株式会社アクロイト</footer>
	</div>
</body>
</html>
