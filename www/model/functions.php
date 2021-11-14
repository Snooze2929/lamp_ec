<?php

//var_dump実行
function dd($var){
    var_dump($var);
    exit;
}

//リダイレクト処理
function redirect($path){
    header('Location:'.$path);
    exit;
}

//特殊文字をhtmlエンティティに変換
function h_special($str){
    return htmlspecialchars($str,ENT_QUOTES,'UTF-8');
}


//csrf対策


//ランダムな文字列の生成
function get_random_string($length = 20){
  return substr(base_convert(hash('sha256', uniqid()), 16, 36), 0, $length);
}


//トークンの生成
function get_token(){
    
  //生成した文字列を$tokenに代入
  $token = get_random_string(30);
  
  //$tokenをセッションにセット
  set_session('csrf_token', $token);
  
  //$tokenを結果として返す
  return $token;
}


//トークン有無のチェック
function check_token($token){
    
    //$tokenの中身がからの場合、falseを返す
    if($token === ''){
        
        return false;
        
    }
    
    //$tokenの値とセッションの'csrf_token'の値が一致しているかどうかをboolで返す
    return $token === get_session('csrf_token');
}


//セッション関連


//セッション取得処理
function get_session($name){
    
    //セッション変数がセットされているか確認
    if(isset($_SESSION[$name]) === true){
        
        //セットされていた場合そのセッション変数を返す
        return $_SESSION[$name];
        
    }
    
    //なかった場合
    return '';
}

//セッションセット処理
function set_session($name,$value){
    $_SESSION[$name] = $value;
}

//セッション'errors'にエラー文をセット
function set_error($error){
  $_SESSION['errors'][] = $error;
}

//セッション'errors'を取得
function get_errors(){
    
    //セッションにセットされたエラー文を$errorsに代入
    $errors = get_session('errors');
    
    //$errorsが空だった場合空の配列を返す
    if($errors === ''){
        return array();
    }
    
    //'errors'を空にしておく
    set_session('errors',array());
    
    //取得結果を返す
    return $errors;
}

//セッション'messages'にユーザー向けメッセージをセット
function set_message($message_str){
    
    $_SESSION['messages'][] = $message_str;
    
}

//セッション'messages'を取得
function get_messages(){
    
    $messages = get_session('messages');
    
    //セッションに保存されたユーザー向けメッセージが空の場合,空の配列を返す
    if($messages === ''){
        
        return array();
        
    }
    
    //'messages'を空にしておく
    set_session('messages',array());
    
    //取得結果を返す
    return $messages;
    
}


//ログイン関連


//ユーザーがログインしているかどうか
function is_logined(){
    
    return get_session('user_id') !== '';
    
}

//ログインしているユーザータイプの取得
function this_user_type(){
    
    return get_session('user_type');
    
}


//入力チェック関連


//post受け取り
function get_post($name){
    
    //値のセット確認
    if(isset($_POST[$name]) === true){
        
        return $_POST[$name];
        
    }
    
    //値がセットされていない場合
    return false;
    
}

//getの値受け取り
function get_get($name){
    
    //値のセット確認
    if(isset($_GET[$name]) === true){

        return $_GET[$name];

    }

    //値がセットされていない場合
    return '';
}

//filesの取得
function get_files($name){
    
    //値セットの確認
    if(isset($_FILES[$name]) === true){
        
        return $_FILES[$name];
        
    }
    
    //値がセットされていない場合
    return false;
    
}

//スペース削除
function space_delete($str){
    
    return preg_replace('/\A[　\s]*|[　\s]*\z/u', '', $str);
    
}

//postで受け取った文字列をint型にする
function to_quantify($int){
    
    return intval($int);
    
}


//ファイルアップロード関連


//ファイルのアップロード
function get_upload_filename($new_file){
    
    //アップロードされた商品画像の拡張子の確認
    if(is_valid_upload_image($new_file) === false){
        return '';
    }
    
    //画像かどうかを判別しmimetypeに代入
    $mimetype = exif_imagetype($new_file['tmp_name']);
    
    //指定された拡張子を代入
    $extension = PERMITTED_IMAGE_TYPES[$mimetype];
    
    //ユニークなファイル名の生成
    return get_random_string() . '.' . $extension;
    
}

//ファイルアップロード可否と拡張子の確認
function is_valid_upload_image($new_file){
    
    //ファイルがHTTP POST でアップロードされていない場合
    if(is_uploaded_file($new_file['tmp_name']) === false){
        
        set_error('ファイル形式が不正です');
        return false;
        
    }
    
    //アップロードされた画像の拡張子の確認
    $mimetype = exif_imagetype($new_file['tmp_name']);
    
    if(PERMITTED_IMAGE_TYPES[$mimetype] === false){
  
        set_error('ファイル形式は' . implode('、', PERMITTED_IMAGE_TYPES) . 'のみをご利用ください。');
        return false;
        
    }
    
    return true;
    
}

//商品の画像を指定のフォルダに移動し保存する
function save_image($new_file,$filename){
    
    return move_uploaded_file($new_file['tmp_name'],IMG_DIR . $filename);
    
}






?>