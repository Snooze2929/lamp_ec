<?php

//const.php読み込み
require_once '../conf/const.php';

//functions読み込み
require_once MODEL_PATH . 'functions.php';

//セッション開始
session_start();


//既にログインしたユーザーであればproductsページへリダイレクト
if(is_logined() === true){
    
    if(get_session('user_type') !== 0){
        
        redirect(PRODUCT_PATH);
        
    }
    
    redirect(ADMIN_PATH);
    
}

//トークンの生成
$token = get_token();

//store.php(ログインページの読み込み)
include_once VIEW_PATH . 'store_view.php';


?>