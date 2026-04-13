<?php
    include "../_base.php";
    if (is_post()){
            $cart_id = get_cart();
            $product_id = req('product_id');
            $stm = $_db->prepare('DELETE FROM cart_product WHERE cart_id = ? AND product_id = ?');
            $stm->execute([$cart_id, $product_id]);
        }
    redirect("cart.php");
?>