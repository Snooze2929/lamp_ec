<?php

//設定ファイル読み込み
require_once '../conf/const.php';

//fanctionファイル読み込み
require_once MODEL_PATH . 'functions.php';

//dbファイル読み込み
require_once MODEL_PATH . 'db.php';

//cartファイル読み込み
require_once MODEL_PATH . 'cart.php';


//セッション開始
session_start();


//postされたトークンの取得
$token = get_post('token');

//セッションの'csrf_token'と値を比べる
if(check_token($token) === false){
    
    //値が一致しない場合ログインページへリダイレクト
    redirect(STORE_PATH);
    
}


//一致した場合セッションのトークンの削除
unset($_SESSION['csrf_token']);


//ログインしたユーザーかどうか
if(is_logined() === false){
    
    //ログインしていない場合ログインページへリダイレクト
    redirect(STORE_PATH);
    
}


//データベース接続
$db = get_db_connect();


//postされたデータの取得


//カートデータを消すユーザー
$user_id = get_post('user_id');

//対象商品
$product_id = get_post('product_id');


//削除の実行
if(delete_cart($db,$user_id,$product_id)){
    
    set_message('商品の購入をキャンセルしました');
    
}

redirect(CART_PATH);


?>