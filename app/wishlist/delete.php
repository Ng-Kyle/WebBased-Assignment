<?php
include "../_base.php";
if (is_post()){
        $wishlist_id = req('wishlist_id');
        $product_id = req('product_id');
        $stm = $_db->prepare('DELETE FROM wishlist_product WHERE Wishlist_ID = ? AND Product_ID = ?');
        $stm->execute([$wishlist_id, $product_id]);
    }
redirect("wishlist.php");
?>