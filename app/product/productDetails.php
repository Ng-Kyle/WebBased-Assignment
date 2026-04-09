<?php 
    include '../_base.php';

    $member_id = $_SESSION['user']->Member_ID ?? 1;

    if (is_post()){
        $product_id = post('Product_ID');
        $quantity = post('Quantity');

        if ($quantity>0){
        $stm = $_db->prepare('SELECT Cart_ID FROM cart WHERE Member_ID = ?');
        $stm->execute([$member_id]);
        $cart = $stm->fetch();
        

            if($cart){
            $cart_id = $cart->Cart_ID;   
            

                //this is for checking if the product exists in the member's cart
                $stm = $_db->prepare('SELECT * FROM cart_product WHERE Product_ID = ? AND Cart_ID = ? ');
                $stm->execute([$product_id,$cart_id]);
                $exists = $stm->fetch();

                if($exists){
                    //update existing product
                    $stm = $_db->prepare('UPDATE cart_product SET Quantity = Quantity + ? WHERE Product_ID = ? AND Cart_ID = ?');
                    $stm->execute([$quantity,$product_id,$cart_id]);
                }else{
                    //insert new product
                    $stm = $_db->prepare('INSERT INTO cart_product (Product_ID, Cart_ID,Quantity) VALUES (?,?,?)');
                    $stm->execute([$product_id,$cart_id,$quantity]);
                }

                redirect('../cart/cart.php');
            }
        }
    }

                
    $id = req('Product_ID');
    $stm = $_db->prepare('SELECT p.*, pi.* FROM product p LEFT JOIN product_image pi ON p.Product_ID = pi.Product_ID WHERE p.Product_ID = ?');
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
            
        'Product_ID'     => $productIDimg[0]->Product_ID,
        'Name'           => $productIDimg[0]->Name,
        'Description'    => $productIDimg[0]->Description,
        'Price'          => $productIDimg[0]->Price,
        'Stock_Quantity' => $productIDimg[0]->Stock_Quantity,
        'Status'         => $productIDimg[0]->Status,
        'Scale'          => $productIDimg[0]->Scale,
        'Series'         => $productIDimg[0]->Series,
        'Brand'          => $productIDimg[0]->Brand,
        'Images'         => []

    ];

    foreach ($productIDimg as $p){
        if ($p->Image_URL ?? false){ //?? end means if there's no or image_URL, it will turn it to false
            $products['Images'][] = '../images/' . basename($p->Image_URL); //the extra [] is for append.
        }
    }

    $_title = $products['Name'];
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
    <?php if (!empty($products['Images'])): ?>
        <?php foreach ($products['Images'] as $img): ?>
            <img class="products-img" src="<?=($img) ?>" 
                 alt="<?= ($products['Name']) ?>"

            >
        <?php endforeach; ?>
    <?php else: ?>
        <p>No images available.</p>
    <?php endif; ?>
</div>

<!-- Display product info -->
 <div class="products-details">
    <p>Price: RM<?= ($products['Price']) ?></p>
    <p>Scale: <?= ($products['Scale']) ?></p>
    <p>Description: <br><?= ($products['Description']) ?> </p>
    <p>Stock Quantity: <?=($products['Stock_Quantity']) ?></p> <p>Status: <?=($products['Status']) ?></p>

    <form method="post">
        <input type="hidden" name="Product_ID" value="<?= $products['Product_ID'] ?>">

        <label>Quantity:</label>
        <input type="number" name="Quantity" value="1" min="1" max="<?= $products['Stock_Quantity'] ?>">

        <button type="submit">Add To Cart</button>
    </form>
 </div>
    


<?php 
    include '../_foot.php';
?>