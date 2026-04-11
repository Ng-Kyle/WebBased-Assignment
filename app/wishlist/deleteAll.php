<?php
include "../_base.php";
if (is_post()){
        $wishlist_id = get_wishlist();
        $stm = $_db->prepare('DELETE FROM wishlist_product WHERE wishlist_ID = ?');
        $stm->execute([$wishlist_id]);
    }
redirect("wishlist.php");
?>