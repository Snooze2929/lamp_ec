<?php header("X-FRAME-OPTIONS: DENY");?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <title>products.</title>
    <?php include VIEW_PATH . 'temps/head.php';?>
    <link rel="stylesheet" href="<?php print(h_special(CSS_PATH . 'login_after_header.css'));?>">
    <link rel="stylesheet" href="<?php print(h_special(CSS_PATH . 'admin_view.css'));?>">
</head>
<body>
    <?php include VIEW_PATH . 'temps/messages.php';?>
    <div class="center">
    <?php include VIEW_PATH . 'temps/login_after_header.php';?>
    <container>
        <h2>products.</h2>
        
            <!--商品追加部分 -->
        <div class="add_all">
            <form method="post" enctype="multipart/form-data" action="admin_add_product.php">
                <p><span class="product_name_space">product name.</span><input type="text" name="product_name" value=""></p>
                <p><span class="price_space">price.</span><input type="number" name="price" value=""></p>
                <p><span class="image_space">image.</span><input type="file" name="new_file" value="select file"></p>
                <p><span class="stock_space">stock.</span><input type="text" name="stock" value=""></p>
                <p><span class="genre_space">genre.</span>
                    <select name="genre">
                        <option value="0">disital</option>
                        <option value="1">physical</option>
                        <option value="2">apparel</option>
                        <option value="3">general goods</option>
                    </select>
                </p>
                <p><span class="status_space">status.</span>
                    <select name="status">
                        <option value="1">open</option>
                        <option value="0">close</option>
                    </select>
                </p>
                <input type="hidden" name="process_kind" value="new_product">
                <input type="hidden" name="token" value="<?php print h_special($token);?>">
            <div class="add_product">
                <input type="submit" value="add product">
            </div>
            </form>
        </div>
            <!-- ここまで商品追加部分-->
            
            <!--ここから商品一覧部分-->
            
            <?php foreach($rows as $row){ ?>
                <div class="product_list">
                    <img class="product_image" src="<?php print h_special(IMAGE_PATH . $row['img_file_name']);?>">
                    <div class="flex">
                        <p class="product_name">.<?php print h_special($row['product_name']);?></p>
                        <p>.<?php if($row['genre'] === 0){
                                  print 'digital';
                              }else if($row['genre'] === 1){
                                  print 'physical';
                              }else if($row['genre'] === 2){
                                  print 'apparel';
                              }else if($row['genre'] === 3){
                                  print 'general goods';
                            }?>
                        <p>
                        <p class="price">.<?php print h_special($row['price']) . 'tax in';?></p>
                        <form method="post" class="text_flex" action="admin_update_stock.php">.<input type="number" name="new_stock" value="<?php print h_special($row['stock']);?>">
                                  <input type="hidden" name="process_kind" value="update_stock">
                                  <input type="hidden" name="product_id" value="<?php print h_special($row['product_id']);?>">
                                  <input type="hidden" name="token" value="<?php print h_special($token);?>">
                                  <input type="submit" value="change stock">
                        </form>
                        
                        <form method="post" class="text_flex" action="admin_update_status.php">
                                <?php if($row['status'] === 1){?>
                                    .<input type="submit" value="open→close">
                                    <input type="hidden" name="process_kind" value="change">
                                    <input type="hidden" name="product_id" value="<?php print h_special($row['product_id']);?>">
                                    <input type="hidden" name="new_status" value="0">
                                    <input type="hidden" name="token" value="<?php print h_special($token);?>">
                                <?php }else{ ?>
                                    .<input type="submit" value="close→open">
                                    <input type="hidden" name="process_kind" value="change">
                                    <input type="hidden" name="product_id" value="<?php print h_special($row['product_id']);?>">
                                    <input type="hidden" name="new_status" value="1">
                                    <input type="hidden" name="token" value="<?php print h_special($token);?>">
                                <?php } ?>
                        </form>
                        <form method="post" class="text_flex" action="admin_delete_product.php">
                                .<input type="submit" value="delete">
                                <input type="hidden" name="process_kind" value="delete">
                                <input type="hidden" name="product_id" value="<?php print h_special($row['product_id']);?>">
                                <input type="hidden" name="token" value="<?php print h_special($token);?>">
                        </form>
                    </div>
                </div>
            <?php }?>
    </container>
    </div>
</body>
</html>