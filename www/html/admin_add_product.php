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

//セッションの'csrf_token'と値が一致しているか確認
if(check_token($token) === false){
    
    //一致していない場合
    redirect(STORE_PATH);
    
}

//一致している場合セッションの'csrf_token'を削除する
unset($_SESSION['csrf_token']);


//ログインしていないユーザーの場合ログインページへリダイレクト
if(is_logined() === false){
    
    redirect(STORE_PATH);
    
}

//ユーザータイプの取得
$user_type = this_user_type();

//adminユーザーかどうか
if($user_type !== 0){
    
    //adminユーザーではない場合ログインページへリダイレクト
    redirect(STORE_PATH);
    
}

//新規商品登録でpostしたデータの取得


//商品名
$product_name = get_post('product_name');

//値段
$price = get_post('price');

//商品イメージ
$new_file = get_files('new_file');

//在庫数
$stock = get_post('stock');

//商品区分
$genre = get_post('genre');

//公開ステータス
$status = get_post('status');

//データベース接続
$db = get_db_connect();

if(regist_product($db,$product_name,$new_file,$price,$genre,$status,$stock)){
    
    set_message('商品を登録しました');
    
}else{
    
    set_error('商品の登録に失敗しました');
    
}

//admin_view.phpへリダイレクト
redirect(ADMIN_PATH);



?>