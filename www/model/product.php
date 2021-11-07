<?php

//設定ファイル読み込み
require_once '../conf/const.php';

//functions.php読み込み
require_once MODEL_PATH . 'functions.php';

//db.php読み込み
require_once MODEL_PATH . 'db.php';


//最新商品の登録時間を取得
function get_new_datetime($db){
    
    //sql作成
    $sql = 'SELECT MAX(create_datetime)
                FROM   ec_product_master
                WHERE  (genre = 1 or genre = 0) AND status = 1';
                
    return fetch_query($db,$sql,array());
}

//最新商品のレコードを取得
function get_new_item($db,$max_datetime){
    
    //sql作成
    $sql = 'SELECT product_name,
                   img_file_name
            FROM   ec_product_master
            WHERE  create_datetime = :max_datetime';
                
    return fetch_query($db,$sql,array(':max_datetime' => $max_datetime));
                
}

//全ての商品の取得
function get_products($db,$is_open = false){
    
    //sql作成
    $sql = 'SELECT product_id,
                   product_name,
                   price,
                   img_file_name,
                   status,
                   genre,
                   stock
            FROM   ec_product_master
            ';
    
    //$is_openがtrueの場合は公開状態の商品のみ取得する
    if($is_open === true){
        
        $sql .= 'WHERE status = 1';
    }
    
    return fetch_all_query($db,$sql);
}

//指定した商品イメージの取得(detail用)
function get_product($db,$product_id){
    
    //sql作成
    $sql = 'SELECT 
                   img_file_name
            FROM   ec_product_master
            WHERE  product_id = :product_id
            ';
    
    //sqlをfetch_queryに渡して実行
    return fetch_query($db,$sql,array(':product_id' => $product_id));
    
}


//公開中の商品のみ取得
function get_open_product($db){
    
    return get_products($db,true);
    
}


//新規商品登録時の入力内容確認


//商品名の確認
function is_valid_product_name($product_name){
    
    //判定結果
    $is_valid = true;
    
    //スペース削除
    $product_name = space_delete($product_name);
    
    //入力が空白の場合
    if($product_name === ''){
        
        set_error('商品名を入力してください');
        return $is_valid = false;
        
    }
    
    //入力文字数が規定より少ない場合
    if(mb_strlen($product_name) < PRODUCT_NAME_MIN){
        
        set_error('商品名は' . PRODUCT_NAME_MIN . '文字以上で入力してください');
        return $is_valid = false;
        
    }
    
    //入力文字数が規定より多い場合
    if(mb_strlen($product_name) > PRODUCT_NAME_MAX){
        
        set_error('商品名は' . PRODUCT_NAME_MAX . '文字以内で入力してください');
        return $is_valid = false;
        
    }
    
    //判定結果を返す
    return $is_valid;
    
}

//値段の確認
function is_valid_price($price){
    
    //判定結果
    $is_valid = true;
    
    //スペース削除
    $price = space_delete($price);
    
    //入力が空白の場合
    if($price === ''){
        
        set_error('値段を入力してください');
        return $is_valid = false;
        
    }
    
    //入力が半角数字かどうか
    if(preg_match(REGEXP_HALFWIDTH_NUMBER,$price) === 0){
        
        set_error('値段は全て半角数字で入力してください');
        return $is_valid = false;
        
    }
    
    //入力が自然数かどうか
    if(preg_match(REGEXP_POSITIVE_INTEGER,$price) === 0){
        
        set_error('値段は1円以上で入力してください');
        return $is_valid = false;
        
    }
    
    //判定結果を返す
    return $is_valid;
    
}

//在庫数の確認
function is_valid_stock($stock){
    
    //判定結果
    $is_valid = true;
    
    //スペース削除
    $stock = space_delete($stock);
    
    //入力が空白の場合
    if($stock === ''){
        
        set_error('在庫数を入力してください');
        return $is_valid = false;
        
    }
    
    //入力が半角数字かどうか
    if(preg_match(REGEXP_HALFWIDTH_NUMBER,$stock) === 0){
        
        set_error('在庫数は全て半角数字で入力してください');
        return $is_valid = false;
        
    }
    
    //入力が0以上かどうか
    if(preg_match(REGEXP_INTEGER,$stock) === 0){
        
        set_error('在庫数は0以上で入力してください');
        return $is_valid = false;
        
    }
    
    //判定結果を返す
    return $is_valid;
    
}

