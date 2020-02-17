<?php
/* 
【機能】
	セッション情報を削除しログイン画面に遷移する。
*/
session_start();

session_destroy();

// リダイレクト
header( "Location: ./login.php" ) ;
?>