<?php header("X-FRAME-OPTIONS: DENY");?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <title>cart.</title>
    <?php include VIEW_PATH . 'temps/head.php';?>
    <link rel="stylesheet" href="<?php print h_special(CSS_PATH . 'login_after_header.css');?>">
    <link rel="stylesheet" href="<?php print h_special(CSS_PATH . 'cart_view.css');?>">
</head>
<body>
    <?php include VIEW_PATH . 'temps/messages.php';?>
    <div class="center">
        <?php include VIEW_PATH . 'temps/login_after_header.php';?>
    <container>
        <h2>cart.</h2>
        
        <?php
        //ユーザーごとのカートテーブルを出力
        if($total === 0){
            print 'There is nothing in the cart.';
        }else{
            foreach($rows as $row){ ?>
                      
            <div class="product_list">
                <img class="product_image" src="<?php print h_special(IMAGE_PATH . $row['img_file_name'])?>">
                
                <div class="flex">
                    <p>.<?php print h_special($row['product_name'])?></p>
                    <p>.</p>
                    <p>.</p>
                    <p>.<?php print h_special($row['price']);?> tax in</p>
                    <p>.</p>
                    <p>.</p>
                    <p>
                        <form method="post" action="update_cart.php">
                            .×<input type="number" name="quantity" value="<?php print h_special($row['quantity']);?>">
                            <input type="hidden" name="user_id" value="<?php print h_special($row['user_id']);?>">
                            <input type="hidden" name="product_id" value="<?php print h_special($row['product_id']);?>">
                            <input type="hidden" name="token" value="<?php print h_special($token);?>">
                            <input type="submit" value="change">
                        </form>
                    </p>
                    <p>
                        <form method="post" action="delete_cart.php">
                            .<span class="cancel"><input type="hidden" name="user_id" value="<?php print h_special($row['user_id'])?>"></span>
                            <input type="hidden" name="product_id" value="<?php print h_special($row['product_id']);?>">
                            <input type="hidden" name="token" value="<?php print h_special($token)?>">
                            <input type="submit" value="cancel">
                        </form>
                    </p>
                </div>
            </div>
        <?php } ?>
        <?php } ?>
    </container>
    <?php 
        if(isset($rows)){
           foreach($rows as $row){
    ?>
              
        <div class="register">
            <h3>
                <?php print h_special($row['product_name']);?>.
                <?php print h_special($row['price']);?>×
                <?php print h_special($row['quantity']);?>
            </h3>
        </div>
        
    <?php 
           }
        }
    ?>
              
        <div class="total">
            <h3>total.<?php if(isset($total)){print h_special($total);}?>-</h3>
        </div>
        <div class="button">
        <?php if(isset($rows)){ ?>
                <a href="<?php print h_special(FINISH_PATH);?>">   
                <button class="purchase" type="button">purchase</button>
            </a>
        <?php } ?>
            <a href="<?php print h_special(PRODUCT_PATH);?>">   
                <button type="button">continue to shopping</button>
            </a>
        </div>
    </div>
</body>
</html>