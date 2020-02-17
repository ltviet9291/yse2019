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
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				return $row;
			}
		}
	}
	function updateByid($id,$con,$total){
		$sql="UPDATE books set stock=$total WHERE id=$id ";
		return $result = $con->query($sql);		
	}

	if ($_SESSION["login"]!=true){
		$_SESSION["error2"]="ログインしてください";
		header ( "Location:login.php" );
		exit();
	}


	$con = mysqli_connect("localhost" , "zaiko2019_yse" , "2019zaiko" , "zaiko2019_yse");
	mysqli_set_charset($con,"UTF8");
	
	$sn=0;
	foreach( $_POST["books"] as $bookNo){

		if (!is_numeric($_POST["stock"][$sn])) {
			$_SESSION['error']="数値以外が入力されています";
			include("nyuka.php");
			exit();
		}

		$rock= getByid($bookNo,$con);
		$total=$rock["stock"]+$_POST["stock"][$sn];
		if($total >100){
			$_SESSION['error']="最大在庫数を超える数は入力できません";
			include("nyuka.php");
			exit();
		}
		$sn++;
	}

	if(@$_POST["add"]=="ok"){
		$sn=0;
		$result;
		foreach( $_POST["books"] as $bookNo){
			$rock= getByid($bookNo,$con);
			$total=$rock["stock"]+$_POST["stock"][$sn];
			$result= updateByid($bookNo,$con,$total);
			$sn++;
		}
		if($result){
			$_SESSION['success']="入荷が完了しました";
			header("location:zaiko_ichiran.php");
		}
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
    				$sn=0;
    				foreach( $_POST["books"] as $bookNo){
					$rock= getByid($bookNo,$con);
							?>
						<tr>
							<td><?php echo	$rock["title"];?></td>
							<td><?php echo	$rock["stock"];?></td>
							<td><?php echo	$_POST["stock"][$sn];?></td>
						</tr>
						<input type="hidden" name="books[]" value="<?php echo $bookNo;?>">
						<input type="hidden" name="stock[]" value='<?php echo $_POST["stock"][$sn];?>'>
						<?php $sn++;}?>
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
