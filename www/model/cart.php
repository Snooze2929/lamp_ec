<?php

//設定ファイル読み込み
require_once '../conf/const.php';

//functionsファイル読み込み
require_once MODEL_PATH . 'functions.php';


//ユーザーごとにカートデータの取得
function get_user_cart($db,$user_id){
    
    //sql作成
    $sql = 'SELECT ec_cart.cart_id,
                   ec_cart.user_id,
                   ec_cart.product_id,
                   ec_cart.quantity,
                   ec_product_master.product_id,
                   ec_product_master.product_name,
                   ec_product_master.img_file_name,
                   ec_product_master.price,
                   ec_product_master.stock
            FROM   ec_product_master
            JOIN   ec_cart
            ON     ec_product_master.product_id = ec_cart.product_id
            WHERE  user_id = :user_id';
            
    //fetch_all_queryにsqlを渡して実行
    return fetch_all_query($db,$sql,array(':user_id' => $user_id));
    
}

//user_idとproduct_idが一致しているレコードを取得する関数
function get_product_in_cart($db,$user_id,$product_id){
    
    //sql作成
    $sql = 'SELECT ec_cart.user_id,
                   ec_cart.product_id,
                   ec_cart.quantity,
                   ec_product_master.product_id,
                   ec_product_master.product_name,
                   ec_product_master.img_file_name,
                   ec_product_master.price,
                   ec_product_master.stock
            FROM   ec_product_master
            JOIN   ec_cart
            ON     ec_product_master.product_id = ec_cart.product_id
            WHERE  ec_cart.user_id = :user_id
            AND    ec_product_master.product_id = :product_id';
            
    //sqlをfetch_queryに渡して実行
    return fetch_query($db,$sql,array(':user_id' => $user_id,':product_id' => $product_id));
    
}


//カートに商品を入れる
function insert_cart($db,$user_id,$product_id,$quantity = 1){
    
    //sql作成
    $sql = 'INSERT INTO ec_cart(user_id,product_id,quantity)VALUES(:user_id,:product_id,:quantity)';
    
    //execute_queryに値を渡して実行
    return execute_query($db,$sql,array(':user_id' => $user_id,':product_id' => $product_id,':quantity' => $quantity));
    
}

//カートのquantityをアップデートする関数
function update_cart($db,$user_id,$product_id,$quantity){
    
    //sql作成
    $sql = 'UPDATE ec_cart
            SET    quantity = :quantity
            WHERE  user_id = :user_id
            AND    product_id = :product_id';
            
    //sqlをexecute_queryに渡して実行
    return execute_query($db,$sql,array(':quantity' => $quantity,':user_id' => $user_id,':product_id' => $product_id));
    
}


//カートに初めて入れる商品か追加で入れる商品か条件分岐する関数
function add_cart($db,$user_id,$product_id){
    
    //カートに追加する商品が既にカートにあるかチェック
    $cart_product = get_product_in_cart($db,$user_id,$product_id);
    
    //インサートかアップデートか判定
    if(isset($cart_product['quantity'])){
        
        //購入予定個数を+1する
        $quantity = $cart_product['quantity'] + 1;
        
        return update_cart($db,$user_id,$product_id,$quantity);
        
    }else{
        
        return insert_cart($db,$user_id,$product_id);
        
    }
    
}


//カートの中の合計金額の計算
function get_cart_total_price($db,$user_id){
    
    //合計金額
    $total = 0;
    
    //ユーザーごとにカートを取得する
    $user_cart = get_user_cart($db,$user_id);
    
        foreach($user_cart as $row){
                
                $total += $row['price'] * $row['quantity'];
                
            }
            
    
    //合計金額を返す
    return $total;
    
}

//カートの中の商品を削除
function delete_cart($db,$user_id,$product_id){
    
    //sql作成
    $sql = 'DELETE FROM ec_cart
                   WHERE user_id = :user_id
                   AND   product_id = :product_id';
                   
    //sqlをexecute_queryに渡して実行
    return execute_query($db,$sql,array(':user_id' => $user_id,':product_id' => $product_id));
    
}

//quantityに対してstockが足りているか確認する
function count_judge($cart){
    
    foreach($cart as $row){
        
        if($row['stock'] < $row['quantity']){
            
            set_message($row['product_name'] . 'のお取り扱いは現在' . $row['stock'] . '点となっています');
            return false;
            
        }
        
    }
    
    return true;
    
}


?>