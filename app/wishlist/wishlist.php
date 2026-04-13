<?php
    include '../_base.php';
    $_title = 'Wishlist';
    auth('member');
    include '../_head.php';

    
    $wishlist_id = get_wishlist();

    $stm = $_db->prepare('SELECT p.*, wp.* FROM wishlist_product wp JOIN product p ON wp.product_id = p.product_id WHERE wp.wishlist_id = ?');    
    $stm->execute([$wishlist_id]);
    $products = $stm->fetchAll();
    $product_image = [];
    foreach($products as $p){
        $stm = $_db->prepare('SELECT * FROM product_image WHERE product_id = ?');
        $stm->execute([$p->product_id]);
        $image = $stm->fetchAll();
        $product_image[$p->product_id] = $image;
    } 

    if (is_post()){
        $product_id = req('product_id');
        $quantity = 1;
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
            redirect();    
        }else{
            //insert new product
            $stm = $_db->prepare('INSERT INTO cart_product (product_id, cart_id, quantity) VALUES (?,?,?)');
            $stm->execute([$product_id,$cart_id,$quantity]);
            temp('info', 'Added to Cart!! 🛒');
            redirect();
        }
    }
?>

<div class = "wishlistPage">
    <h2>Wishlist</h2>
    <?php if($products): ?>
        <table>
            <?php foreach($products as $p): ?>        
                <tr class = wishlistProductRowTop>
                    <td rowspan = "3">
                        <a>
                            <img class = wishlistProductImage src = <?= $product_image[$p->product_id][0]->image_url ?> alt = <?= $product_image[$p->product_id][0]->alt_text ?>>
                        </a>
                    </td>
                    <td class = wishlistProductDetails><b><?= $p->name ?></b><br><span class="wishlistProductCategory"><?= $p->brand." ".$p->scale." ".$p->series ?></span></td>
                    <td></td>
                    <td class = wishlistRemoveBtn><button data-post="delete.php?product_id=<?=$p->product_id?>"><img src = "/images/trash.png" alt = "trash">Remove</button></td>
                </tr>
                <tr class = wishlistProductRowMiddle>
                    <td class = wishlistProductPrice>RM <?= number_format($p->price,2) ?></td>
                    <td class = "wishlistProductStatusHeader">Status:</td>
                    <td class = "wishlistProductStatus"><?= $p->status ?></td>
                </tr>
                <tr class = wishlistProductRowBottom>
                    <td></td>
                    <td></td>
                    <td class = "wishlistCartBtn"><button data-post="?product_id=<?= $p->product_id ?>"><img src = "/images/cart.png" alt = "cart">Add Cart</button></td>
                </tr>
            <?php endforeach ?>
        </table>
        <div class = wishlistDeleteArea>
            <button class = "wishlistRemoveBtn" data-post="deleteAll.php"><img src="/images/trash.png" alt="trash">Remove All</button>
        </div>
    <?php else: ?>
        <p class = "wishlistEmpty">Your wishlist is currently empty.</p>
    <?php endif ?>
</div>
    
<?php
    include '../_foot.php';
?>