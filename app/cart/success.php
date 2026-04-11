<?php
    include '../_base.php';
    require __DIR__ . "/../vendor/autoload.php";
    $stripe_secret_key = "sk_test_51TJ4OXCIH3Zb8MZN4bU0fQ3AzdKQ3NxcUelsIVfh1BcH5Z0pJQJ9varZAdpmqPQkCuSslybL8inySwPKisrWDLTj004Jf0upaO";
    \Stripe\Stripe::setApiKey($stripe_secret_key);
    $_title = 'Receipt';
    auth();
    include '../_head.php';
    

    $session_id = get('session_id');
    $session = \Stripe\Checkout\Session::retrieve($session_id);
    if($session->payment_status !== 'paid'){
        temp('info', "Payment wasn't completed!");
        redirect('cart.php');
    }
    $stm = $_db->prepare('SELECT count(*) FROM invoice WHERE stripe_session_id = ?');
    $stm->execute([$session_id]);
    $count = $stm->fetchColumn();
    if($count > 0){
        temp('info',"Receipt was already created!");
        redirect('cart.php');
    }   

    $cart_id = $session->metadata->cart_id;
    $stm = $_db->prepare('SELECT p.*, cp.* FROM cart_product cp JOIN product p ON cp.Product_ID = p.Product_ID WHERE cp.Cart_ID = ?');
    $stm->execute([$cart_id]);
    $products = $stm->fetchAll();
    $total = 0;
    foreach($products as $p){
        $total+=$p->Price * $p->Quantity;
    } 


    $stm = $_db->prepare('SELECT m.member_id FROM member m JOIN cart c ON m.Member_ID = c.Member_ID WHERE c.Cart_ID = ?');
    $stm->execute([$cart_id]);
    $member_id = $stm->fetchColumn();
    
 
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

    
    
    $stm = $_db->prepare('INSERT INTO invoice (member_id, order_date, status, total_amount, street_address, post_code, city, state,stripe_session_id) 
    VALUES (?,CURRENT_TIMESTAMP,"Preparing",?,?,?,?,?,?)');
    $stm->execute([$member_id,$total,$street_address,$post_code, $city, $state,$session_id]);
    

    $order = $_db->lastInsertId();
    foreach($products as $p){
        $stm = $_db->prepare('INSERT INTO order_details (order_id,product_id,quantity) VALUES (?,?,?)');
        $stm->execute([$order,$p->Product_ID, $p->Quantity]);
    }

    $stm = $_db->prepare('DELETE FROM cart_product WHERE cart_id = ?');
    $stm->execute([$cart_id]);
    
    $stm = $_db->prepare('INSERT INTO receipt (order_id, payment_date, amount_paid) VALUES (?,CURRENT_TIMESTAMP,?)');
    $stm->execute([$order,$session->amount_total/100]); 
    $receipt = $_db->lastInsertId();

    $m = get_mail();
    $m->addAddress($_user->Email, $_user->Name);
    $m->isHTML(true);
    $m->Subject = 'AnonFigures Receipt';
    $m->Body = "
        
        <h1 style='color: #FF4060'>Receipt</h1>
        <h2>Dear $_user->Name,</h2>
        <p>Below is a link with your receipt attached.</p>
        <a href = 'http://localhost:8000/cart/receipt.php?receipt_id=$receipt'>Click here to view it.</a>
        <p>Thank you for shopping at AnonFigures.</p>
        <h2>From, The AnonFigures Team</h2>
    ";
    $m->send();
?>
<style>
    main >:first-child{
        display:none;
    }
    .receipt h1{
        color: #FF5E7E;
    }
    h2{
        color: #FF5E7E;
    }
</style>
    <div class = "receipt">
        <h1>Payment was successful!</h1>
        <p>Below is your receipt, a copy has already been sent to your email.</p>
    </div>  
    <iframe src="http://localhost:8000/cart/receipt.php?receipt_id=<?= $receipt ?>" style="border:none; height:100vh; width:100%;"></iframe> 
    
<?php 
    include '../_foot.php';
?>

