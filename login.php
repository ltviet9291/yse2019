<?php
/* 
【機能】
	　ユーザ名とパスワードを元に認証を行う。認証についてはソースコードに
	直接記述されているユーザ名とパスワードが一致しているかを確認する。
	一致していた場合はログインして書籍一覧を表示し、ログインできない
	場合はエラーとする。

【エラー一覧（エラー表示：発生条件）】
	名前かパスワードが未入力です：IDまたはパスワードが未入力
	ユーザー名かパスワードが間違っています：①IDが間違っている　②IDが正しいがパスワードが異なる
	ログインしてください：ログインしていない状態で他のページに遷移した場合(ログイン画面に遷移し上記を表示)
*/
session_start ();
$name = "";
$pass = "";
error_reporting ( E_ALL & ~ E_NOTICE );

if (! empty ( $_POST ["decision"] )) {
	if (! empty ( $_POST ["name"] && $_POST ["pass"] )) {
		$name = $_POST ["name"];
		$pass = $_POST ["pass"];
	} else {
		$msg="名前かパスワードが未入力です";
	}
}
if (! empty ( $name )) {
	if ($name=="yse"&&$pass=="2019"){
		$_SESSION ["login"] = true;
		$_SESSION ["account_name"] = $name;
		header ( "Location:zaiko_ichiran.php" );
	}else{
		$msg="ユーザー名かパスワードが間違っています";
	}
}

if (! empty ( $_SESSION ["error"] )) {
	$error = $_SESSION ["error"];
	$_SESSION ["error"] = null;
}
if (! empty ( $_SESSION ["error2"] )) {
	$error = $_SESSION ["error2"];
	$_SESSION ["error2"] = null;
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>ログイン</title>
<link rel="stylesheet" href="css/login.css" type="text/css" />
</head>
<body id="login">
	<div id="main">
		<h1>ログイン</h1>
		<?php 	echo "<div id='error'>", $error, "</div>";
				echo "<div id='msg'>", $msg, "</div>";?>
	<form action="login.php" method="post" id="log">
			<p>
				<input type='text' name="name" size='5' placeholder="Username">
			</p>
			<p>
				<input type='password' name='pass' size='5' maxlength='20'
					placeholder="Password">
			</p>
			<p>
				<button type="submit" formmethod="POST" name="decision" value="1"
					id="button">Login</button>
			</p>
		</form>
	</div>
</body>
</html>
