<?php
    include '../_base.php';
    $_title = 'Successful Payment';
    include '../_head.php';
    $cart_id = get('cart_id');
    $stm = $_db->prepare('SELECT p.*, cp.* FROM cart_product cp JOIN product p ON cp.Product_ID = p.Product_ID WHERE cp.Cart_ID = ?');
    $stm->execute([$cart_id]);
    $products = $stm->fetchAll();
    $total = 0;
    foreach($products as $p){
        $total+=$p->Price;
    } 

    $stm = $_db->prepare('SELECT m.* FROM member m JOIN cart c ON m.Member_ID = c.Member_ID WHERE c.Cart_ID = ?');
    $stm->execute([$cart_id]);
    $member = $stm->fetch();
    
    $stm = $_db->prepare('INSERT INTO invoice (member_id, order_date, status, total_amount, final_amount, street_address, post_code, city, state) 
    VALUES (?,CURRENT_TIMESTAMP,"Preparing",?,?,?,?,?,?)');
    $_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    try{
    $stm->execute([$member->Member_ID,$total,$total,$member->Street_Address, $member->Post_Code, $member->City, $member->State]);
    }catch (PDOException $e){
        die($e->getMessage());
    }
?>
    <p>Payment was successful!</p>
<?php 
    include '../_foot.php'
?>

