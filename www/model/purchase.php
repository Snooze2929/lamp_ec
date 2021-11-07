<?php

//設定ファイル読み込み
require_once '../conf/const.php';

//functionsファイル読み込み
require_once MODEL_PATH . 'functions.php';


//購入時、purchase_historyにインサート
function insert_history($db,$user_id){
    
    //sql作成
    $sql = 'INSERT INTO purchase_history(user_id)
                  VALUES (:user_id)';
    
    //sqlをexecute_queryに渡して実行
    return execute_query($db,$sql,array(':user_id' => $user_id));
    
}

//購入時、purchase_detailにインサート
function insert_detail($db,$order_id,$product_id,$price,$quantity){
    
    //sql作成
    $sql = 'INSERT INTO purchase_detail(order_id,product_id,price,quantity)
                  VALUES (:order_id,:product_id,:price,:quantity)';
    
    //execute_queryにsqlを渡して実行        
    return execute_query($db,$sql,array(':order_id' => $order_id,':product_id' => $product_id,':price' => $price,':quantity' => $quantity));
    
}

//adminユーザーの場合全ての履歴を取得
function get_histories($db){
    
    //sql作成
    $sql = 'SELECT purchase_history.order_id,
                   purchase_history.user_id,
                   purchase_history.datetime,
                   purchase_detail.order_id,
            SUM(purchase_detail.price * purchase_detail.quantity) AS total
            FROM   purchase_history
            JOIN   purchase_detail
            ON     purchase_history.order_id = purchase_detail.order_id
            GROUP BY purchase_detail.order_id
            ';
            
    //sqlをfetch_all_queryに返して実行
    return fetch_all_query($db,$sql);
    
}

//通常ユーザーの場合
function get_history($db,$user_id){
    
    //sql作成
    $sql = 'SELECT purchase_history.order_id,
                   purchase_history.user_id,
                   purchase_history.datetime,
                   purchase_detail.order_id,
            SUM(purchase_detail.price * purchase_detail.quantity) AS total
            FROM   purchase_history
            JOIN   purchase_detail
            ON     purchase_history.order_id = purchase_detail.order_id
            WHERE  user_id = :user_id
            GROUP BY purchase_detail.order_id
            ';
            
    //sqlをfetch_all_queryに返して実行
    return fetch_all_query($db,$sql,array(':user_id' => $user_id));
    
}

//購入明細を取得
function get_detail($db,$order_id){
    
    //sql作成
    $sql = 'SELECT  product_id,
                    price,
                    quantity
            FROM    purchase_detail
            WHERE   order_id = :order_id
            ';
            
    //sqlをfetch_all_queryに返して実行
    return fetch_all_query($db,$sql,array(':order_id' => $order_id));
    
}




?>