<?php 
    include '../../_base.php';
    auth('admin');

    $_title = 'New Product';
    $status = ['Available' => 'Available', 'Offsale' => 'Offsale'];
    
    if (is_post()){
        $product_name = req('product_name');
        $price = req('price');
        $scale = req('scale');
        $series = req('series');
        $brand = req('brand');
        $stock_quantity = req('stock');
        $product_status = req('status');
        $description = req('description');
        $alt_text = req('alt_text');
        $f = get_file('photo');
        $image = $_SESSION['photo'];

        if (!$f) {
            $_err['photo'] = 'Required';    
        }
        else if (!str_starts_with($f->type, 'image/')) {
            $_err['photo'] = 'Must be image';                                                                                                                                           
        }
        else if ($f->size > 1 * 1024 * 1024) {
            $_err['photo'] = 'Maximum 1MB';
        }

        if ($price == ''){
            $_err['price'] = 'Required';
        }
        else if(!is_money($price)){
            $_err['price'] = 'Must be numeric';
        }
        else if($price < 0.01 || $price > 999999.99){
            $_err['price'] = 'Must be between 0.01 - 999999.99';                        
        }

        validate_text('product_name',$product_name,999);
        validate_text('scale',$scale,99);
        validate_text('series',$series,99);
        validate_text('brand',$brand,99);
        validate_text('description',$description,999);
        validate_text('alt_text',$alt_text, 99);

        if($stock_quantity == ''){
            $_err['stock'] = 'Required';
        }
        elseif(!ctype_digit($stock_quantity)){
            $_err['stock'] = 'Must be numeric.';
        }
        elseif($stock_quantity < 0 || $stock_quantity > 99999){
            $_err['stock'] = 'Must be between 0 - 99999';
        }

        if(!array_key_exists($product_status,$status)){
            $_err['status'] = 'Invalid status';
        }
        
        if(!$_err){
            
            $stm = $_db->prepare('INSERT INTO product (name, price, scale, description, stock_quantity, status, series, brand)
                            VALUES (?,?,?,?,?,?,?,?)');
            $stm->execute([$product_name,$price,$scale,$description, $stock_quantity, $product_status,$series,$brand]);
            $product_id = $_db->lastInsertId();

            $image = save_photo($f,"../../images/products","/images/products");
            $stm = $_db->prepare('INSERT INTO product_image (image_url, product_id, alt_text) VALUES (?,?,?)');
            $stm->execute([$image,$product_id,$alt_text]);
            
            temp('info', 'Product added!');
            redirect();
        }
    }
    
    include '../_head.php';
?>


<div class="insertProductContent">
    <!-- Display product info -->
    <div class="insertProductDetails">
        <form method = "post" enctype = "multipart/form-data">
            <h2><label for = 'product_name'>Name:</label><?php html_text('product_name','','placeholder = "Enter product name."') ?> <?= err('product_name') ?></h2>
            <p class="insertPrice"><label for = "price">Price: RM</label><?php html_number('price',sprintf('%.2f',''),0,999999.99,0.01) ?> <?= err('price') ?></p>
            <div class="insertSizeStatus">
                <p><strong><label for = "scale">Scale:</label></strong><?php html_text('scale', '') ?> <?= err('scale') ?></p>
                <p><strong><label for = "scale">Series:</label></strong><?php html_text('series', '') ?> <?= err('series') ?></p>
                <p><strong><label for = "scale">Brand:</label></strong><?php html_text('brand', '') ?> <?= err('brand') ?></p>
                <p><strong><label for = "stock">Stock:</label></strong><?php html_number('stock','',0,99999) ?> units left <?= err('stock') ?></p>
                <p><strong><label for = "status">Status:</label></strong> <?php html_select('status',$status)?> <?= err('status') ?></p>
            </div>
            <div class="insertDescriptionBox">
                <p><strong><label for = "description">Description:</label></strong></p>
                <p><?php html_textarea('description', '') ?> <?= err('description') ?></p>
            </div>
            <p><strong><label for = "alt_text">Image Alt Text:</label></strong><?php html_text('alt_text', '') ?><?= err('alt_text') ?></p>
            <label for="photo">Photo</label>
            <label class="upload" tabindex="0"><?= html_file('photo', 'image/*', 'hidden') ?><img src="<?= $image ?>"></label>
            <?= err('photo') ?>
            <button type="submit" class="insertBtn">Add Product</button>
        </form>
    </div>
 </div>

<?php 
    include '../../_foot.php';
?>