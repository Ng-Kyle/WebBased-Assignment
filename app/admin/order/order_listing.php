<?php
    include '../../_base.php';
    $stm = $_db->prepare('SELECT * FROM invoice WHERE member_id = ?');
    $stm->execute([$_user->member_id]);
    $orders = $stm->fetchAll();
    include '../_head.php';
?>
<style>
    .productRowTop{
        border-top: 3px solid pink;
    }
    .productRowMiddle{
        vertical-align: top;
        font-size:20pt;
        font-weight: bold;
        color: #FF5E7E;
        white-space:nowrap;
        padding-right:25px;
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
    button:hover{
        cursor:pointer
    }
    #emptyCart{
        text-align:center;
        padding-top: 30px;
        padding-bottom:180px;
        font-size:25pt;
        font-weight:bold;
    }
    .productPrice{
        font-size:20pt;
        white-space: nowrap;
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
        white-space:nowrap;
        padding-right:25px;
    }
    .productDetails{
        font-size:20pt;
        
    }
    #orderAddress{
        font-size:20pt;
    }
    #viewDetailBtn{
        text-align:right;
        
    }
    button{
        border: none;
        background-color: white;
        color:#FF5E7E;
        font-size: 15pt;
        font-weight: bold;
        text-decoration: underline 2pt;
    }
    main > h1 {
        display:none;
    }
</style>

<div class = "orderhistory">
<h2>Order Listing</h2>
    <?php if($orders): ?>
        <table>
            <?php foreach($orders as $o): ?>
            <tr class = productRowTop>
                <td class = productDetails><b>Order #<?= $o->order_id." ". $o->order_date ?></b></td>
                <td></td>
                <td id = "viewDetailBtn"><button data-post="../../user/order_detail.php?order_id=<?= $o->order_id ?>">View Details</button></td>
            </tr>
            
            <tr class = productRowMiddle>
                <td id = "orderAddress"><span>Shipping Address:</span><br><?= $o->street_address . ', ' . $o->city . ', ' . $o->state . ' ' . $o->post_code;?></td>
                <td class = productPrice>RM <?= number_format($o->total_amount,2) ?></td>
                <td id = "productQuantity">Status: <?= $o->status ?></td>  
            </tr>
            <tr class = productRowBottom></tr>
            <?php endforeach ?>
        </table>
    <?php else: ?>
        <p id = "emptyCart">You have no previous orders!</p>
    <?php endif ?>
</div>

<?php
include '../../_foot.php';
?>