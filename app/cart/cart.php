<?php
    include '../_base.php';
    $_title = 'Shopping Cart';
    include '../_head.php';
    if(is_post()){
        $product_id = req('product_id');
        $quantity = req('quantity');
        if($quantity <= 0){
            $_err['quantity'] = 'Invalid Quantity';
        }
        if(!$_err){
            $stm = $_db->prepare('UPDATE cart_product SET quantity = ? WHERE product_id = ?');
            $stm->execute([$quantity,$product_id]);
        }
    }
    $stm = $_db->prepare('SELECT p.*, cp.* FROM cart_product cp JOIN product p ON cp.Product_ID = p.Product_ID WHERE cp.Cart_ID = 1');    
    $stm->execute();
    $products = $stm->fetchAll();
    $product_image = [];
    $total = 0;
    $totalItems = 0;
    foreach($products as $p){
            $total+=$p->Price * $p->Quantity;
            $totalItems += $p->Quantity;
            $stm = $_db->prepare('SELECT * FROM product_image WHERE product_id = ?');
            $stm->execute([$p->Product_ID]);
            $image = $stm->fetchAll();
            $product_image[$p->Product_ID] = $image;
        } 
    $stm = $_db->prepare('SELECT Cart_ID FROM cart WHERE Cart_ID = 1');
    $stm->execute();
    $cart_id = $stm->fetch();


    
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
            text-align:center;
            font-size: 35px;
            color:#FF5E7E;
            padding-top:40px;
        }
        .removeBtn{
            text-align: right;
            width:20%;
            vertical-align: top;
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
        }
        #productQuantity{
            font-size:20pt;
            font-weight: bold;
            color: #FF5E7E;
        }
        #quantityValue {
            text-align: right;
        }
        #quantityValue input{
            text-align: center;
            font-size:20pt;
            width:30%;
            border: 5px solid pink;
            font-weight:bold;
            color: #FF5E7E;
            margin-right:5px;
            
        }
        main > :first-child{
            display: none;
        }
        #checkOutBtn{
            width:100%;
            height:60px;
            border: 5px solid pink;
            border-radius: 10px;
            background-color: pink;
            color:black;
            text-decoration: none;
        }
        #checkOutBtn:hover{
            background-color:#ffa1b0;
            border-color: #ffa1b0
        }
    </style>
    <h2>Cart</h2>
    <?php if($products): ?>
        <table>
            <?php foreach($products as $p): ?>        
            <tr class = productRowTop>
                <td rowspan = "3"><a><img id = productImage src = <?= $product_image[$p->Product_ID][0]->Image_URL ?> alt = <?= $product_image[$p->Product_ID][0]->Alt_Text ?>></a></td>
                <td class = productDetails><b><?= $p->Name ?></b><br><span id="productCategory"><?= $p->Brand." ".$p->Scale." ".$p->Series ?></span></td>
                <td></td>
                <td class = removeBtn><button data-post="delete.php?cart_id=<?=$p->Cart_ID?>&product_id=<?=$p->Product_ID?>"><img src = "/images/trash.png" alt = "trash">Remove</button></td>
            </tr>
            <tr class = productRowMiddle>
                <td class = productPrice>RM <?= number_format($p->Price,2) ?></td>
                <td id = "productQuantity"><label for="quantity">Quantity:</label></td>
                <form method = "post">
                <td id = "quantityValue">
                    
                        <?= html_hidden('product_id',$p->Product_ID) ?>
                        <?= html_number('quantity', $p->Quantity, 1) ?>
                </form>
                </td>
            </tr>
            <tr class = productRowBottom></tr>
            <?php endforeach ?>
        </table>
    
    <div class = totalPriceArea>
            <p id = totalItems>Total Items: <?= $totalItems ?></p>
            <button class = "removeBtn" data-post="deleteAll.php?cart_id=<?=$cart_id->Cart_ID?>"><img src="/images/trash.png" alt="trash">Remove All</button>
        <p id = subTotal>Subtotal: RM<?= number_format($total,2) ?></p>
            <button id = "checkOutBtn" data-post = "checkout.php?cart_id=<?=$cart_id->Cart_ID?>">Check Out</button>
    </div>
    <?php else: ?>
    <p id = "emptyCart">Your cart is currently empty.</p>
    <?php endif ?>
    
<script>
    $('input[type="number"]').on('change', e => e.target.form.submit());
</script>
    
<?php
    include '../_foot.php';
?>