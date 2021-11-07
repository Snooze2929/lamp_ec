<?php

//設定ファイル読み込み
require_once '../conf/const.php';

//functionsファイル読み込み
require_once MODEL_PATH . 'functions.php';

//dbファイル読み込み
require_once MODEL_PATH . 'db.php';

//cartファイル読み込み
require_once MODEL_PATH . 'cart.php';


//セッション開始
session_start();


//postされたトークンの取得
$token = get_post('token');

//セッション変数'csrf_token'の値と一致するか確認
if(check_token($token) === false){
    
    //一致していない場合
    redirect(STORE_PATH);
    
}

//一致した場合トークンを削除する
unset($_SESSION['csrf_token']);

//ログインしているユーザーかどうか
if(is_logined() === false){
    
    //ログインしていない場合ログインページへリダイレクト
    redirect(STORE_PATH);
    
}


//カート追加を実行したユーザーidの取得
$user_id = get_session('user_id');


//postされたデータの取得


//カート追加対象の商品
$product_id = get_post('product_id');

//product_idのint化
$product_id = to_quantify($product_id);

//データベース接続
$db = get_db_connect();

//ユーザーごとにカートテーブルを取得
//$this_user_cart = get_user_cart($db,$user_id);

if(add_cart($db,$user_id,$product_id)){
    
    set_message('カートに商品を追加しました');
    
}

redirect(PRODUCT_PATH);




?>