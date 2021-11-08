<?php header("X-FRAME-OPTIONS: DENY");?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <title>signup.</title>
    <?php include VIEW_PATH . 'temps/head.php';?>
    <link rel="stylesheet" href="<?php print h_special(CSS_PATH . 'message.css');?>">
    <link rel="stylesheet" href="<?php print h_special(CSS_PATH . 'header.css');?>">
    <link rel="stylesheet" href="<?php print h_special(CSS_PATH . 'signup_view.css');?>">
</head>
<body>
    <?php include VIEW_PATH . 'temps/messages.php';?>
    <?php include VIEW_PATH . 'temps/header.php';?>
    <container>
        <h2>signup.</h2>
        <div class="center">
            <form method="post" action="signup_process.php">
                <p>user name.<input class="text" type="text" name="user_name" value=""></p>
                <p>password.<input class="text" type="text" name="password" value=""></p>
                <p>e-mail.<input class="text" type="text" name="e_mail" value=""></p>
                <p>address.<input class="text" type="text" name="address" value=""></p>
                <input type="hidden" name="token" value="<?php print h_special($token);?>">
                <div class="send">
                    <input type="submit" value="send">
                </div>
            </form>
            <input type="button" onclick="location.href='<?php print h_special(STORE_PATH)?>'" value="back to login page">
        </div>
    </container>
</body>
</html>