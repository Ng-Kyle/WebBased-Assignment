<?php
    include '../_base.php';

    if(is_post()){
        $order_id = req('order_id');
        $stm = $_db->prepare("SELECT * FROM invoice WHERE order_id = ? AND member_id = ?");
        $stm->execute([$order_id, $_user->Member_ID]);
        $order = $stm->fetch();

        $stm = $_db->prepare('SELECT p.*, od.* FROM order_details od JOIN product p ON od.product_id = p.product_id WHERE order_id = ?');
        $stm->execute([$order_id]);
        $products = $stm->fetchAll();

        foreach($products as $p){
            $stm = $_db->prepare('SELECT * FROM product_image WHERE product_id = ?');
            $stm->execute([$p->Product_ID]);
            $image = $stm->fetchAll();
            $product_image[$p->Product_ID] = $image;
        } 
    }
    if(!$products){
        temp('info', 'No order was found!');
        redirect('profile.php');
    }
    $_title = "Order #".$order_id." ".$order->Order_Date;
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
        <td><h2><?= $order->Status ?></h2></td>
    </tr>
    <tr>
        <td id = "shippingAddress"><?= $order->Street_Address . ', ' . $order->City . ', ' . $order->State . ' ' . $order->Post_Code?></td>
    </tr>
</table>
<?php if($products): ?>
        <table>
            <?php foreach($products as $p): ?>        
            <tr class = productRowTop>
                <td rowspan = "3"><a><img id = productImage src = <?= $product_image[$p->Product_ID][0]->Image_URL ?> alt = <?= $product_image[$p->Product_ID][0]->Alt_Text ?>></a></td>
                <td class = productDetails><b><?= $p->Name ?></b><br><span id="productCategory"><?= $p->Brand." ".$p->Scale." ".$p->Series ?></span></td>
                <td></td>
                <td class = removeBtn></td>
            </tr>
            <tr class = productRowMiddle>
                <td class = productPrice>RM <?= number_format($p->Price,2) ?></td>
                <td id = "productQuantity">Quantity:</td>
                <td id = "quantityValue"><?= $p->Quantity ?></td>
                
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
        <p id = subTotal>Total: RM<?= number_format($order->Total_Amount,2) ?></p>
    </div>
<?php include '../_foot.php' ?>