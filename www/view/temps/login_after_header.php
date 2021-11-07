<header>
    <p><?php print 'ようこそ' . h_special($login_user['user_name']) . 'さん';?></p>
    <div class="home">
        <a href="./top.php"><img src="<?php print h_special(IMAGE_PATH . 'band_logo_mono.png')?>" height="150" width="300"></a>
    </div>
    <div class="header_link">
        <a class="link" href="<?php print h_special(CART_PATH);?>"><div class="text">cart.</div></a>
        <a class="link" href="<?php print h_special(LOGOUT_PATH);?>"><div class="text">logout.</div></a>
        <a class="link" href="<?php print h_special(PURCHASE_PATH);?>">history.</a>
    </div>
</header>