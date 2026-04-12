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

<<<<<<< HEAD
        if ($quantity>0 && $quantity<= $real_stock){
            $cart_id = get_cart();
            //this is for checking if the product exists in the member's cart
            $stm = $_db->prepare('SELECT * FROM cart_product WHERE product_id = ? AND cart_id = ? ');
            $stm->execute([$product_id,$cart_id]);
            $exists = $stm->fetch();
            var_dump($exists);
            if($exists){
                if($exists->quantity <= $real_stock){
                    //update existing product
                    $stm = $_db->prepare('UPDATE cart_product SET quantity = quantity + ? WHERE product_id = ? AND cart_id = ?');
                    $stm->execute([$quantity,$product_id,$cart_id]);
                }
            }else{
                //insert new product
                $stm = $_db->prepare('INSERT INTO cart_product (product_id, cart_id, quantity) VALUES (?,?,?)');
                $stm->execute([$product_id,$cart_id,$quantity]);
            }
            temp('info', 'Added to Cart!! 🛒');
            redirect('../cart/cart.php');
        }else{
=======
        if ($quantity<0 && $quantity>= $real_stock){
>>>>>>> 3909c54bab864c97759ff5f101ad41d167e0c6eb
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
    main > h1:first-child{
        display: none;
    }
</style>

<div class="productContent">
    <!-- Display product images -->
    <div class="productImgContainer">
        <div class="imgView">
                <img id="displayIMG" src="<?= encode($products['images'][0]) ?>" alt="<?= encode($products['name']) ?> main view">
        </div>

        <?php if(count($products['images']) > 1): ?>
        <div class="thumbnailBar">
            <div class="thumbnailInner">
                <?php foreach ($products['images'] as $img): ?>
                    <img class="thumbIMG" src="<?= encode($img) ?>" onclick="swapImage('<?= encode($img) ?>', this)" alt="Thumbnail">
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Display product info -->
    <div class="products-details">
        <h2><?= encode($products['name']) ?></h2>

        <p class="price">Price: RM<?= number_format($products['price'],2) ?></p>
        <div class="sizeStatus">
            <p><strong>Scale:</strong> <?= encode($products['scale']) ?></p>
            <p><strong>Status:</strong> <?= encode($products['stock_quantity']) ?> units left (<?= encode($products['status']) ?>)</p>
        </div>
        <div class="descriptionBox">
            <p><strong>Description:</strong></p>
            <p><?= encode($products['description']) ?></p>
        </div>

        <form method="post" class="addCartButton">
            <?php html_hidden('product_id', $products['product_id']) ?>
            
            <div class="quantityInput">
                <label>Quantity:</label>
                <?php html_number('quantity', 1, 1, $products['stock_quantity']) ?>
            </div>
            <button type="submit" class="btn">Add To Cart</button>
        </form>
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
    include '../_foot.php';
?>