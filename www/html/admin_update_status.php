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


//公開ステータス
$new_status = get_post('new_status');

//公開ステータス変更対象の商品
$product_id = get_post('product_id');


//商品の公開ステータスを変更する
if(update_status($db,$new_status,$product_id)){
    
    if($new_status === '1'){
    
        set_message('商品を公開しました');
    
    }else{
        
        set_message('商品を非公開にしました');
        
    }
    
}else{
    
    set_error('商品の公開ステータスの変更に失敗しました');
    
}

redirect(ADMIN_PATH);

?>