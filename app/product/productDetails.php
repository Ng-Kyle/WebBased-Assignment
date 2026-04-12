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

        if ($quantity>0 && $quantity<= $real_stock){
            $cart_id = get_cart();
            //this is for checking if the product exists in the member's cart
            $stm = $_db->prepare('SELECT * FROM cart_product WHERE product_id = ? AND cart_id = ? ');
            $stm->execute([$product_id,$cart_id]);
            $exists = $stm->fetch();

            if($exists){
                //update existing product
                $stm = $_db->prepare('UPDATE cart_product SET quantity = quantity + ? WHERE product_id = ? AND cart_id = ?');
                $stm->execute([$quantity,$product_id,$cart_id]);
            }else{
                //insert new product
                $stm = $_db->prepare('INSERT INTO cart_product (product_id, cart_id, quantity) VALUES (?,?,?)');
                $stm->execute([$product_id,$cart_id,$quantity]);
            }
            temp('info', 'Added to Cart!! 🛒');
            redirect('../cart/cart.php');
        }else{
            temp('info', 'Invalid Quantity 😡!!');
            redirect();
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
    .products-images{
        display: flex;
        margin-top: -60px;
        justify-content: center;
        align-items: center;
        height: 300px;
        width: 40%;
        border-style: solid ;
        border-color: rgb(255, 161, 175);
        border-radius: 5px;
    }

    .products-img{
        width: 250px;
        height: 300px;
        object-fit: contain;
    }

    main h1{
        position:relative;
        max-width: 52%;
        left:45%;
        overflow-wrap:break-word;
    }

    .products-details{
        position:relative;
        left:46.5% ;
        max-width: 52%;
        margin-top: -250px;
    }


</style>

<!-- Display product images -->

<div class="products-images">
    <?php if (!empty($products['images'])): ?>
        <?php foreach ($products['images'] as $img): ?>
            <img class="products-img" src="<?=encode($img) ?>" 
                 alt="<?= encode($products['name']) ?>"

            >
        <?php endforeach; ?>
    <?php else: ?>
        <p>No images available.</p>
    <?php endif; ?>
</div>

<!-- Display product info -->
 <div class="products-details">
    <p>Price: RM<?= number_format($products['price'],2) ?></p>
    <p>Scale: <?= encode($products['scale']) ?></p>
    <p>Description: <br><?= encode($products['description']) ?> </p>
    <p>Stock Quantity: <?=encode($products['stock_quantity']) ?></p> <p>Status: <?=encode($products['status']) ?></p>

    <form method="post">
        <?php html_hidden('product_id', $products['product_id']) ?>

        <label>Quantity:</label>
        <?php html_number('quantity', 1, 1, $products['stock_quantity']) ?>

        <button type="submit">Add To Cart</button>
    </form>
 </div>
    


<?php 
    include '../_foot.php';
?>