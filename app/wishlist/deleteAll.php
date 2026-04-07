<?php
include "../_base.php";
if (is_post()){
        $wishlist_id = req('wishlist_id');
        $stm = $_db->prepare('DELETE FROM wishlist_product WHERE wishlist_ID = ?');
        $stm->execute([$wishlist_id]);
    }
redirect("wishlist.php");
?>