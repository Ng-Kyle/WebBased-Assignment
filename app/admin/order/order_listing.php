<?php
    include '../../_base.php';
    $_title = 'Order Listing';
    auth('admin');
    include '../_head.php';

    
    if (is_post() && post('update_status') !== null) {
        $order_id   = post('order_id');
        $old_status = post('old_status');
        $new_status = post('new_status');

        
        if ($old_status != $new_status) {
            $active_states = ['Shipping', 'Completed'];

           
            $stmt = $_db->prepare("SELECT product_id, quantity FROM order_details WHERE order_id = ?");
            $stmt->execute([$order_id]);
            $items = $stmt->fetchAll();

            foreach ($items as $item) {
                
                if ($old_status == 'Preparing' && in_array($new_status, $active_states)) {
                    $upd = $_db->prepare("UPDATE product SET stock_quantity = stock_quantity - ? WHERE product_id = ?");
                    $upd->execute([$item->quantity, $item->product_id]);
                } 
                
                elseif (in_array($old_status, $active_states) && $new_status == 'Preparing') {
                    $upd = $_db->prepare("UPDATE product SET stock_quantity = stock_quantity + ? WHERE product_id = ?");
                    $upd->execute([$item->quantity, $item->product_id]);
                }
            }

            
            $stmt = $_db->prepare("UPDATE invoice SET status = ? WHERE order_id = ?");
            $stmt->execute([$new_status, $order_id]);

            
            redirect($_SERVER['PHP_SELF']); 
        }
    }

   
    $stm = $_db->prepare('SELECT i.*, m.name, m.member_id FROM invoice i JOIN member m ON i.member_id = m.member_id');
    $stm->execute();
    $orders = $stm->fetchAll();
?>

<style>
    .pageTitle{
        display:none;
    }
</style>
<div class = "orderListPage">
    <h2>Order Listing</h2>
    <?php if($orders): ?>
        <table>
            <?php foreach($orders as $o): ?>
                <tr class = orderListProductRowTop>
                    <td class = orderListProductDetails><strong>Order #<?= $o->order_id." ". $o->order_date ?></strong><br>Member Name:<?= $o->name ?></td>
                    <td></td>
                    <td class = "viewDetailBtn"><button data-post="order_detail.php?order_id=<?= $o->order_id ?>">View Details</button></td>
                </tr>
                <tr class = orderListProductRowMiddle>
                    <td class = "orderListAddress"><span>Shipping Address:</span><br><?= $o->street_address . ', <br>' . $o->city . ', ' . $o->state . ' ' . $o->post_code;?></td>
                    <td class = orderListPrice>
                        RM <?= number_format($o->total_amount,2) ?>
                        <form method="POST" class="status-form">
                            <input type="hidden" name="order_id" value="<?= $o->order_id ?>">
                            <input type="hidden" name="old_status" value="<?= $o->status ?>">
                            <select name="new_status" class="status-select">
                                <option value="Preparing" <?= $o->status == 'Preparing' ? 'selected' : '' ?>>Preparing</option>
                                <option value="Shipped" <?= $o->status == 'Shipped' ? 'selected' : '' ?>>Shipped</option>
                                <option value="Completed" <?= $o->status == 'Completed' ? 'selected' : '' ?>>Completed</option>
                            </select>
                            <button type="submit" name="update_status" class="update-btn">Update</button>
                        </form>
                    </td>
                    <td class = "orderListStatus">Status: <?= $o->status ?></td>  
                </tr>
                <tr class = orderListProductRowBottom></tr>
            <?php endforeach ?>
        </table>
    <?php else: ?>
        <p class = "orderListEmpty">You have no previous orders!</p>
    <?php endif ?>
</div>

<?php include '../../_foot.php'; ?>