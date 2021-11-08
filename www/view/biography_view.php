<?php header("X-FRAME-OPTIONS: DENY");?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <title>biography.</title>
    <?php include VIEW_PATH . 'temps/head.php';?>
    <link rel="stylesheet" href="<?php print h_special(CSS_PATH . 'header.css');?>">
    <link rel="stylesheet" href="<?php print h_special(CSS_PATH . 'biography_view.css');?>">
</head>
<body>
    <?php include VIEW_PATH . 'temps/messages.php';?>
    <div class="center">
        <?php include VIEW_PATH . 'temps/header.php';?>
        <container>
            <h2>biography.</h2>
            <div class="centerB">
                <div class="flex">
                    <img src="<?php print IMAGE_PATH . 'ah_photo.jpeg'?>">
                    <div class="text">
                        <p>vo.gt Iwagami Hayate</p>
                        <p>gt Sawado Koh</p>
                        <p>ba Kimura Makoto</p>
                        <p>dr Tamayama Kazuki</p>
                    </div>
                </div>
            <div class="link">
                <a href="https://twitter.com/far12_30">Twitter.</a>
                <a href="https://www.instagram.com/far_official_band/?hl=ja">instagram.</a>
            </div>
            </div>
        </container>
    </div>
</body>
</html>