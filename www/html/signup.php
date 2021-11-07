<?php

//設定ファイル読み込み
require_once '../conf/const.php';

//functionsファイル読み込み
require_once MODEL_PATH . 'functions.php';

//セッション開始
session_start();

//ログイン中のユーザーなら商品ページへリダイレクト
if(is_logined() === true){
    
    redirect(PRODUCTS_PATH);
    
}

//トークン生成
$token = get_token();

//signup_view読み込み
include_once VIEW_PATH . 'signup_view.php';

?>