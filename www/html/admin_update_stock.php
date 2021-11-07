<?php

//設定ファイル読み込み
require_once '../conf/const.php';

//fanctionファイル読み込み
require_once MODEL_PATH . 'functions.php';

//productファイル読み込み
require_once MODEL_PATH . 'product.php';


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


//ユーザータイプの取得
$user_type = this_user_type();

//adminユーザーかどうか
if($user_type !== 0){
    
    //adminユーザーではない場合ログインページへリダイレクト
    redirect(STORE_PATH);
    
}


//データベース接続
$db = get_db_connect();


//postされたデータの取得


//在庫数
$new_stock = get_post('new_stock');

//在庫数更新対象の商品
$product_id = get_post('product_id');


//在庫数の更新をする
if(update_stock($db,$new_stock,$product_id)){
    
    set_message('在庫数を更新しました');
    
}else{
    
    set_error('在庫数の更新に失敗しました');
    
}

redirect(ADMIN_PATH);


