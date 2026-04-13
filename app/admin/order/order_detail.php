<?php
    include '../../_base.php';
    auth('admin');
    if(is_post()){
        $order_id = req('order_id');
        $stm = $_db->prepare("SELECT i.*, m.name FROM invoice i JOIN member m ON  i.member_id = m.member_id WHERE order_id = ?");
        $stm->execute([$order_id]);
        $order = $stm->fetch();

        $stm = $_db->prepare('SELECT p.*, od.* FROM order_details od JOIN product p ON od.product_id = p.product_id WHERE order_id = ?');
        $stm->execute([$order_id]);
        $products = $stm->fetchAll();

        foreach($products as $p){
            $stm = $_db->prepare('SELECT * FROM product_image WHERE product_id = ?');
            $stm->execute([$p->product_id]);
            $image = $stm->fetchAll();
            $product_image[$p->product_id] = $image;
        } 
    }

    if(!$products){
        temp('info', 'No order was found!');
        redirect('profile.php');
    }

    $_title = "Order #".$order_id." ".$order->order_date;
    include '../_head.php';
    
?>

<div class = "orderDetailPage">
    <table>
        <tr><td class="orderDetailName"><strong>Member name: <?= $order->name ?></strong></td></tr>
        <tr class = orderDetails>
            <td class = "orderDetailShippingAddressHeader"><h2>Shipping Address:</h2></td>
            <td><h2>Status:</h2></td>
            <td><h2><?= $order->status ?></h2></td>
        </tr>
        <tr>
            <td class = "orderDetailShippingAddress"><?= $order->street_address . ', ' . $order->city . ', ' . $order->state . ' ' . $order->post_code?></td>
        </tr>
    </table>
    <?php if($products): ?>
        <table>
            <?php foreach($products as $p): ?>        
                <tr class = orderDetailProductRowTop>
                    <td rowspan = "3"><a><img class = orderDetailProductImage src = <?= $product_image[$p->product_id][0]->image_url ?> alt = <?= $product_image[$p->product_id][0]->alt_text ?>></a></td>
                    <td class = orderDetailProductDetails><b><?= $p->name ?></b><br><span class="orderDetailProductCategory"><?= $p->brand." ".$p->scale." ".$p->series ?></span></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr class = orderDetailProductRowMiddle>
                    <td class = orderDetailProductPrice>RM <?= number_format($p->price,2) ?></td>
                    <td class = "orderDetailProductQuantity">Quantity:</td>
                    <td class = "orderDetailQuantityValue"><?= $p->quantity ?></td>
                </tr>
                <tr class = orderDetailProductRowBottom>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            <?php endforeach ?>
        </table>
    <?php endif?>
    <div class = orderDetailTotalPriceArea>
        <p class = orderDetailSubTotal>Total: RM<?= number_format($order->total_amount,2) ?></p>
    </div>
</div>

<?php include '../../_foot.php'; ?>