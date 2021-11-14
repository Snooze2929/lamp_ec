<?php header("X-FRAME-OPTIONS: DENY");?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <title>store.</title>
    <?php include VIEW_PATH . 'temps/head.php';?>
    <link rel="stylesheet" href="<?php print h_special(CSS_PATH . 'login_after_header.css')?>">
    <link rel="stylesheet" href="<?php print h_special(CSS_PATH . 'product_view.css')?>">
</head>
<body>
    <?php include VIEW_PATH . 'temps/messages.php';?>
    <div class="center">
        <?php include VIEW_PATH . 'temps/login_after_header.php';?>
    <container>
        <h2>store.</h2>
        <form method="get" class="sort">
            <select name="sort">
                <option value= ''>select</option>
                <option value="new" <?php if($sort === 'new'){print h_special('selected');}?>>new</option>
                <option value="cheep" <?php if($sort === 'cheep'){print h_special('selected');}?>>cheep</option>
                <option value="expensive" <?php if($sort === 'expensive'){print h_special('selected');}?>>expensive</option>
            </select>
            <input type="submit" value="change">
        </form>
            <?php foreach($rows as $row){?>
            <div class="product_list">
                <img class="product_image" src="<?php print h_special(IMAGE_PATH.$row['img_file_name']);?>">
                
                <div class="flex">
                    <p>.<?php print h_special($row['product_name']);?></p>
                    <p>.</p>
                    <p>.</p>
                    <p>.</p>
                    <p>.</p>
                    <p>.</p>
                    <p>.<?php if($row['stock'] > 0){
                                  print h_special($row['price'] . 'tax in.');
                              }else{
                                  print h_special('sold out.');}?></p>
                </div>
            </div>
            <?php if($row['stock'] > 0) {?>
            <form method="post" action="add_cart.php">
                <div class="button">
                    <input type="hidden" name="product_id" value="<?php print h_special($row['product_id']);?>">
                    <input type="hidden" name="token" value="<?php print h_special($token);?>">
                    <!--hidden $row stock-->
                    <input type="submit" value="add to cart">
                </div>
            </form>
            <?php } ?>
            <!--foreachにして登録かつ公開状態の商品を全て表示する-->
            <?php } ?>
    </container>
    </div>
</body>
</html>