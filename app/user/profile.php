<?php
include '../_base.php';
include '../_head.php';

// ----------------------------------------------------------------------------

// Authenticated users
auth();

if (is_get()) {
    $stm = $_db->prepare('SELECT * FROM member WHERE Member_ID = ?');
    $stm->execute([$_user->Member_ID]);
    $u = $stm->fetch();

    if (!$u) {
        redirect('/');
    }

    extract((array)$u);
    $_SESSION['Image_URL'] = $u->Image_URL;
}

if (is_post()) {
    $email = req('email');
    $name  = req('name');
    $photo = $_SESSION['Image_URL'];
    $f = get_file('photo');

    // Validate: email
    if ($email == '') {
        $_err['email'] = 'Required';
    }
    else if (strlen($email) > 100) {
        $_err['email'] = 'Maximum 100 characters';
    }
    else if (!is_email($email)) {
        $_err['email'] = 'Invalid email';
    }
    else {
        $stm = $_db->prepare('
            SELECT COUNT(*) FROM member
            WHERE Email = ? AND Member_ID != ?
        ');
        $stm->execute([$email, $_user->Member_ID]);

        if ($stm->fetchColumn() > 0) {
            $_err['email'] = 'Duplicated';
        }
    }

    // Validate: name
    if ($name == '') {
        $_err['name'] = 'Required';
    }
    else if (strlen($name) > 100) {
        $_err['name'] = 'Maximum 100 characters';
    }

    // Validate: photo (file) --> optional
    if ($f) {
        if (!str_starts_with($f->type, 'image/')) {
            $_err['photo'] = 'Must be image';
        }
        else if ($f->size > 1 * 720 * 720) {
            $_err['photo'] = 'Maximum 1MB';
        }
    }

    // DB operation
    if (!$_err) {
        // (1) Delete and save photo --> optional
        if ($f) {
            unlink("../images/$photo");
            $photo = save_photo($f, '../images');
        }
        
        // (2) Update user (email, name, photo)
        $stm = $_db->prepare('
            UPDATE member
            SET Email = ?, Name = ?, Image_URL = , Password = ?
            WHERE Member_ID = ?
        ');
        $stm->execute([$email, $name, $photo, $password, $_user->Member_ID]);

        // (3) Update global user object
        $_user->Email = $email;
        $_user->Name  = $name;
        $_user->Image_URL = $photo;
        $_user->Password = $password;

        temp('info', 'Record updated');
        redirect('/');
    }
   
}
 try{
    $stm = $_db->prepare('SELECT * FROM invoice WHERE member_id = ?');
    $stm->execute([$_user->Member_ID]);
    $orders = $stm->fetchAll();
    }
    catch(PDOException $e){
        die($e->getMessage());
    }
// ----------------------------------------------------------------------------

$_title = 'User | Profile';
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
</style>

<form method="post" class="form" enctype="multipart/form-data">
    <label for="email">Email</label>
    <?= html_text('email', $_user->Email, 'maxlength="100"') ?>
    <?= err('email') ?>

    <label for="name">Name</label>
    <?= html_text('name', $_user->Name, 'maxlength="100"') ?>
    <?= err('name') ?>

    <label for="photo">Photo</label>
    <label class="upload" tabindex="0">
        <?= html_file('photo', 'image/*', 'hidden') ?>
        <img src="../<?= $_user->Image_URL ?> ">
    </label>
    <?= err('photo') ?>

    <section>
        <button>Submit</button>
        <button type="reset">Reset</button>
    </section>
</form>
<div class = "orderhistory">
<h2>Order History</h2>
    <?php if($orders): ?>
        <table>
            <?php foreach($orders as $o): ?>       
            <tr class = productRowTop>
                <td class = productDetails><b>Order #<?= $o->Order_ID." ". $o->Order_Date ?></b></td>
                <td></td>
                <td id = "viewDetailBtn"><button data-post="order_detail.php?order_id=<?= $o->Order_ID ?>">View Details</button></td>
            </tr>
            
            <tr class = productRowMiddle>
                <td id = "orderAddress"><span>Shipping Address:</span><br><?= $o->Street_Address . ', ' . $o->City . ', ' . $o->State . ' ' . $o->Post_Code;?></td>
                <td id = "productQuantity">Status: <?= $o->Status ?></td>                    
                <td class = productPrice>RM <?= number_format($o->Total_Amount,2) ?></td>
            </tr>
            <tr class = productRowBottom></tr>
            <?php endforeach ?>
        </table>
    <?php else: ?>
        <p>You have no previous orders!</p>
    <?php endif ?>
</div>
<?php
include '../_foot.php';