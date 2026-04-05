<?php
include "../_base.php";
if (is_post()){
        $cart_id = req('cart_id');
        $stm = $_db->prepare('DELETE FROM cart_product WHERE Cart_ID = ?');
        $stm->execute([$cart_id]);
    }
redirect("cart.php");
?>