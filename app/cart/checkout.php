<?php
    include "../_base.php";
    require __DIR__ . "/../vendor/autoload.php";
    $stripe_secret_key = "sk_test_51TJ4OXCIH3Zb8MZN4bU0fQ3AzdKQ3NxcUelsIVfh1BcH5Z0pJQJ9varZAdpmqPQkCuSslybL8inySwPKisrWDLTj004Jf0upaO";
    \Stripe\Stripe::setApiKey($stripe_secret_key);
    auth('member');
    if (is_post()){
        $cart_id = get_cart();
        $stm = $_db->prepare('SELECT p.*, cp.* FROM cart_product cp JOIN product p ON cp.product_id = p.product_id WHERE cp.cart_id = ?');
        $stm->execute([$cart_id]);
        $products = $stm->fetchAll();
        
        //Get Member email
        $stm = $_db->prepare('SELECT m.email FROM member m JOIN cart c ON m.member_id = c.member_id WHERE c.cart_id = ?');
        $stm->execute([$cart_id]);
        $email = $stm->fetchColumn();
    
        $line_items = [];
        foreach($products as $p){
            $line_items[] = [
                "quantity" => $p->quantity,
                "price_data" => [
                    "currency" => "myr",
                    "unit_amount" => $p->price*100,
                    "product_data" => [
                        "name" => $p->name
                    ]
                ]
            ];
        }
        $checkout_session = \Stripe\Checkout\Session::create([
            "customer_email" => $email,
            "mode" => "payment",
            "success_url" => "http://localhost:8000/cart/success.php?session_id={CHECKOUT_SESSION_ID}",
            "cancel_url" => "http://localhost:8000/cart/cart.php",
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
