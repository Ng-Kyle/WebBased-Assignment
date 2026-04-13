<?php 
    include '../_base.php';


    if (is_post()){
        if (!$_user){
            temp('info', 'Please login to add an item into your cart!');
            redirect('../login/login.php');
        }

        $product_id = post('product_id');
        $quantity = (int)post('quantity');
        
        $stm = $_db->prepare('SELECT stock_quantity FROM product WHERE product_id = ?');
        $stm->execute([$product_id]);
        $real_stock = $stm->fetchColumn();

        $stm = $_db->prepare('SELECT status FROM product WHERE product_id = ?');
        $stm->execute([$product_id]);
        $status = $stm->fetchColumn();

        if($status != 'Available'){
            temp('info', 'This item is no longer on sale!');
            redirect();
        }
        if ($quantity<0 && $quantity>= $real_stock){
            temp('info', 'Invalid Quantity 😡!!');
            redirect();
        }
        
        $cart_id = get_cart();
        //this is for checking if the product exists in the member's cart
        $stm = $_db->prepare('SELECT * FROM cart_product WHERE product_id = ? AND cart_id = ? ');
        $stm->execute([$product_id,$cart_id]);
        $exists = $stm->fetch();

        if($exists->quantity + $quantity > $real_stock){
            temp('info', 'Your cart is full 😡!!');
            redirect();
        }
        if($exists){
            //update existing product
            $stm = $_db->prepare('UPDATE cart_product SET quantity = quantity + ? WHERE product_id = ? AND cart_id = ?');
            $stm->execute([$quantity,$product_id,$cart_id]);
            temp('info', 'Added to Cart!! 🛒');
            redirect('../cart/cart.php');    
        }else{
            //insert new product
            $stm = $_db->prepare('INSERT INTO cart_product (product_id, cart_id, quantity) VALUES (?,?,?)');
            $stm->execute([$product_id,$cart_id,$quantity]);
            temp('info', 'Added to Cart!! 🛒');
            redirect('../cart/cart.php');
        }
            
    }

    $id = req('product_id');
    $stm = $_db->prepare('SELECT p.*, pi.* FROM product p LEFT JOIN product_image pi ON p.product_id = pi.product_id WHERE p.product_id = ?');
    $stm->execute([$id]);
    $productIDimg = $stm->fetchAll();
    //Debug
    //var_dump($id);
     //print_r($productIDimg);
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
    $_title = $products['name'];
    include '../_head.php';
?>

<style>
    .pageTitle {
        display: none;
    }
</style>

<div class="productDetailsProductContent">
    <!-- Display product images -->
    <div class="productDetailsProductImgContainer">
        <div class="productDetailsImgView">
                <img id="productDetailsDisplayIMG" src="<?= encode($products['images'][0]) ?>" alt="<?= encode($products['name']) ?> main view">
        </div>

        <?php if(count($products['images']) > 1): ?>
        <div class="productDetailsThumbnailBar">
            <div class="productDetailsThumbnailInner">
                <?php foreach ($products['images'] as $img): ?>
                    <img class="productDetailsThumbIMG" src="<?= encode($img) ?>" onclick="swapImage('<?= encode($img) ?>', this)" alt="Thumbnail">
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Display product info -->
    <div class="productDetailsProductDetails">
        <div class="inner-box">
            <h2><?= encode($products['name']) ?></h2>

            <p class="productDetailsPrice">Price: RM<?= number_format($products['price'],2) ?></p>
            
            <div class="productDetailsSizeStatus">
                <p><strong>Brand:<?= encode($products['brand']) ?><strong></p>
                <p><strong>Series:<?= encode($products['series']) ?><strong></p>
                <p><strong>Scale:</strong> <?= encode($products['scale']) ?></p>
                <p><strong>Status:</strong> <?= encode($products['stock_quantity']) ?> units left (<?= encode($products['status']) ?>)</p>
            </div>
            <div class="productDetailsDescriptionBox">
                <p><strong>Description:</strong></p>
                <p><?= encode($products['description']) ?></p>
            </div>
        
            <form method="post" class="productDetailsAddCartButton">
                <?php html_hidden('product_id', $products['product_id']) ?>
                
                <div class="productDetailsQuantityInput">
                    <label>Quantity:</label>
                    <?php html_number('quantity', 1, 1, $products['stock_quantity']) ?>
                </div>
                <button type="submit" class="productDetailsBtn">Add To Cart🛒</button>
            </form>
        
        </div>
    </div>
</div>

 <script>
    function swapImage(imgSrc, thumbElement){
      //change the focused image
      document.getElementById('productDetailsDisplayIMG').src = imgSrc;
      //reset the thumbnails to it's default border
      document.querySelectorAll('.productDetailsThumbIMG').forEach(t => {
        t.classList.remove('active');
      });
      //highlight the clicked thumbnail
      thumbElement.classList.add('active');
    }
 </script>
    


<?php 
    include '../_foot.php';
?>