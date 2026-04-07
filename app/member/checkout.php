<?php
    include "../_base.php";
    require __DIR__ . "/../vendor/autoload.php";
    $stripe_secret_key = "sk_test_51TJ4OXCIH3Zb8MZN4bU0fQ3AzdKQ3NxcUelsIVfh1BcH5Z0pJQJ9varZAdpmqPQkCuSslybL8inySwPKisrWDLTj004Jf0upaO";
    \Stripe\Stripe::setApiKey($stripe_secret_key);

    if (is_post()){
        $cart_id = req('cart_id');
        $stm = $_db->prepare('SELECT p.*, cp.* FROM cart_product cp JOIN product p ON cp.Product_ID = p.Product_ID WHERE cp.Cart_ID = ?');
        $stm->execute([$cart_id]);
        $products = $stm->fetchAll();
        
        //Get MemberID
        $stm = $_db->prepare('SELECT m.* FROM member m JOIN cart c ON m.Member_ID = c.Member_ID WHERE c.Cart_ID = ?');
        $stm->execute([$cart_id]);
        $member = $stm->fetch();
    
        $line_items = [];
        foreach($products as $p){
            $line_items[] = [
                "quantity" => $p->Quantity,
                "price_data" => [
                    "currency" => "myr",
                    "unit_amount" => $p->Price*100,
                    "product_data" => [
                        "name" => $p->Name
                    ]
                ]
            ];
        }
        $checkout_session = \Stripe\Checkout\Session::create([
            "customer_email" => $member->Email,
            "mode" => "payment",
            "success_url" => "http://localhost:8002/member/success.php?session_id={CHECKOUT_SESSION_ID}",
            "cancel_url" => "http://localhost:8002/member/cart.php",
            "line_items" => $line_items,
            "metadata" => [
                'cart_id' => $cart_id,
            ],
            "shipping_address_collection" => [
                "allowed_countries" => ["MY"]
            ],            
        ]);
        http_response_code(303);
        header("Location: " . $checkout_session->url);
    }
?>  
