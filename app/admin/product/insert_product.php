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

   .products-details{
    flex: 1;
    min-width: 350px;
    max-height: 600px;          /* controls height of the panel */
    overflow-y: auto;           /* enables vertical scroll */
    background: #fff;
    padding: 25px;
    border-radius: 12px;
    border: 1px solid #ffe0e6;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    scrollbar-width: thin;
    position: sticky;
    top: 20px;
}
.products-details::-webkit-scrollbar{
    width: 6px;
}

.products-details::-webkit-scrollbar-track{
    background: #f3f3f3;
    border-radius: 10px;
}

.products-details::-webkit-scrollbar-thumb{
    background: #bbb;
    border-radius: 10px;
}

.products-details::-webkit-scrollbar-thumb:hover{
    background: #888;
}

/* ===== FORM LAYOUT ===== */
.products-details form{
    display: flex;
    flex-direction: column;
    gap: 18px;
}

/* EACH FIELD */
.products-details label{
    font-weight: bold;
    color: #444;
    display: block;
    margin-bottom: 5px;
}

/* INPUTS */
.products-details input,
.products-details select,
.products-details textarea{
    width: 90%;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #ddd;
    font-size: 14px;
    transition: 0.2s;
}

.products-details input:focus,
.products-details select:focus,
.products-details textarea:focus{
    border-color: #ff4f78;
    outline: none;
    box-shadow: 0 0 0 2px rgba(255,79,120,0.15);
}

/* TEXTAREA */
.products-details textarea{
    min-height: 100px;
    resize: vertical;
}

/* PRICE ROW */
.price{
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: bold;
    color: #ff4f78;
}

/* GROUP BOXES */
.sizeStatus{
    background: #ffcfdb;
    padding: 15px;
    border-radius: 10px;
    border: 1px solid #ffafbf;
    display: grid;
    gap: 12px;
}

.descriptionBox{
    
    gap: 8px;
}

/* ===== IMAGE UPLOAD ===== */
.upload{
    display: inline-block;
    border: 2px dashed #ffc1cc;
    padding: 15px;
    border-radius: 10px;
    cursor: pointer;
    text-align: center;
    transition: 0.2s;
}

.upload:hover{
    border-color: #ff4f78;
    background: #fff5f7;
}

.upload img{
    max-width: 100%;
    max-height: 160px;
    display: block;
    margin: 0 auto;
}

/* ===== BUTTON ===== */
.btn{
    background: linear-gradient(135deg, #ff7aa2, #ff3b61);
    color: white;
    border: none;
    padding: 12px;
    font-weight: bold;
    border-radius: 8px;
    cursor: pointer;
    transition: 0.25s;
    margin-top: 10px;
}

.btn:hover{
    transform: translateY(-2px);
    box-shadow: 0 5px 12px rgba(255,59,97,0.3);
}

/* ===== ERROR TEXT ===== */
small, .error{
    color: red;
    font-size: 12px;
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