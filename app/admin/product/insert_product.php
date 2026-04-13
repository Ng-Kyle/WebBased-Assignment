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

<style>
    .productContent{
        display: flex;
        gap: 40px;
        padding: 40px;
        align-items: flex-start;
        max-width: 1200px;
        margin: 0 auto;
    }
    .productImgContainer{
        display: flex;
        flex-direction: column;
        gap: 15px;
        width: 45%;
    }
    .thumbnailBar{
        width: 100%;
        overflow-x: auto;
        padding-bottom: 10px;
        white-space: nowrap;
    }
    .thumbnailInner{
        display: flex;
        flex-direction: row;
        gap:10px;
        width:max-content;
    }
    .thumbIMG{
        width: 100px;
        height: 70px;
        flex-shrink: 0;
        object-fit: contain;
        border: 2px solid #FFA1AF;
        border-radius: 4px;
        cursor:pointer;
        transition: 0.2;
    }
    .thumbIMG:active{
        border-color: #FF5E7E;
    }
    .thumbnailBar::-webkit-scrollbar{
        height:8px;
    }
    .thumbnailBar::-webkit-scrollbar-track{
        background: #f1f1f1;
        border-radius: 10px;
    }
    .thumbnailBar::-webkit-scrollbar-thumb{
        background: #555;
        border-radius: 10px;
    }
    .thumbnailBar::-webkit-scrollbar-thumb:hover{
        background: #333;
    }
    .imgView{
        flex: 1;
        height: 450px;
        border: 1px solid #FFA1AF;
        border-radius: 8px;
        background-color: #fff;
        display: flex;
        justify-content: center;
        overflow: hidden;
    }
    #displayIMG{
        max-width: 100%;
        height: 100%;
        object-fit: contain;
    }
    .products-details{
        flex: 1;
    }
    .products-details h2{
        color: #FF5E7E;
        margin-top: 0;
        font-size: 2.2em;
    }
    .price{
        font-size: 1.8em;
        font-weight: bold;
        color: #FF5E7E;
        margin:20px 0;
    }
    .sizeStatus, .descriptionBox{
        margin-bottom:25px;
        line-height: 1.6;
    }
    .addCartButton{
        margin-top: 30px;
        display: flex;
        flex-direction: column;
        gap:15px;
    }
    .quantityInput{
        display: flex;
        align-items: center;
        gap:10px;
    }
    .quantityInput input{
        width: 60px;
        border:1px solid #FFA1AF;
        border-radius: 4px;
    }
    .btn{
        background-color:pink;
        color:black;
        border: 2px;
        font-size:1.1em;
        font-weight:bold;
        cursor: pointer;
        transition: 0.2;
        width: fit-content;
    }
    .btn:hover{
        background-color: #ff3b61;
    }

</style>

<div class="productContent">
    <!-- Display product info -->
    <div class="products-details">
        <form method = "post" enctype = "multipart/form-data">
            <h2><label for = 'product_name'>Name:</label><?php html_text('product_name','','placeholder = "Enter product name."') ?> <?= err('product_name') ?></h2>

            <p class="price"><label for = "price">Price: RM</label><?php html_number('price',sprintf('%.2f',''),0,999999.99,0.01) ?> <?= err('price') ?></p>
            <div class="sizeStatus">
                <p><strong><label for = "scale">Scale:</label></strong><?php html_text('scale', '') ?> <?= err('scale') ?></p>
                <p><strong><label for = "scale">Series:</label></strong><?php html_text('series', '') ?> <?= err('series') ?></p>
                <p><strong><label for = "scale">Brand:</label></strong><?php html_text('brand', '') ?> <?= err('brand') ?></p>
                <p><strong><label for = "stock">Stock:</label></strong><?php html_number('stock','',0,99999) ?> units left <?= err('stock') ?></p>
                <p><strong><label for = "status">Status:</label></strong> <?php html_select('status',$status)?> <?= err('status') ?></p>
            </div>
            <div class="descriptionBox">
                <p><strong><label for = "description">Description:</label></strong></p>
                <p><?php html_textarea('description', '') ?> <?= err('description') ?></p>
            </div>
            <p><strong><label for = "alt_text">Image Alt Text:</label></strong><?php html_text('alt_text', '') ?><?= err('alt_text') ?></p>
            <label for="photo">Photo</label>
            <label class="upload" tabindex="0">
                <?= html_file('photo', 'image/*', 'hidden') ?>
                <img src="<?= $image ?>">
            </label>
            <?= err('photo') ?>
            <button type="submit" class="btn">Add Product</button>
        </form>
    </div>
 </div>

    


<?php 
    include '../../_foot.php';
?>