<?php

//設定ファイル読み込み
require_once '../conf/const.php';

//functionsファイル読み込み
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
unset($S_SESSION['csrf_token']);

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


//postされた値の取得


//削除対象の商品
$product_id = get_post('product_id');


//商品削除関数の実行
if(product_delete($db,$product_id)){
    
    set_message('商品を削除しました');
    
}else{
    
    set_error('商品の削除に失敗しました');
    
}

redirect(ADMIN_PATH);


?>