<?php
//設定ファイル読み込み
require_once '../conf/const.php';

//functionsファイル読み込み
require_once MODEL_PATH . 'functions.php';

//userファイル読み込み
require_once MODEL_PATH . 'user.php';


//セッション開始
session_start();


//postされたトークンの取得
$token = get_post('token');

//トークンが一致しているか確認
if(check_token($token) === false){
    
    //一致していなければstore.phpへ(ログイン画面へリダイレクト)
    redirect(STORE_PATH);
    
}

//一致していればセッションのトークンを削除する
unset($_SESSION['csrf_token']);

//ログイン中であればproducts.phpへリダイレクト
if(is_logined() === true){
    
    redirect(PRODUCT_PATH);
    
}

//データベース接続
$db = get_db_connect();

//入力されたユーザーネームの取得
$user_name = get_post('user_name');

//入力されたパスワードの取得
$password = get_post('password');

//ログインするユーザーデータの取得
$login_user = login_user($db,$user_name,$password);

//ユーザーネームまたはパスワードがec_userテーブルの物と一致しない場合
if($login_user === false){
    
    set_error('ユーザーネームまたはパスワードが違います');
    redirect(STORE_PATH);
    
}


//セッションにuser_id,user_typeをセットしておく
set_session('user_id',$login_user['user_id']);
set_session('user_type',$login_user['user_type']);


//ユーザータイプによってリダイレクト先を分岐する
if($login_user['user_type'] !== 0){
    
    redirect(PRODUCT_PATH);
    
}else{
    
    redirect(ADMIN_PATH);
    
}

?>