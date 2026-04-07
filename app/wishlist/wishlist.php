<?php
    include '../_base.php';
    $_title = 'Shopping Wishlist';
    include '../_head.php';
    $stm = $_db->prepare('SELECT p.*, wp.* FROM wishlist_product wp JOIN product p ON wp.Product_ID = p.Product_ID WHERE wp.Wishlist_ID = 1');
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
    $stm = $_db->prepare('SELECT * FROM wishlist WHERE wishlist_ID = 1');
    $stm->execute();
    $wishlist = $stm->fetch();
    
    
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
        .productPrice{
            width: 90%;
        }
        .productStatus{
            text-align: right;
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
        #emptyWishlist{
            text-align:center;
            padding-top: 30px;
            padding-bottom:180px;
        }
        #addCartBtn{
            text-align: right;
            white-space: nowrap;
        }
    </style>
    <h2>Wishlist</h2>
    <?php if($products): ?>
    <form>
        <table>
            <?php foreach($products as $p): ?>        
            <tr class = productRowTop>
                <td rowspan = "3"><a><img src = <?= $product_image[$p->Product_ID][0]->Image_URL ?> alt = <?= $product_image[$p->Product_ID][0]->Alt_Text ?>></a></td>
                <td class = productName><?= $p->Name ?></td>
                <?php if($p->Status == "Available" && $p->Stock_Quantity != 0):?>
                    <td id = "addCartBtn"><button>Add cart</button></td> <!-- Link to addcart.php later on -->
                <?php else: ?>
                    <td id = "addCartBtn"><button disabled>Add cart</button></td>
                <?php endif ?>
                <td class = removeBtn><button data-post="delete.php?wishlist_id=<?=$p->Wishlist_ID?>&product_id=<?=$p->Product_ID?>">Remove</button></td>
            </tr>
            <tr class = productRowMiddle>
                <td class = productPrice>RM <?= number_format($p->Price,2) ?></td>
                <td class = productStatus colspan = "2"><?= $p->Status ?></td>
            </tr>
            <tr class = productRowBottom></tr>
            <?php endforeach ?>
        </table>
    </form>
    <div class = totalPriceArea>
        <form>
            <p id = totalItems>Total Items: <?= count($products) ?><button data-post="deleteAll.php?wishlist_id=<?=$wishlist->Wishlist_ID?>">Remove All</button></p>
        </form>
    </div>
    <?php else: ?>
    <p id = "emptyWishlist">Your Wishlist is empty</p>
    <?php endif ?>
    

    
<?php
    include '../_foot.php';
?>