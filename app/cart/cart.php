<?php
    include '../_base.php';
    $_title = 'Shopping Cart';
    auth('member');
    include '../_head.php';

    
    $cart_id = get_cart();

    if(is_post()){
        $product_id = req('product_id');
        $quantity = req('quantity');
        $stm = $_db->prepare('SELECT stock_quantity FROM product WHERE product_id = ?');
        $stm->execute([$product_id]);
        $stock_quantity = $stm->fetchColumn();

        if($quantity <= 0){
            $_err['quantity'] = 'Invalid Quantity';
            temp('info', "Invalid Quantity!");
            redirect();
        }
        if($quantity > $stock_quantity){
            $_err['quantity'] = 'Out of Stock!';
            temp('info', "Out of Stock!");
            redirect();
        }
        if(!$_err){
            $stm = $_db->prepare('UPDATE cart_product SET quantity = ? WHERE product_id = ? AND cart_id = ?');
            $stm->execute([$quantity,$product_id, $cart_id]);
        }
    }

    $stm = $_db->prepare('SELECT p.*, cp.* FROM cart_product cp JOIN product p ON cp.product_id = p.product_id WHERE cp.cart_id = ?');    
    $stm->execute([$cart_id]);
    $products = $stm->fetchAll();
    $product_image = [];
    $quantity = [];
    $total = 0;
    $totalItems = 0;
    foreach($products as $p){
            $quantity[$p->product_id] = $p->quantity;
            if($p->stock_quantity < $p->quantity){
                $quantity[$p->product_id] = $p->stock_quantity;
                $stm = $_db->prepare('UPDATE cart_product SET quantity = ? WHERE product_id = ? AND cart_id = ? ');
                $stm->execute([$p->stock_quantity,$p->product_id,$cart_id]);
            }
            $total+=$p->price * $quantity[$p->product_id];
            $totalItems += $quantity[$p->product_id];
            $stm = $_db->prepare('SELECT * FROM product_image WHERE product_id = ?');
            $stm->execute([$p->product_id]);
            $image = $stm->fetchAll();
            $product_image[$p->product_id] = $image;
        } 
    
?>

<style>
    .pageTitle{
            display: none;
        }
</style>

<div class = cartPage>
    <h2>Cart</h2>
    <?php if($products): ?>
        <table>
            <?php foreach($products as $p): ?>        
                <tr class = cartProductRowTop>
                    <td rowspan = "3"><a><img class = cartProductImage src = <?= $product_image[$p->product_id][0]->image_url ?> alt = <?= $product_image[$p->product_id][0]->alt_text ?>></a></td>
                    <td class = cartProductDetails><b><?= $p->name ?></b><br><span class="cartProductCategory"><?= $p->brand." ".$p->scale." ".$p->series ?></span></td>
                    <td></td>
                    <td class = cartProductRemoveBtn><button data-post="delete.php?product_id=<?= $p->product_id ?>"><img src = "/images/trash.png" alt = "trash">Remove</button></td>
                </tr>
                <tr class = cartProductRowMiddle>
                    <td class = cartProductPrice>RM <?= number_format($p->price,2) ?></td>
                    <td class = "cartProductQuantity"><label for="quantity">Quantity:</label></td>
                    <td class = "cartQuantityValue">
                        <form method = "post">
                            <?= html_hidden('product_id',$p->product_id) ?>
                            <?= html_number('quantity', $quantity[$p->product_id], 1, $p->stock_quantity) ?>
                        </form>
                    </td>
                </tr>
                <tr class = cartProductRowBottom></tr>
            <?php endforeach ?>
        </table>
    <div class = cartTotalPriceArea>
        <p class = cartTotalItems>Total Items: <?= $totalItems ?></p>
        <button class = "cartProductRemoveBtn" data-post="deleteAll.php"><img src="/images/trash.png" alt="trash">Remove All</button>
        <p class = cartSubTotal>Subtotal: RM<?= number_format($total,2) ?></p>
        <button class = "cartCheckOutBtn" data-post = "checkout.php">Check Out</button>
    </div>
    <?php else: ?>
        <p class = "cartEmptyCart">Your cart is currently empty.</p>
    <?php endif ?>
</div>

<script>
    $('input[type="number"]').on('change', e => e.target.form.submit());
</script>
    
<?php
    include '../_foot.php';
?>