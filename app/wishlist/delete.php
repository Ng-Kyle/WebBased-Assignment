<?php
    include "../_base.php";
    if (is_post()){
            $wishlist_id = get_wishlist();
            $product_id = req('product_id');
            $stm = $_db->prepare('DELETE FROM wishlist_product WHERE wishlist_id = ? AND product_id = ?');
            $stm->execute([$wishlist_id, $product_id]);
        }
    redirect("wishlist.php");
?>