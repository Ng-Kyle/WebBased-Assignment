<?php
    include '../_base.php';
    $_title = 'Shopping Cart';
    auth('member');
    include '../_head.php';

    
    $cart_id = get_cart();

    if(is_post()){
        $product_id = req('product_id');
        $quantity = req('quantity');
        $stm = $_db->prepare('SELECT stock_quantity FROM product WHERE product_id = ?');
        $stm->execute([$product_id]);
        $stock_quantity = $stm->fetchColumn();

        if($quantity <= 0){
            $_err['quantity'] = 'Invalid Quantity';
            temp('info', "Invalid Quantity!");
            redirect();
        }
        if($quantity > $stock_quantity){
            $_err['quantity'] = 'Out of Stock!';
            temp('info', "Out of Stock!");
            redirect();
        }
        if(!$_err){
            $stm = $_db->prepare('UPDATE cart_product SET quantity = ? WHERE product_id = ? AND cart_id = ?');
            $stm->execute([$quantity,$product_id, $cart_id]);
        }
    }

    $stm = $_db->prepare('SELECT p.*, cp.* FROM cart_product cp JOIN product p ON cp.product_id = p.product_id WHERE cp.cart_id = ?');    
    $stm->execute([$cart_id]);
    $products = $stm->fetchAll();
    $product_image = [];
    $quantity = [];
    $total = 0;
    $totalItems = 0;
    foreach($products as $p){
            $quantity[$p->product_id] = $p->quantity;
            if($p->stock_quantity < $p->quantity){
                $quantity[$p->product_id] = $p->stock_quantity;
                $stm = $_db->prepare('UPDATE cart_product SET quantity = ? WHERE product_id = ? AND cart_id = ? ');
                $stm->execute([$p->stock_quantity,$p->product_id,$cart_id]);
            }
            $total+=$p->price * $quantity[$p->product_id];
            $totalItems += $quantity[$p->product_id];
            $stm = $_db->prepare('SELECT * FROM product_image WHERE product_id = ?');
            $stm->execute([$p->product_id]);
            $image = $stm->fetchAll();
            $product_image[$p->product_id] = $image;
        } 
    
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
            font-size:10pt;
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
            border-radius: 8px;
            
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
            background-color:#ff93a5;
            border-color: #ff93a5
        }
        .productDetails{
            font-size:14pt;
        }
    </style>
    <h2>Cart</h2>
    <?php if($products): ?>
        <table>
            <?php foreach($products as $p): ?>        
            <tr class = productRowTop>
                <td rowspan = "3"><a><img id = productImage src = <?= $product_image[$p->product_id][0]->image_url ?> alt = <?= $product_image[$p->product_id][0]->alt_text ?>></a></td>
                <td class = productDetails><b><?= $p->name ?></b><br><span id="productCategory"><?= $p->brand." ".$p->scale." ".$p->series ?></span></td>
                <td></td>
                <td class = removeBtn><button data-post="delete.php?product_id=<?= $p->product_id ?>"><img src = "/images/trash.png" alt = "trash">Remove</button></td>
            </tr>
            
            <tr class = productRowMiddle>
                <td class = productPrice>RM <?= number_format($p->price,2) ?></td>
                <td id = "productQuantity"><label for="quantity">Quantity:</label></td>
                
                <td id = "quantityValue">
                    <form method = "post">
                        <?= html_hidden('product_id',$p->product_id) ?>
                        <?= html_number('quantity', $quantity[$p->product_id], 1, $p->stock_quantity) ?>
                    </form>
                </td>
                
            </tr>
            
            <tr class = productRowBottom></tr>
            <?php endforeach ?>
        </table>
    
    <div class = totalPriceArea>
            <p id = totalItems>Total Items: <?= $totalItems ?></p>
            <button class = "removeBtn" data-post="deleteAll.php"><img src="/images/trash.png" alt="trash">Remove All</button>
        <p id = subTotal>Subtotal: RM<?= number_format($total,2) ?></p>
            <button id = "checkOutBtn" data-post = "checkout.php">Check Out</button>
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