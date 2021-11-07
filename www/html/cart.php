<?php

//設定ファイル読み込み
require_once '../conf/const.php';

//functionsファイル読み込み
require_once MODEL_PATH . 'functions.php';

//dbファイル読み込み
require_once MODEL_PATH . 'db.php';

//userファイル読み込み
require_once MODEL_PATH . 'user.php';

//cartファイル読み込み
require_once MODEL_PATH . 'cart.php';


//セッション開始
session_start();


//ログインしているユーザーかどうか
if(is_logined() === false){
    
    //ログインしていない場合ログインページへリダイレクト
    redirect(STORE_PATH);
    
}


//データベース接続
$db = get_db_connect();


//カートページを表示するユーザーの取得
$user_id = get_session('user_id');

//カートページを表示するユーザー情報の取得
$login_user = get_user($db,$user_id);

//ユーザーごとにカートデータの取得
$rows = get_user_cart($db,$user_id);

//カートの合計金額の計算
if(isset($rows)){
    $total = get_cart_total_price($db,$user_id);
}

//トークンの生成
$token = get_token();


//カートページの出力
require_once VIEW_PATH . 'cart_view.php';

