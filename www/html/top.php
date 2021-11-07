<?php

//設定ファイル読み込み
require_once '../conf/const.php';

//functionsファイル読み込み
require_once MODEL_PATH . 'functions.php';

//product読み込み
require_once MODEL_PATH . 'product.php';

//データベース接続
$db = get_db_connect();

//最新商品の登録時間を取得
$max_datetime = get_new_datetime($db);

//最新商品のレコードを取得
$row = get_new_item($db,$max_datetime['MAX(create_datetime)']);

//top_view.php表示
include_once VIEW_PATH . 'top_view.php';

?>