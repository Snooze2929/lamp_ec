<?php

//設定ファイル読み込み
require_once '../conf/const.php';

//functionsファイル読み込み
require_once MODEL_PATH . 'functions.php';


//セッション開始
session_start();
    
//セッションidの削除
setcookie('PHPSESSID','',time() - 10000,'/');
    
//セッション変数の削除
$_SESSION = array();
    
//セッションファイルの削除
session_destroy();

redirect(STORE_PATH);

?>