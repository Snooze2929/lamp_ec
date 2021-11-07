<?php


//データベース関連


//ホスト名
define('HOST','mysql');

//データベース名
define('DB_NAME','farofficial');

//データベースユーザー名
define('DB_USER','faradmin');

//データベースパスワード
define('DB_PASS','far1230');

//データベース文字コード
define('DB_CHARSET','utf8');


//フォルダパス関連


//modelファイルパス
define('MODEL_PATH',$_SERVER['DOCUMENT_ROOT'] . '/../model/');

//viewファイルパス
define('VIEW_PATH',$_SERVER['DOCUMENT_ROOT'] . '/../view/');

//imageファイルパス
define('IMAGE_PATH','/assets/images/');

//cssファイルパス
define('CSS_PATH','/assets/css/');

//imageディレクトリパス
define('IMG_DIR',$_SERVER['DOCUMENT_ROOT'] . '/assets/images/');


//ファイルパス関連

//liveページ
define('LIVE_PATH','/live.php');

//descographyページ
define('DISCO_PATH','/disco.php');

//biographyページ
define('BIO_PATH','/biography.php');

//storeページ(ログインページ)
define('STORE_PATH','/store.php');

//contactページ
define('CONTACT_PATH','/contact.php');

//新規登録ページ
define('SIGNUP_PATH','/signup.php');

//商品一覧ページ
define('PRODUCT_PATH','/product.php');

//ログアウトページ
define('LOGOUT_PATH','/logout.php');

//トップページ
define('TOP_PATH','/top.php');

//カートページ
define('CART_PATH','/cart.php');

//購入履歴ページ
define('PURCHASE_PATH','/purchase_history.php');

//購入後ページ
define('FINISH_PATH','/finish.php');

//管理者ページ
define('ADMIN_PATH','/admin.php');


//入力チェック関連


//全て英数字かどうか
define('REGEXP_ALPHANUMERIC', '/\A[0-9a-zA-Z]+\z/');

//自然数かどうか
define('REGEXP_POSITIVE_INTEGER', '/\A([1-9][0-9]*|0)\z/');

//自然数かどうか(0含む)
define('REGEXP_INTEGER','/^0$|^-?[1-9][0-9]*$/');

//半角数字かどうか
define('REGEXP_HALFWIDTH_NUMBER','/^[0-9]+$/');

//値が0123のどれかかどうか(商品区分チェックで使う)
define('REGEXP_GENRE_NUMBER','/\A[0123]\z/');

//値が01のどちらかかどうか(公開ステータスチェックに使う)
define('REGEXP_STATUS_NUMBER','/\A[01]\z/');

//ユーザーネーム文字数の最少
define('USER_NAME_MIN',6);

//ユーザーネームの文字数の最大
define('USER_NAME_MAX',30);

//パスワード文字数の最少
define('PASSWORD_MIN',6);

//パスワード文字数の最大
define('PASSWORD_MAX',30);

//商品名文字数最少
define('PRODUCT_NAME_MIN',1);

//商品名文字数最大
define('PRODUCT_NAME_MAX',30);

//商品ステータス(公開)
define('STATUS_OPEN',1);

//商品ステータス(非公開)
define('STATUS_CLOSE',0);


//ユーザーの判別


//通常のユーザー
define('USER_TYPE_NORMAL',1);

//管理者
define('USER_TYPE_ADMIN',0);

/**？
define('PERMITTED_ITEM_STATUSES', array(
  'open' => 1,
  'close' => 0,
));



//拡張子の指定
define('PERMITTED_IMAGE_TYPES', array(
  IMAGETYPE_JPEG => 'jpg',
  IMAGETYPE_PNG => 'png',
));

**/

const PERMITTED_IMAGE_TYPES = array('jpg','jpeg','png');


?>