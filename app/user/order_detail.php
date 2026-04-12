<?php
    include '../_base.php';
    auth('member');
    if(is_post()){
        $order_id = req('order_id');
        $stm = $_db->prepare("SELECT * FROM invoice WHERE order_id = ? AND member_id = ?");
        $stm->execute([$order_id, $_user->member_id]);
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
<style>
        #productImage{
            padding-top:5px;
            padding-right:10px;
            width: 150px;
            height: 150px;
        }
        .productRowTop{
            border-top: 3px solid pink;
        }
        .productRowMiddle{
            vertical-align: top;
        }
        .productRowBottom{
            border-bottom: 3px solid pink;
        }
        .productDetails{
            width: 80%;
            vertical-align: bottom;
        }
        table{
            border-collapse: collapse; 
        }
        h2{
            font-size: 35px;
            color:#FF5E7E;
            padding-top:40px;
        }
        .removeBtn{
            text-align: right;
            width:20%;
            vertical-align: top;
        }
        .cartBtn{
            text-align: right;
            width:20%;
            vertical-align: top;
        }
        .cartBtn img{
            width:25px;
            padding-top:5px;
            height:auto;
            vertical-align: text-bottom;
        }
        button{
            border: none;
            background-color: white;
            color:#FF5E7E;
            font-size: 15pt;
            font-weight: bold;
            text-decoration: underline 2pt;
        }
        .removeBtn img{
            width:15px;
            padding-top:5px;
            height:auto;
        }
        button:hover{
            cursor:pointer
        }
        .totalPriceArea{
            text-align: right;
        }
        #totalItems{
            font-size:20pt;
            font-weight:bold;
            color:#FF5E7E;
            margin-bottom:2px;
        }
        #subTotal{
            font-size:30px;
            font-weight:bold;
            color:#FF5E7E;
        }
        #emptyCart{
            text-align:center;
            padding-top: 30px;
            padding-bottom:180px;
            font-size:25pt;
            font-weight:bold;
        }
        .productPrice{
            font-size:24pt;
            font-weight: bold;
            color: #FF5E7E;
        }
        #productCategory{
            color:gray;
            font-size:10pt;
        }
        #productQuantity{
            font-size:20pt;
            font-weight: bold;
            color: #FF5E7E;
        }
        #quantityValue {
            text-align: right;
            font-size:20pt;
            width:30%;
            font-weight:bold;
            color: #FF5E7E;
        }

        .productDetails{
            font-size:14pt;
        }
        #shippingAddressText{
            width:90%;
        }
        .orderDetails h2{
            padding-top: 0px;
            margin-bottom:5px;
            font-size:24pt;
        }
        #shippingAddress{
            font-weight:bold;
            font-size:14pt;
        }
</style>
<table>
    <tr class = orderDetails>
        <td id = "shippingAddressText"><h2>Shipping Address:</h2></td>
        <td id = "status"><h2>Status:</h2></td>
        <td><h2><?= $order->status ?></h2></td>
    </tr>
    <tr>
        <td id = "shippingAddress"><?= $order->street_address . ', ' . $order->city . ', ' . $order->state . ' ' . $order->post_code?></td>
    </tr>
</table>
<?php if($products): ?>
        <table>
            <?php foreach($products as $p): ?>        
            <tr class = productRowTop>
                <td rowspan = "3"><a><img id = productImage src = <?= $product_image[$p->product_id][0]->image_url ?> alt = <?= $product_image[$p->product_id][0]->alt_text ?>></a></td>
                <td class = productDetails><b><?= $p->name ?></b><br><span id="productCategory"><?= $p->brand." ".$p->scale." ".$p->series ?></span></td>
                <td></td>
                <td class = removeBtn></td>
            </tr>
            <tr class = productRowMiddle>
                <td class = productPrice>RM <?= number_format($p->price,2) ?></td>
                <td id = "productQuantity">Quantity:</td>
                <td id = "quantityValue"><?= $p->quantity ?></td>
                
            </tr>
            <tr class = productRowBottom>
                <td></td>
                <td></td>
                <td class = "cartBtn"></td>
            </tr>
            <?php endforeach ?>
        </table>
    <?php endif?>
    <div class = totalPriceArea>
        <p id = subTotal>Total: RM<?= number_format($order->total_amount,2) ?></p>
    </div>
<?php include '../_foot.php' ?>