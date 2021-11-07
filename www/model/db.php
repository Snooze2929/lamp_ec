<?php

//データベース接続
function get_db_connect(){
    
    //データソースネーム
    $dsn = 'mysql:dbname='.DB_NAME.';host='.HOST.';charset='.DB_CHARSET;
    
    try{
        
        $dbh = new PDO($dsn,DB_USER,DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
        $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
        $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
        
    }catch(PDOException $e){
        exit('データベースに接続できませんでした。'.$e->getMessage());
    }
    
    //データベースハンドルを返す
    return $dbh;
}

//sqlの実行結果を1行だけ取得
function fetch_query($db,$sql,$params = array()){
    
    try{
        
        //sqlの実行準備
        $stmt = $db->prepare($sql);
        
        //sqlの実行
        $stmt->execute($params);
        
        //実行結果をfetchし,結果を返す
        return $stmt->fetch();
        
    }catch(PDOException $e){
        
        //例外の場合セッションにエラー文をセット
        set_error('データを取得できませんでした');
    }
    
    //tryできない場合
    return false;
    
}

//sqlの実行結果を全て取得する
function fetch_all_query($db,$sql,$params = array()){
    
    try{
        
        //sqlの実行準備
        $stmt = $db->prepare($sql);
        
        //sqlの実行
        $stmt->execute($params);
        
        //実行結果をfetchし、結果を返す
        return $stmt->fetchAll();
        
    }catch(PDOException $e){
        
        //例外の場合セッションにエラー文をセット
        set_error('データベースを取得できませんでした');
    }
    
    //tryできない場合
    return false;
    
}

//sqlの実行のみ
function execute_query($db,$sql,$params = array()){
    
    try{
        //sql実行準備
        $stmt = $db->prepare($sql);
        
        //sql実行
        return $stmt->execute($params);
        
    }catch(PDOException $e){
        
        //例外の場合セッションにエラー文をセット
        set_error('データベースを更新できませんでした' . $e->getMessage());
        
    }
    
    //tryできない場合
    return false;
    
}





?>