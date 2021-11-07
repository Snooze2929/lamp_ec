<?php 

//設定ファイル読み込み
require_once '../conf/const.php';

//functionファイル読み込み
require_once MODEL_PATH . 'functions.php';

//dbファイル読み込み
require_once MODEL_PATH . 'db.php';

//userファイル読み込み
require_once MODEL_PATH . 'user.php';

//productファイル読み込み
require_once MODEL_PATH . 'product.php';

//cartファイル読み込み
require_once MODEL_PATH . 'cart.php';

//purchaseファイル読み込み
require_once MODEL_PATH . 'purchase.php';


//セッション開始
session_start();


//ログインしているユーザーかどうか
if(is_logined() === false){
    
    //ログインしていない場合ログインページへリダイレクト
    redirect(STORE_PATH);
    
}


//データベース接続
$db = get_db_connect();


//購入したユーザーのuser_idを取得
$user_id = get_session('user_id');

//購入したユーザーのユーザー情報の取得
$login_user = get_user($db,$user_id);

//該当のユーザーのカートを取得
$rows = get_user_cart($db,$user_id);


//購入個数が在庫数を超えた場合
if(count_judge($rows) === false){
    
    //カートページへリダイレクト
    redirect(CART_PATH);
    
}


//商品の数だけ在庫数のアップデートを実行する
foreach($rows as $row){
    
    if(update_stock($db,$row['stock'] - $row['quantity'],$row['product_id']) === false){
        
        set_error($row['product_name'] . 'は購入できませんでした。お手数ですが管理者にお問い合わせください。');
        redirect(CONTACT_PATH);
        
    }
    
}

//カートの合計金額の計算
$total = get_cart_total_price($db,$user_id);


//購入履歴へインサート
if(insert_history($db,$user_id) === false){
    
    set_error('購入履歴の追加に失敗しました');
    
}


//最後の購入履歴(order_id)取得する
$order_id = $db->lastInsertid();


//購入した商品の種類の数だけ購入明細にインサートしカートの商品を削除する
foreach($rows as $row){
    
    if(insert_detail($db,$order_id,$row['product_id'],$row['price'],$row['quantity'])){
    
        delete_cart($db,$row['user_id'],$row['product_id']);
    
     }else{
         
         set_error('購入明細の追加に失敗しました');
         
     }
     
}


//購入後画面へ
include_once VIEW_PATH . 'finish_view.php';


?>