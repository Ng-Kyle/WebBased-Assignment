<?php
    include '../_base.php';
    $_title = 'Shopping Cart';
    include '../_head.php';
    $stm = $_db->prepare('SELECT p.*, cp.* FROM cart_product cp JOIN product p ON cp.Product_ID = p.Product_ID WHERE cp.Cart_ID = 1');    
    $stm->execute();
    $products = $stm->fetchAll();
    $product_image = [];
    foreach($products as $p){
            $total+=$p->Price;
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
        img{
            width: 150px;
            height: 150px;
        }
        .productRowTop{
            border-top: 3px solid gray;
        }
        .productRowMiddle{
            vertical-align: top;
        }
        .productRowBottom{
            border-bottom: 3px solid gray;
        }
        .productName{
            width: 90%;
        }
        
        table{
            border-collapse: collapse; 
        }
        h2{
            text-align:center;
            font-size: 35px;
        }
        .removeBtn{
            text-align: right;
            color:red;
            outline:5px black;
        }
        .totalPriceArea{
            text-align: right;
        }
        #totalItems{
            font-size:20px;
        }
        #subTotal{
            font-size:30px;
        }
        #emptyCart{
            text-align:center;
            padding-top: 30px;
            padding-bottom:180px;
        }
    </style>
    <h2>Cart</h2>
    <?php if($products): ?>
    <form>
        <table>
            <?php foreach($products as $p): ?>        
            <tr class = productRowTop>
                <td rowspan = "3"><a><img src = <?= $product_image[$p->Product_ID][0]->Image_URL ?> alt = <?= $product_image[$p->Product_ID][0]->Alt_Text ?>></a></td>
                <td class = productName><?= $p->Name ?></td>
                <td class = removeBtn><button data-post="delete.php?cart_id=<?=$p->Cart_ID?>&product_id=<?=$p->Product_ID?>">Remove</button></td>
            </tr>
            <tr class = productRowMiddle>
                <td class = productPrice>RM <?= number_format($p->Price,2) ?></td>
                <td><?= $p->Quantity ?></td>
            </tr>
            <tr class = productRowBottom></tr>
            <?php endforeach ?>
        </table>
    </form>
    <div class = totalPriceArea>
        <form>
            <p id = totalItems>Total Items: <?= count($products) ?><button data-post="deleteAll.php?cart_id=<?=$cart_id->Cart_ID?>">Remove All</button></p>
        </form>
        <p id = subTotal>Subtotal: RM<?= number_format($total,2) ?></p>
        <form>
            <button data-post = "checkout.php?cart_id=<?=$cart_id->Cart_ID?>">Check Out</button></form>
    </div>
    <?php else: ?>
    <p id = "emptyCart">Your cart is empty</p>
    <?php endif ?>
    

    
<?php
    include '../_foot.php';
?>