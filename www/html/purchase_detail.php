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

//purchaseファイル読み込み
require_once MODEL_PATH . 'purchase.php';


//セッション開始
session_start();


//postされたトークンの取得
$token = get_post('token');

//セッション'csrf_token'と値が一致しているか確認
if(check_token($token) === false){
    
    //一致していない場合
    redirect(STORE_PATH);
    
}

//一致していた場合
unset($_SESSION['csrf_token']);

//ログインしているユーザーか確認
if(is_logined() === false){
    
    //ログインしていなかった場合
    redirect(STORE_PATH);
    
}


//データベース接続
$db = get_db_connect();


//ログインしているユーザーのuser_idをセッションから取得
$user_id = get_session('user_id');

//ログインしているユーザーのユーザー情報を取得
$login_user = get_user($db,$user_id);


//postされたorder_idを取得
$order_id = get_post('order_id');

//購入明細の取得
$details = get_detail($db,$order_id);

//購入した商品の種類の分、product_idを取得し各配列に対して更新していく

$i = 0;

foreach($details as $row){
    
    
    $product = get_product($db,$row['product_id']);

    $details[$i]['img_file_name'] = $product['img_file_name'];
    
    $i++;
    
}

//購入明細画面の表示
require_once VIEW_PATH . 'purchase_detail_view.php'; 


?>