<?php

//設定ファイル読み込み
require_once '../conf/const.php';

//functionsファイル読み込み
require_once MODEL_PATH . 'functions.php';

//userファイル読み込み
require_once MODEL_PATH . 'user.php';


//セッション開始
session_start();

//postで送られたトークンの取得
$token = get_post('token');

//$tokenとセッション'csrf_token'の値が一致するか
if(check_token($token) === false){
    
    //一致していなければトップページへリダイレクト
    redirect(TOP_PATH);
    
}

//一致していればセッションのトークンを削除する
unset($_SESSION['csrf_token']);


//ログイン中のユーザーなら商品ページへリダイレクト
if(is_logined() === true){
    
    redirect(PRODUCTS_PATH);
    
}


//入力内容の取得


//user_nameの取得
$user_name = $_POST['user_name'];

//passwordの取得
$password = $_POST['password'];

//e_mailの取得
$e_mail = $_POST['e_mail'];

//addressの取得
$address = $_POST['address'];


//データベース接続
$db = get_db_connect();


//登録に失敗した場合
if(new_regist($db,$user_name,$password,$e_mail,$address) === false){
    
    //signup.phpへリダイレクト
    redirect(SIGNUP_PATH);

//登録に成功した場合
}else{
    
    //登録完了メッセージ
    set_message('会員登録が完了しました');
    
    //store.php(ログインページ)へリダイレクト
    redirect(STORE_PATH);
    
}









?>