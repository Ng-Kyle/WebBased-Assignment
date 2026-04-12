<?php
include "../../_base.php";

if (is_post()) {

    // retrieve id from url
    $id=req('product_id');
    $stm=$_db->prepare('DELETE FROM product WHERE product_id = ?');
    $stm->execute([$id]);
    temp('info','Product has been successfully deleted!');
}


redirect();
?>