<?php
    include '../_base.php';
    require __DIR__ . "/../vendor/autoload.php";
    $stripe_secret_key = "sk_test_51TJ4OXCIH3Zb8MZN4bU0fQ3AzdKQ3NxcUelsIVfh1BcH5Z0pJQJ9varZAdpmqPQkCuSslybL8inySwPKisrWDLTj004Jf0upaO";
    \Stripe\Stripe::setApiKey($stripe_secret_key);
    $_title = 'Receipt';
    include '../_head.php';
    $_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //Check for stripe status
    $session_id = get('session_id');
    $session = \Stripe\Checkout\Session::retrieve($session_id);
    if($session->payment_status !== 'paid'){
        die("Payment not completed");
    }
    $stm = $_db->prepare('SELECT count(*) FROM invoice WHERE stripe_session_id = ?');
    $stm->execute([$session_id]);
    $count = $stm->fetchColumn();
    if($count > 0){
        die("Order was already created!");
    }   

    $cart_id = $session->metadata->cart_id;
    $stm = $_db->prepare('SELECT p.*, cp.* FROM cart_product cp JOIN product p ON cp.Product_ID = p.Product_ID WHERE cp.Cart_ID = ?');
    $stm->execute([$cart_id]);
    $products = $stm->fetchAll();
    $total = 0;
    foreach($products as $p){
        $total+=$p->Price * $p->Quantity;
    } 

    //Get MemberID
    $stm = $_db->prepare('SELECT m.* FROM member m JOIN cart c ON m.Member_ID = c.Member_ID WHERE c.Cart_ID = ?');
    $stm->execute([$cart_id]);
    $member = $stm->fetch();
    
    //Get shippingAddress from stripe
    $address = $session->collected_information->shipping_details;
    if($address){
        $street_address = $address->address->line1;
        $line2 = $address->address->line2;
        if($line2){
            $street_address .= ','.$line2;
        }
        $post_code = $address->address->postal_code;
        $city = $address->address->city;
        $state = $address->address->state;
    }
    //Create Order
    
    
    $stm = $_db->prepare('INSERT INTO invoice (member_id, order_date, status, total_amount, street_address, post_code, city, state,stripe_session_id) 
    VALUES (?,CURRENT_TIMESTAMP,"Preparing",?,?,?,?,?,?)');
    $stm->execute([$member->Member_ID,$total,$street_address,$post_code, $city, $state,$session_id]);
    
    //Create order details for each product in cart
    $order = $_db->lastInsertId();
    foreach($products as $p){
        $stm = $_db->prepare('INSERT INTO order_details (order_id,product_id,quantity) VALUES (?,?,?)');
        $stm->execute([$order,$p->Product_ID, $p->Quantity]);
    }

    //Delete all products from cart.
    $stm = $_db->prepare('DELETE FROM cart_product WHERE cart_id = ?');
    $stm->execute([$cart_id]);
    
    $stm = $_db->prepare('INSERT INTO receipt (order_id, payment_date, amount_paid) VALUES (?,CURRENT_TIMESTAMP,?)');
    $stm->execute([$order,$session->amount_total/100]); 
    $receipt = $_db->lastInsertId();
?>
    <p>Payment was successful!</p>
    <iframe src="http://localhost:8000/cart/receipt.php?receipt_id=<?= $receipt ?>" style="border:none; height:100vh; width:100%;"></iframe> 
<?php 
    include '../_foot.php'
?>

