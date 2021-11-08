<?php header("X-FRAME-OPTIONS: DENY");?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <title>history.</title>
    <?php include VIEW_PATH . 'temps/head.php';?>
    <link rel="stylesheet" href="<?php print h_special(CSS_PATH . 'login_after_header.css');?>">
    <link rel="stylesheet" href="<?php print h_special(CSS_PATH . 'purchase_history_view.css');?>">
</head>
<body>
    <?php include VIEW_PATH . 'temps/messages.php';?>
    <div class="center">
        <?php include VIEW_PATH . 'temps/login_after_header.php';?>
        <container>
            <h2>history.</h2>
            <?php if(empty($histories)){ ?>
                <p class ="no_purchase">No purchase history.</p>
            <?php }else{ ?>
                <ul>
                    <?php foreach($histories as $row){ ?>
                    <li class="list">
                        <p>order number <?php print h_special($row['order_id']);?></p>
                        <p class="title">datetime<span class="space"><?php print h_special($row['datetime']);?></span></p>
                        <p class="title">total price<span class="space_price"><?php print h_special($row['total']);?>-.</span></p>
                        <form method="post" action="purchase_detail.php">
                            <input type="hidden" name="order_id" value="<?php print h_special($row['order_id']);?>">
                            <input type="hidden" name="token" value="<?php print h_special($token);?>">
                            <input type="submit" class="detail_button" value="detail">
                        </form>
                    </li>
                    <?php } ?>
            <?php } ?>
                </ul>    
        </container>
    </div>
</body>
</html>