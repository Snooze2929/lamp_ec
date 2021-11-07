<?php

//設定ファイル読み込み
require_once '../conf/const.php';

//functionsファイル読み込み
require_once MODEL_PATH . 'functions.php';

//dbファイル読み込み
require_once MODEL_PATH . 'db.php';

//user_idの一致するユーザーデータの取得
function get_user($db,$user_id){
    
    //sql作成
    $sql = 'SELECT user_id,
                   user_name,
                   password,
                   user_type,
                   e_mail,
                   address
            FROM   ec_user
            WHERE  user_id = :user_id';
    
    return fetch_query($db,$sql,array(':user_id' => $user_id));
                   
}

//ログイン可否
function login_user($db,$user_name,$password){
    
    //入力内容と一致するユーザーネームとパスワードを取得
    $login_user = get_match_user($db,$user_name,$password);
    
    //入力内容とec_userテーブルのユーザーネームとパスワードが一致する場合
    if($user_name === $login_user['user_name'] && $password === $login_user['password']){
        
        return $login_user;
        
    }else{
        
        return false;
        
    }
}

//ユーザー名とパスワードが一致するレコードの取得(ログイン時に入力が正しいか確認のため)
function get_match_user($db,$user_name,$password){
    
    //sql作成
    $sql = 'SELECT user_id,
                   user_name,
                   password,
                   user_type
            FROM   ec_user
            WHERE  user_name = :user_name
            AND     password  = :password
            LIMIT 1';
            
    return fetch_query($db,$sql,array(':user_name' => $user_name,':password' => $password));
}


//新規登録時の入力内容判定


//user_name


function is_valid_user_name($user_name){
    
    //判定結果
    $is_valid = true;
    
    //スペース削除
    $user_name = space_delete($user_name);
    
    //入力が空白の場合
    if($user_name === ''){
        
        set_error('ユーザーネームを入力してください');
        return $is_valid = false;
        
    }
    
    //入力文字数が規定より少ない場合
    if(mb_strlen($user_name) < USER_NAME_MIN){
        
        set_error('ユーザーネームは' . USER_NAME_MIN . '文字以上で入力してください');
        return $is_valid = false;
        
    }
    
    //入力文字数が規定より多い場合
    if(mb_strlen($user_name) > USER_NAME_MAX){
        
        set_error('ユーザーネームは' . USER_NAME_MAX . '文字以内で入力してください');
        return $is_valid = false;
        
    }
    
    //入力内容が全て英数字かどうか
    if(preg_match(REGEXP_ALPHANUMERIC,$user_name) === 0){
        
        set_error('ユーザーネームは全て英数字で入力してください');
        return $is_valid = false;
        
    }
    
    //判定結果を返す
    return $is_valid;
    
}


//password


function is_valid_password($password){
    
    //判定結果
    $is_valid = true;
    
    //スペース削除
    $password = space_delete($password);
    
    //入力が空白の場合
    if($password === ''){
        
        set_error('パスワードを入力してください');
        return $is_valid = false;
        
    }
    
    //入力文字数が規定より少ない場合
    if(mb_strlen($password) < PASSWORD_MIN){
        
        set_error('パスワードは' . PASSWORD_MIN . '文字以上で入力してください');
        return $is_valid = false;
        
    }
    
    //入力文字数が規定より多い場合
    if(mb_strlen($password) > PASSWORD_MAX){
        
        set_error('パスワードは' . PASSWORD_MAX . '文字以内で入力してください');
        return $is_valid = false;
        
    }
    
    //入力内容が全て英数字かどうか
    if(preg_match(REGEXP_ALPHANUMERIC,$password) === 0){
        
        set_error('パスワードは全て英数字で入力してください');
        return $is_valid = false;
        
    }
    
    //判定結果を返す
    return $is_valid;
    
}


//e_mail


function is_valid_e_mail($e_mail){
    
    //判定結果
    $is_valid = true;
    
    //スペース削除
    $e_mail = space_delete($e_mail);
    
    //入力が空白の場合
    if($e_mail === ''){
        
        set_error('メールアドレスを入力してください');
        return $is_valid = false;
        
    }
    
    //正しいメールアドレスではなかった場合
    if(preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9._-]+)+$/",$e_mail) === 0){
        
        set_error('このメールアドレスは不正です');
        return $is_valid = false;
        
    }
    
    //判定結果を返す
    return $is_valid;
    
}


//address


function is_valid_address($address){
    
    //判定結果
    $is_valid = true;
    
    //スペース削除
    $address = space_delete($address);
    
    //入力が空白だった場合
    if($address === ''){
        
        set_error('住所を入力してください');
        return $is_valid = false;
        
    }
    
    //正しい住所ではなかった場合
    if(preg_match('/(東京都|北海道|(?:京都|大阪)府|.{6,9}県)((?:四日市|廿日市|野々市|臼杵|かすみがうら|つくばみらい|いちき串木野)市|(?:杵島郡大町|余市郡余市|高市郡高取)町|.{3,12}市.{3,12}区|.{3,9}区|.{3,15}市(?=.*市)|.{3,15}市|.{6,27}町(?=.*町)|.{6,27}町|.{9,24}村(?=.*村)|.{9,24}村)(.*)/',$address) === 0){
        
        set_error('この住所は不正です');
        return $is_valid = false;
        
    }
    
    return $is_valid;
    
}


//新規登録


//新規登録の判定
function new_regist($db,$user_name,$password,$e_mail,$address){
    
    //入力に不備があった場合
    if(get_user_judge($user_name,$password,$e_mail,$address) === false){
        
        set_error('登録に失敗しました');
        return false;
    }
    
    //ユーザーネームに重複がある場合
    if(get_match_user_name($db,$user_name) !== false){
        
        set_error('このユーザーネームは既に使われています');
        set_error('登録に失敗しました');
        return false;
        
    }
    
    //登録日時
    $datetime = date('Y-m-d H:i:s');
    
    //入力に不備がない且つユーザーネームに重複がない場合新規登録の実行
    return insert_user_data($db,$user_name,$password,$e_mail,$address,$datetime);
    
}

//判定結果の取得
function get_user_judge($user_name,$password,$e_mail,$address){
    
    //短絡評価回避
    $valid_name = is_valid_user_name($user_name);
    $valid_password = is_valid_password($password);
    $valid_e_mail = is_valid_e_mail($e_mail);
    $valid_address = is_valid_address($address);
    
    //判定結果を返す
    return $valid_name && $valid_password && $valid_e_mail && $valid_address;
    
}

//ユーザー名が一致するレコードの取得(新規登録時に同じユーザー名がいないか確認のため)
function get_match_user_name($db,$user_name){
    
    //sql作成
    $sql = 'SELECT user_name
            FROM   ec_user
            WHERE  user_name = :user_name
            LIMIT 1';
            
    return fetch_query($db,$sql,array(':user_name' => $user_name));
}

//新規登録内容のインサート
function insert_user_data($db,$user_name,$password,$e_mail,$address,$datetime){
    
    //sql文作成
    $sql = 'INSERT INTO ec_user(user_name,password,e_mail,address,create_datetime)
                   VALUES(:user_name,:password,:e_mail,:address,:datetime)';
    
    return execute_query($db,$sql,array(':user_name' => $user_name,':password' => $password,':e_mail' => $e_mail,':address' => $address,':datetime' => $datetime));
    
}







?>