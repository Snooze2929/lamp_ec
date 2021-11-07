<!DOCTYPE html>
<html lang="ja">
<head>
    <title>far.offical.</title>
    <?php include VIEW_PATH . 'temps/head.php';?>
    <link rel="stylesheet" href="<?php print(h_special(CSS_PATH.'header.css'));?>">
    <link rel="stylesheet" href="<?php print(h_special(CSS_PATH.'top_view.css'));?>">
</head>
<body>
    <?php include VIEW_PATH . 'temps/messages.php'; ?>
    
    <div class="center">
        <?php include VIEW_PATH . 'temps/header.php';?>
        <container>
            <p class="cd_name">「<?php print h_special($row['product_name']);?>」</p><!--後にdbから取得できるようにする。(lastinsertId?)-->
            <p class="text">now on sale.</p>
            <div class="jacket_space">
                <img class="jacket" src="<?php print h_special(IMAGE_PATH . $row['img_file_name']);?>">
            </div>
        </container>
    </div>
</html>
</body>