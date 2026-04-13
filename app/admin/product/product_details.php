<?php 
    include '../../_base.php';
    auth('admin');

    $id = req('product_id');
    $stm = $_db->prepare('SELECT p.*, pi.* FROM product p LEFT JOIN product_image pi ON p.product_id = pi.product_id WHERE p.product_id = ?');
    $stm->execute([$id]);
    $productIDimg = $stm->fetchAll();
 
    if (!$productIDimg){
        echo "Product not found";
        exit;
    }
    $products= [
            
        'product_id'     => $productIDimg[0]->product_id,
        'name'           => $productIDimg[0]->name,
        'description'    => $productIDimg[0]->description,
        'price'          => $productIDimg[0]->price,
        'stock_quantity' => $productIDimg[0]->stock_quantity,
        'status'         => $productIDimg[0]->status,
        'scale'          => $productIDimg[0]->scale,
        'series'         => $productIDimg[0]->series,
        'brand'          => $productIDimg[0]->brand,
        'images'         => []

    ];
    foreach ($productIDimg as $p){
        if ($p->image_url ?? false){ //?? end means if there's no or image_URL, it will turn it to false
            $products['images'][] = $p->image_url; //the extra [] is for append.
        }
    }

    $status = ['Available' => 'Available', 'Offsale' => 'Offsale'];

    if (is_post()){
        $product_id = post('product_id');
        $product_name = req('product_name');
        $price = req('price');
        $scale = req('scale');
        $series = req('series');
        $brand = req('brand');
        $stock_quantity = req('stock');
        $product_status = req('status');
        $description = req('description');
        $f = get_file('photo');
        $image = $_SESSION['photo'];

        if ($f) {
            if (!str_starts_with($f->type, 'image/')) {
                $_err['photo'] = 'Must be image';                                                                                                                                           
            }
            else if ($f->size > 1 * 1024 * 1024) {
                $_err['photo'] = 'Maximum 1MB';
            }
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

        validate_text('product_name',$product_name,999);
        validate_text('scale',$scale,99);
        validate_text('series',$series,99);
        validate_text('brand',$brand,99);
        validate_text('description',$description,999);

        if(!$_err){
            if($f){
                unlink("../../images/products/".$products['images'][0]);
                $image = save_photo($f,"../../images/products","/images/products");
                $stm = $_db->prepare('UPDATE product_image SET image_url = ? WHERE product_id = ? ORDER BY product_image_id ASC LIMIT 1');
                $stm->execute([$image,$product_id]);
            }

            $stm = $_db->prepare('UPDATE product SET name = ?, price = ?, scale = ?, stock_quantity = ?, status = ?, description = ?, series = ?, brand = ? WHERE product_id = ?');
            $stm->execute([$product_name,$price,$scale,$stock_quantity, $product_status,$description,$series, $brand, $product_id]);
            
            if($product_status == 'Offsale'){
                $stm = $_db->prepare('DELETE FROM cart_product WHERE product_id = ?');
                $stm->execute([$product_id]);
            }

            temp('info', 'Product updated!');
            redirect();
        }
    }

    $_title = $products['name'];
    include '../_head.php';
?>

<div class="updateProductContent">
    <!-- Display product images -->
    <div class="updateProductImgContainer">
        <div class="updateImgView">
            <img id="displayIMG" class = "updateDisplayIMG" src="<?= encode($products['images'][0]) ?>" alt="<?= encode($products['name']) ?> main view">
        </div>
        <?php if(count($products['images']) > 1): ?>
            <div class="updateThumbnailBar">
                <div class="updateThumbnailInner">
                    <?php foreach ($products['images'] as $img): ?>
                        <img class="updateThumbIMG" src="<?= encode($img) ?>" onclick="swapImage('<?= encode($img) ?>', this)" alt="Thumbnail">
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Display product info -->
    <div class="updateProductsDetails">
        <form method = "post" enctype = "multipart/form-data">
            <h2><label for = 'product_name'>Name:</label><?php html_text('product_name',encode($products['name'])) ?> <?= err('product_name') ?></h2>
            <div class="updateSizeStatus">   
                <p class="updatePrice"><label for = "price">Price: RM</label><?php html_number('price',sprintf('%.2f',$products['price']),0,999999.99,0.01) ?> <?= err('price') ?></p>
                <p><strong><label for = "scale">Scale:</label></strong><?php html_text('scale', encode($products['scale'])) ?> <?= err('scale') ?></p>
                <p><strong><label for = "scale">Series:</label></strong><?php html_text('series', encode($products['series'])) ?> <?= err('series') ?></p>
                <p><strong><label for = "scale">Brand:</label></strong><?php html_text('brand', encode($products['brand'])) ?> <?= err('brand') ?></p>
                <p><strong><label for = "stock">Stock:</label></strong><?php html_number('stock',encode($products['stock_quantity']),0,99999) ?> units left <?= err('stock') ?></p>
                <p><strong><label for = "status">Status:</label></strong> <?php html_select('status',$status,encode($products['status']))?> <?= err('status') ?></p>
            </div>
            <div class="updateDescriptionBox">
                <p><strong><label for = "description">Description:</label></strong></p>
                <p><?php html_textarea('description', $products['description']) ?> <?= err('description') ?></p>
            </div>
        <label for="photo">Photo</label>
        <label class="upload" tabindex="0"><?= html_file('photo', 'image/*', 'hidden') ?><img src="<?= $image ?>"></label>
        <?= err('photo') ?>
        <?php html_hidden('product_id', $products['product_id']) ?>
        <button type="submit" class="updateBtn">Update Product</button>  
    </div>
</div>

<script>
    function swapImage(imgSrc, thumbElement){
      //change the focused image
      document.getElementById('displayIMG').src = imgSrc;
      //reset the thumbnails to it's default border
      document.querySelectorAll('.thumbIMG').forEach(t => {
        t.classList.remove('active');
      });
      //highlight the clicked thumbnail
      thumbElement.classList.add('active');
    }
</script>

<?php 
    include '../../_foot.php';
?>