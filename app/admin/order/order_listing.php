<?php
    include '../../_base.php';
    include '../_head.php';

  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $order_id   = $_POST['order_id'];
    $old_status = $_POST['old_status'];
    $new_status = $_POST['new_status'];

    if ($old_status != $new_status) {
        $active_states = ['Shipped', 'Completed'];

        // 1. Get the items from order_details
        // NOTE: Check if your column is named 'quantity' or 'qty' in order_details
        $stmt = $_db->prepare("SELECT product_id, quantity FROM order_details WHERE order_id = ?");
        $stmt->execute([$order_id]);
        $items = $stmt->fetchAll();

        foreach ($items as $item) {
            // Case: Pending -> Shipped/Completed (Minus from stock_quantity)
            if ($old_status == 'Pending' && in_array($new_status, $active_states)) {
                $upd = $_db->prepare("UPDATE product SET stock_quantity = stock_quantity - ? WHERE product_id = ?");
                $upd->execute([$item->quantity, $item->product_id]);
            } 
            // Case: Shipped/Completed -> Pending (Add back to stock_quantity)
            elseif (in_array($old_status, $active_states) && $new_status == 'Pending') {
                $upd = $_db->prepare("UPDATE product SET stock_quantity = stock_quantity + ? WHERE product_id = ?");
                $upd->execute([$item->quantity, $item->product_id]);
            }
        }

        // 2. Update the status in the invoice table
        $stmt = $_db->prepare("UPDATE invoice SET status = ? WHERE order_id = ?");
        $stmt->execute([$new_status, $order_id]);

        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

// Fetch data for the table
$stm = $_db->prepare('SELECT i.*, m.name, m.member_id FROM invoice i JOIN member m ON i.member_id = m.member_id');
$stm->execute();
$orders = $stm->fetchAll();
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
    .status-form { 
        margin-top: 10px; 
        display: flex; 
        align-items: center; 
        gap: 5px; 
    }
    .status-select { 
        font-size: 14pt; 
        padding: 5px; 
        border: 1px solid #FF5E7E; 
        color: #FF5E7E; 
        border-radius: 5px; 
    }
    .update-btn { 
        background-color: #FF5E7E; 
        color: white; 
        border: none; 
        padding: 5px 15px; 
        border-radius: 5px; 
        font-size: 12pt; 
        cursor: pointer; 
        text-decoration: none !important; 
    }
    .update-btn:hover { 
        background-color: #e04d6a; 
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
                <td class = productDetails><strong>Order #<?= $o->order_id." ". $o->order_date ?></strong><br>Member Name:<?= $o->name ?></td>
                <td></td>
                <td id = "viewDetailBtn"><button data-post="order_detail.php?order_id=<?= $o->order_id ?>">View Details</button></td>
            </tr>
            
            <tr class = productRowMiddle>
                <td id = "orderAddress"><span>Shipping Address:</span><br><?= $o->street_address . ', ' . $o->city . ', ' . $o->state . ' ' . $o->post_code;?></td>
                <td class = productPrice>RM <?= number_format($o->total_amount,2) ?> 
                    <form method="POST" class="status-form">
                        <input type="hidden" name="order_id" value="<?= $o->order_id ?>">
                        <input type="hidden" name="old_status" value="<?= $o->status ?>">
                        
                        <select name="new_status" class="status-select">
                            <option value="Pending" <?= $o->status == 'Pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="Shipped" <?= $o->status == 'Shipped' ? 'selected' : '' ?>>Shipped</option>
                            <option value="Completed" <?= $o->status == 'Completed' ? 'selected' : '' ?>>Completed</option>
                        </select>
                        
                        <button type="submit" name="update_status" class="update-btn">Update</button>
                    </form>
                </td>
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