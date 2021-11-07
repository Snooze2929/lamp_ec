<!DOCTYPE html>
<html lang="ja">
<head>
    <title>contact.</title>
    <?php include VIEW_PATH . 'temps/head.php';?>
    <link rel="stylesheet" href="<?php print h_special(CSS_PATH . 'header.css');?>">
    <link rel="stylesheet" href="<?php print h_special(CSS_PATH . 'contact_view.css');?>">
</head>
<body>
    <div class="center">
        <?php include VIEW_PATH . 'temps/header.php';?>
        <container>
            <h2>contact.</h2>
            <form action="http://www2.tba.t-com.ne.jp/cgi-bin/form.cgi" method="post">
            <div class="flex">
                <p>Name.<input type="text" name="user_name" value=""></p>
                <p>E-mail.<input type="text" name="email" value=""></p>
            </div>
                <p class="message">Message.<textarea rows="20" cols="81" wrap="soft" ></textarea></p>
                <input type="hidden" name="tomail" value="farthee722@gmail.com">
            <div class="submit">
                <input type="submit" value="send">
            </div>
            </form>
        </container>
    </div>
</body>
</html>