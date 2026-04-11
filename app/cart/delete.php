<?php
include "../_base.php";
if (is_post()){
        $cart_id = get_cart();
        $product_id = req('product_id');
        $stm = $_db->prepare('DELETE FROM cart_product WHERE Cart_ID = ? AND Product_ID = ?');
        $stm->execute([$cart_id, $product_id]);
    }
redirect("cart.php");
?>