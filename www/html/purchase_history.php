<?php

//設定ファオル読み込み
require_once '../conf/const.php';

//functionsファイル読み込み
require_once MODEL_PATH . 'functions.php';

//dbファイル読み込み
require_once MODEL_PATH . 'db.php';

//userファイル読み込み
require_once MODEL_PATH . 'user.php';

//purchaseファイル読み込み
require_once MODEL_PATH . 'purchase.php';


//セッション開始
session_start();


//ユーザーがログインしているか確認
if(is_logined() === false){
    
    //ログインしていない場合
    redirect(STORE_PATH);
    
}


//データベース接続
$db = get_db_connect();

//ログインしているユーザーごとに購入履歴を取得
$user_id = get_session('user_id');

$login_user = get_user($db,$user_id);

//adminの場合
if($login_user['user_type'] === 0){
    
    //全てのユーザーの購入履歴を取得
    $histories = get_histories($db);

//通常ユーザーの場合
}else{
    
    //ユーザー毎に購入履歴の取得
    $histories = get_history($db,$user_id);
    
}


//トークンの生成
$token = get_token();

//購入履歴画面を表示
require_once VIEW_PATH . 'purchase_history_view.php';


?>