<?php
include "../_base.php";

if (is_post()) {

    // retrieve id from url
    $id=req('id');
    $stm=$_db->prepare('DELETE FROM member WHERE id = ?');
    $stm->execute([$id]);
    temp('info','Record has been successfully deleted!');
}


redirect();
?>