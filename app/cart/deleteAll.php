<?php
include "../_base.php";
if (is_post()){
        $cart_id = get_cart();
        $stm = $_db->prepare('DELETE FROM cart_product WHERE cart_id = ?');
        $stm->execute([$cart_id]);
    }
redirect("cart.php");
?>