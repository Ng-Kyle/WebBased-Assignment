<?php
    include "../_base.php";
    require __DIR__ . "/../vendor/autoload.php";
    $stripe_secret_key = "sk_test_51TJ4OXCIH3Zb8MZN4bU0fQ3AzdKQ3NxcUelsIVfh1BcH5Z0pJQJ9varZAdpmqPQkCuSslybL8inySwPKisrWDLTj004Jf0upaO";    \Stripe\Stripe::setApiKey($stripe_secret_key);

    if (is_post()){
        $cart_id = req('cart_id');
        $stm = $_db->prepare('SELECT p.*, cp.* FROM cart_product cp JOIN product p ON cp.Product_ID = p.Product_ID WHERE cp.Cart_ID = ?');
        $stm->execute([$cart_id]);
        $products = $stm->fetchAll();
    
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
            "mode" => "payment",
            "success_url" => "http://localhost:8000/member/success.php?cart_id=$cart_id",
            "cancel_url" => "http://localhost:8000/member/cart.php",
            "line_items" => $line_items
        ]);
        http_response_code(303);
        header("Location: " . $checkout_session->url);
    }
?>  
