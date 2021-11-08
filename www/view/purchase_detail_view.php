<?php header("X-FRAME-OPTIONS: DENY");?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <title>detail.</title>
    <?php include VIEW_PATH . 'temps/head.php';?>
    <link rel="stylesheet" href="<?php print h_special(CSS_PATH . 'login_after_header.css');?>">
    <link rel="stylesheet" href="<?php print h_special(CSS_PATH . 'purchase_detail_view.css');?>">
</head>
<body>
    <?php include VIEW_PATH . 'temps/messages.php';?>
    <div class="center">
        <?php include VIEW_PATH . 'temps/login_after_header.php';?>
        <container>
            <h2>details.</h2>
                <?php foreach($details as $row){ ?>
                    <div class="product_list">
                        
                        <img class="product_image" src="<?php print h_special(IMAGE_PATH.$row['img_file_name']);?>">
                        
                        <div class="flex">
                            <p>.price:<?php print h_special($row['price'] . '×' . $row['quantity']);?></p>
                            <p>.</p>
                            <p>.</p>
                            <p>.</p>
                            <p>.</p>
                            <p>.</p>
                            <p>.sub total:<?php print h_special($row['price'] * $row['quantity']);?>-.</p>
                        </div>
                    </div>
                    <?php } ?>
                </ul>    
        </container>
    </div>
</body>
</html>