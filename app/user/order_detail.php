<?php
    include '../_base.php';
    if(is_post()){
        $order_id = req('order_id');
        $stm = $_db->prepare("SELECT p.*, od.*, o.* FROM order_details od INNER JOIN product p ON od.product_id = p.product_id INNER JOIN invoice o ON od.order_id = o.order_id WHERE od.order_id = ? AND o.member_id = ?");
        $stm->execute([$order_id, $_user->Member_ID]);
        $orders = $stm->fetchAll();

    }
    include '../_head.php';


?>