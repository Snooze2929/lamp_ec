<?php

//設定ファイル読み込み
require_once '../conf/const.php';

//functionsファイル読み込み
require_once MODEL_PATH . 'functions.php';

//dbファイル読み込み
require_once MODEL_PATH . 'db.php';

//userファイル読み込み
require_once MODEL_PATH . 'user.php';

//productファイル読み込み
require_once MODEL_PATH . 'product.php';


//セッション開始
session_start();

//ユーザーがログインしているかどうか
if(is_logined() === false){
    
    //ログインしていない場合
    redirect(STORE_PATH);
    
}

//データベース接続
$db = get_db_connect();

//セッション変数'user_id'の取得
$user_id = get_session('user_id');

//ログインしているユーザー情報の取得
$login_user = get_user($db,$user_id);

//公開中の商品情報の取得
$rows = get_open_product($db);

//トークンの作成
$token = get_token();

require_once VIEW_PATH . 'product_view.php';

?>