//商品区分の確認
function is_valid_genre($genre){
    
    //判定結果
    $is_valid = true;
    
    //値の数値化
    $genre = to_quantify($genre);
    
    if(preg_match(REGEXP_GENRE_NUMBER,$genre) === 0){
        
        set_error('入力が不正です');
        return $is_valid = false;
        
    }
    
    //判定結果を返す
    return $is_valid;
    
}

//公開ステータスの確認
function is_valid_status($status){
    
    //判定結果
    $is_valid = true;
    
    //値の数値化
    $status = to_quantify($status);
    
    if(preg_match(REGEXP_STATUS_NUMBER,$status) === 0){
        
        set_error('入力が不正です-');
        return $is_valid = false;
        
    }
    
    //判定結果を返す
    return $is_valid;
    
}

//ファイル取得の確認
function is_valid_filename($filename){
    
    //判定結果
    $is_valid = true;
    
    //取得できていない場合
    if($filename === ''){
        
        set_error('ファイルを取得できませんでした');
        return $is_valid = false;
        
    }
    
    return $is_valid;
}


//商品を登録する


function regist_product($db,$product_name,$new_file,$price,$genre,$status,$stock){
    
    //ファイルシステム上に保存したファイルの取得
    $filename = get_upload_filename($new_file);
    
    //新規商品登録の入力の判定をし、不備があった場合
    if(get_product_judge($product_name,$filename,$price,$genre,$status,$stock) && save_image($new_file,$filename) === false){
        
        return false;
        
    }
    
    //ec_item_masterとec_item_stockにデータをインサートする
    return insert_product_transaction($db,$product_name,$filename,$price,$genre,$status,$stock);
    
}


//新規商品の入力判定
function get_product_judge($product_name,$filename,$price,$genre,$status,$stock){
    
    //短絡評価回避
    $product_name = is_valid_product_name($product_name);
    $filename = is_valid_filename($filename);
    $price = is_valid_price($price);
    $genre = is_valid_genre($genre);
    $status = is_valid_status($status);
    $stock = is_valid_stock($stock);
    
    //判定結果を返す
    return $product_name && $filename && $price && $genre && $status && $stock;
}

//入力されたデータをインサートをトランザクションで処理する
function insert_product_transaction($db,$product_name,$filename,$price,$genre,$status,$stock){
    
    //トランザクシション開始
    $db->beginTransaction();
    
    //商品データと商品画像の保存に成功した場合
    if(insert_product($db,$product_name,$filename,$price,$genre,$status,$stock) === true){
        
        //処理の確定をする
        $db->commit();
        return true;
        
    }
    
    //商品データと商品画像の保存に失敗した場合
    
    //処理の取り消し
    $db->rollback();
    return false;
    
}

//インサート実行
function insert_product($db,$product_name,$filename,$price,$genre,$status,$stock){
    
    //商品登録日時
    $datetime = date('Y-m-d H:i:s');
    
    //sql作成
    $sql = 'INSERT INTO ec_product_master(product_name,img_file_name,price,genre,status,stock,create_datetime)VALUES(:product_name,:img_file_name,:price,:genre,:status,:stock,:create_datetime)';
    
    return execute_query($db,$sql,array(':product_name' => $product_name,':img_file_name' => $filename,':price' => $price,':genre' => $genre,':status' => $status,':stock' => $stock,':create_datetime' => $datetime));
    
}


//商品の在庫数の更新をする


function update_stock($db,$stock,$product_id){
    
    //在庫数の入力が正しい場合
    if(is_valid_stock($stock)){
    
        //sql作成
        $sql = 'UPDATE  ec_product_master
                SET     stock = :stock
                WHERE   product_id = :product_id
                LIMIT 1';
        
        //execute_queryにsqlを渡して実行
        return execute_query($db,$sql,array(':stock' => $stock,':product_id' => $product_id));
        
    }
        
    //在庫数の入力が正しくない場合
        
        return false;
        
    
}


//商品の公開ステータスを変更する


function update_status($db,$new_status,$product_id){
    
    //ステータスの値が正しい場合
    if(is_valid_status($new_status)){
    
    //sql作成
    $sql = 'UPDATE ec_product_master
            SET    status = :status
            WHERE  product_id = :product_id
            LIMIT 1';
            
    //execute_queryにsqlを渡して実行
    return execute_query($db,$sql,array(':status' => $new_status,':product_id' => $product_id));
    
    }
    
    //ステータスの入力が正しくない場合
    return false;
    
}


//商品を削除する


function product_delete($db,$product_id){
    
    //sql作成
    $sql = 'DELETE FROM ec_product_master
                  WHERE product_id = :product_id';
                  
    //execute_queryにsqlを渡して実行
    return execute_query($db,$sql,array(':product_id' => $product_id));
    
}









?>