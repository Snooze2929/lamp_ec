<?php

//設定ファイル読み込み
require_once '../conf/const.php';

//fanctionsファイル読み込み
require_once MODEL_PATH . 'functions.php';

//userファイル読み込み
require_once MODEL_PATH . 'user.php';

//itemファイル読み込み
require_once MODEL_PATH . 'product.php';


//セッション開始
session_start();


//ログインしていないユーザーの場合ログインページへリダイレクト
if(is_logined() === false){
    
    redirect(STORE_PATH);
    
}


//ログインしているユーザーのuser_typeを取得
$user_type = get_session('user_type');


if($user_type !== 0){
    
    redirect(STORE_PATH);
    
}

//データベース接続
$db = get_db_connect();

//user_idの取得
$user_id = get_session('user_id');

//ログインしているユーザーデータの取得
$login_user = get_user($db,$user_id);

//全商品の取得
$rows = get_products($db);

//トークンの生成
$token = get_token();

//admin_viewの表示
include_once VIEW_PATH . 'admin_view.php';

?>