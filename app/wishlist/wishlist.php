<?php
    include '../_base.php';
    $_title = 'Wishlist';
    auth();
    include '../_head.php';

    
    $wishlist_id = get_wishlist();

    $stm = $_db->prepare('SELECT p.*, wp.* FROM wishlist_product wp JOIN product p ON wp.Product_ID = p.Product_ID WHERE wp.wishlist_id = ?');    
    $stm->execute([$wishlist_id]);
    $products = $stm->fetchAll();
    $product_image = [];
    foreach($products as $p){
            $stm = $_db->prepare('SELECT * FROM product_image WHERE product_id = ?');
            $stm->execute([$p->Product_ID]);
            $image = $stm->fetchAll();
            $product_image[$p->Product_ID] = $image;
        } 

    if (is_post()){
        $product_id = req('Product_ID');
        $cart_id = get_cart();   
            //this is for checking if the product exists in the member's cart
        $stm = $_db->prepare('SELECT * FROM cart_product WHERE Product_ID = ? AND Cart_ID = ? ');
        $stm->execute([$product_id,$cart_id]);
        $exists = $stm->fetch();

        if($exists){
            //update existing product
            $stm = $_db->prepare('UPDATE cart_product SET Quantity = Quantity + 1 WHERE Product_ID = ? AND Cart_ID = ?');
            $stm->execute([$product_id,$cart_id]);
            }else{
                 //insert new product
                $stm = $_db->prepare('INSERT INTO cart_product (Product_ID, Cart_ID,Quantity) VALUES (?,?,1)');
                $stm->execute([$product_id,$cart_id]);
            }
            temp('info', 'Product successfully added to cart!');
            redirect();
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
            margin-right:5px;
        }

        main > :first-child{
            display: none;
        }
        .productDetails{
            font-size:14pt;
        }
    </style>
    <h2>Wishlist</h2>
    <?php if($products): ?>
        <table>
            <?php foreach($products as $p): ?>        
            <tr class = productRowTop>
                <td rowspan = "3"><a><img id = productImage src = <?= $product_image[$p->Product_ID][0]->Image_URL ?> alt = <?= $product_image[$p->Product_ID][0]->Alt_Text ?>></a></td>
                <td class = productDetails><b><?= $p->Name ?></b><br><span id="productCategory"><?= $p->Brand." ".$p->Scale." ".$p->Series ?></span></td>
                <td></td>
                <td class = removeBtn><button data-post="delete.php?product_id=<?=$p->Product_ID?>"><img src = "/images/trash.png" alt = "trash">Remove</button></td>
            </tr>
            <tr class = productRowMiddle>
                <td class = productPrice>RM <?= number_format($p->Price,2) ?></td>
                <td id = "productQuantity">Status:</td>
                <td id = "quantityValue"><?= $p->Status ?></td>
                
            </tr>
            <tr class = productRowBottom>
                <td></td>
                <td></td>
                <td class = "cartBtn"><button data-post="?Product_ID=<?= $p->Product_ID ?>"><img src = "/images/cart.png" alt = "cart">Add Cart</button></td>
            </tr>
            <?php endforeach ?>
        </table>
    
    <div class = totalPriceArea>
            <button class = "removeBtn" data-post="deleteAll.php"><img src="/images/trash.png" alt="trash">Remove All</button>
    </div>
    <?php else: ?>
    <p id = "emptyCart">Your wishlist is currently empty.</p>
    <?php endif ?>
    
    
<?php
    include '../_foot.php';
?>