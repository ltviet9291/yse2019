<?php
/* 
【機能】
書籍の出荷数を指定する。確定ボタンを押すことで確認画面へ出荷個数を引き継いで遷移す
る。

【エラー一覧（エラー表示：発生条件）】
このフィールドを入力して下さい(吹き出し)：出荷個数が未入力
出荷する個数が在庫数を超えています：出荷したい個数が在庫数を超えている
数値以外が入力されています：入力された値に数字以外の文字が含まれている
*/

	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	if ($_SESSION["login"]!=true){
		$_SESSION["error2"]="ログインしてください";
		header ( "Location:login.php" );
		exit();
	}

	function getId($id,$con){
		$sql = "select * from books where books.id=$id ";
		$result = $con->query($sql);

		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				return $row;
			}	
		}
	}
	$con = mysqli_connect("localhost" , "zaiko2019_yse" , "2019zaiko" , "zaiko2019_yse");
	mysqli_set_charset($con,"UTF8");
	$sql = "select * from books";
	$rst = mysqli_query($con,$sql) or die("select失敗".mysqli_error($con));


	if(!@$_POST["books"]){
		$_SESSION['success']="出荷する商品が選択されていません";
		header("location:zaiko_ichiran.php?page=1");
	}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>出荷</title>
<link rel="stylesheet" href="css/ichiran.css" type="text/css" />
</head>
<body>
<!-- ヘッダ -->
<div id="header">
	<h1>出荷</h1>
</div>

<!-- メニュー -->
<div id="menu">
	<nav>
		<ul>
			<li><a href="zaiko_ichiran.php?page=1">書籍一覧</a></li>
		</ul>
	</nav>
</div>

<form action="syukka_kakunin.php" method="post">
	<div id="pagebody">
		<!-- エラーメッセージ -->
		<div id="error"><?php echo @$_SESSION['error'];@$_SESSION['error']="";?></div>
		<div id="center">
			<table>
				<thead>
					<tr>
						<th id="id">ID</th>
						<th id="book_name">書籍名</th>
						<th id="author">著者名</th>
						<th id="salesDate">発売日</th>
						<th id="itemPrice">金額(円)</th>
						<th id="stock">在庫数</th>
						<th id="in">出荷数</th>
					</tr>
				</thead>
				<?php 
				foreach( $_POST["books"] as $bookNo){
				$rock= getId($bookNo,$con);
					//print_r($rock);
						?>
				<input type="hidden" value="<?php echo	$rock["id"];?>" name="books[]">
				<tr>
					<td><?php echo	$rock["id"];?></td>
					<td><?php echo	$rock["title"];?></td>
					<td><?php echo	$rock["author"];?></td>
					<td><?php echo	$rock["salesDate"];?></td>
					<td><?php echo	$rock["price"];?></td>
					<td><?php echo	$rock["stock"];?></td>
					<td><input type='text' name='stock[]' size='5' maxlength='11' required></td>
				</tr>
				<?php }?>
			</table>
			<button type="submit" id="kakutei" formmethod="POST" name="decision" value="1">確定</button>
		</div>
	</div>
</form>
<!-- フッター -->
<div id="footer">
	<footer>株式会社アクロイト</footer>
</div>
</body>
</html>
