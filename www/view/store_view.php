<!DOCTYPE html>
<html lang="ja">
<head>
    <title>store.</title>
    <?php include VIEW_PATH . 'temps/head.php'?>
    <link rel="stylesheet" href="<?php print h_special(CSS_PATH . 'message.css');?>">
    <link rel="stylesheet" href="<?php print h_special(CSS_PATH . 'header.css');?>">
    <link rel="stylesheet" href="<?php print h_special(CSS_PATH . 'store_view.css');?>">
</head>
<body>
    <?php include VIEW_PATH . 'temps/messages.php';?>
    <?php include VIEW_PATH . 'temps/header.php';?>
        <container>
            <h2>store.</h2>
        <div class="center">
            <form method="post" action="login_process.php">
                <p>user name.<input class="text" type="text" name="user_name" value=""></p>
                <p>password.<input class="text" type="text" name="password" value=""></p>
                <input type="hidden" name="token" value="<?php print h_special($token);?>">
                <input class="button" type="submit" value="login">
            </form>
            <form class=signup>
                <a href="<?php print h_special(SIGNUP_PATH);?>">
                    <input type="button" value="sign up">
                </a>
            </form>
        </div>
        </container>
</body>
</html>