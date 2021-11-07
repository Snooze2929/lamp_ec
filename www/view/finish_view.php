<!DOCTYPE html>
<html lang="ja">
<head>
    <title>purchase.</title>
    <?php include VIEW_PATH . 'temps/head.php';?>
    <link rel="stylesheet" href="<?php print h_special(CSS_PATH . 'login_after_header.css');?>">
    <link rel="stylesheet" href="<?php print h_special(CSS_PATH . 'finish_view.css');?>">
</head>
<body>
    <?php include VIEW_PATH . 'temps/messages.php';?>
    <div class="center">
        <?php include VIEW_PATH . 'temps/login_after_header.php';?>
        <container>
                <h2>store.</h2>
                    <?php foreach($rows as $row){?>
                        <img src="<?php print h_special(IMAGE_PATH . $row['img_file_name']);?>">
                    <?php } ?>
                <div class="message">
                    <p>Thank you for purchase.</p>
                    <p>From all of the far. members.</p>
                </div>
                
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
                <h3>total.<?php print h_special($total);?>-</h3>
            </div>
        </container>
    </div>
</body>
</html>