<?php
include '../_base.php';
$_title = 'Profile';
include '../_head.php';

// ----------------------------------------------------------------------------

// Authenticated users
auth('member');

if (is_get()) {
    $stm = $_db->prepare('SELECT * FROM member WHERE member_id = ?');
    $stm->execute([$_user->member_id]);
    $u = $stm->fetch();

    if (!$u) {
        redirect('/');
    }

    extract((array)$u);
    $_SESSION['image_url'] = $u->image_url;
}

if (is_post()) {
    $email = req('email');
    $name  = req('name');
    $phone = req('phone');
    $photo = $_SESSION['image_url'];
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
            WHERE email = ? AND member_id != ?
        ');
        $stm->execute([$email, $_user->member_id]);

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
    // Validate: phone
    if ($phone == '') {
        $_err['phone'] = 'Required';
    }
     else if (!preg_match ('/^\d{10,11}$/', $phone)) {
        $_err['phone'] = 'Invalid phone number';
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
            $photo = save_photo($f, '../images/user','/images/user');
        }
        
        // (2) Update user (email, name, phone, photo)
        $stm = $_db->prepare('
            UPDATE member
            SET email = ?, name = ?, phone_number = ?, image_url = ?
            WHERE member_id = ?
        ');
        $stm->execute([$email, $name, $phone, $photo, $_user->member_id]);

        // (3) Update global user object
        $_user->email = $email;
        $_user->name  = $name;
        $_user->phone_number = $phone;
        $_user->image_url= $photo;

        temp('info', 'Record updated');
        redirect('/');
    }
}
 try{
    $stm = $_db->prepare('SELECT * FROM invoice WHERE member_id = ?');
    $stm->execute([$_user->member_id]);
    $orders = $stm->fetchAll();
    }
    catch(PDOException $e){
        die($e->getMessage());
    }
// ----------------------------------------------------------------------------

?>
<style>
    /* 1. Page Layout - Allow scrolling on this page since Order History can be long */
    html, body {
        height: auto;
        min-height: 100%;
        margin: 0;
        background-color: #fff;
    }

    /* 2. Profile Card Styling (Matches Login/Register) */
    form.form {
        background: white;
        padding: 40px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        width: 380px;
        
        /* Centering the card */
        margin: 60px auto !important;
        
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    /* 3. Clean Labels & Inputs */
    form.form label {
        display: block;
        width: 100%;
        font-weight: bold;
        margin-top: 15px;
        margin-bottom: 5px;
        background: none !important; /* Removes those grey blocks */
        color: #333 !important;
        text-align: center;
    }

    form.form input {
        text-align: center;
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    form.form input:focus {
        border: 2px solid #ffb6c1 !important;
        outline: none !important;
        box-shadow: 0 0 8px rgba(255, 182, 193, 0.5);
    }

    /* 4. Square Photo Fix */
    form.form .upload img {
        width: 120px;
        height: 120px;
        border-radius: 4px !important; /* Square with slight roundness */
        object-fit: cover;
        border: 2px solid #ffb6c1;
        display: block;
        margin: 10px auto;
    }

    form.form input[type="file"] {
        display: none !important; /* Hides "Choose File" */
    }

    /* 5. Buttons Row */
    form.form section {
        display: flex;
        width: 100%;
        gap: 10px;
        margin-top: 20px;
        justify-content: center;
    }

    form.form button {
        flex: 1;
        padding: 12px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: bold;
        background-color: #ffb6c1;
        color: black;
        font-size: 16px;
    }

    /* 6. Update Password Link */
    form.form a {
        color: #FF5E7E;
        text-decoration: underline;
        font-size: 14px;
        margin-bottom: 10px;
    }
</style>

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
            padding-right:40px;
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
        }
</style>

<form method="post" class="form" enctype="multipart/form-data">
    <label class="upload" tabindex="0">
        <?= html_file('photo', 'image/*', 'hidden') ?>
        <img src="../<?= $_user->image_url ?> ">
    </label>
    <?= err('photo') ?>

    <label for="name">Name</label>
    <?= html_text('name', $_user->name, 'maxlength="100"') ?>
    <?= err('name') ?>

    <label for="email">Email</label>
    <?= html_text('email', $_user->email, 'maxlength="100"') ?>
    <?= err('email') ?>

    <label for="phone">Phone</label>
    <?= html_text('phone', $_user->phone_number, 'maxlength="11"') ?>
    <?= err('phone') ?>

    <section>
            <a href="password.php">Update your password?</a>
    </section>


    <section>
        <button>Update Profile</button>
        <button type="reset">Reset</button>
    </section>

</form>
<div class = "orderhistory">
<h2>Order History</h2>
    <?php if($orders): ?>
        <table>
            <?php foreach($orders as $o): ?>       
            <tr class = productRowTop>
                <td class = productDetails><b>Order #<?= $o->order_id." ". $o->order_date ?></b></td>
                <td></td>
                <td id = "viewDetailBtn"><button data-post="order_detail.php?order_id=<?= $o->order_id ?>">View Details</button></td>
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

<script>
document.addEventListener('click', function (e) {
    // Check if the clicked element is the Logout link
    if (e.target.closest('a[href*="logout.php"]')) {
        const confirmed = confirm("Are you sure you want to log out?");
        
        if (!confirmed) {
            e.preventDefault(); // Stops the logout if they click 'Cancel'
        }
    }
});
</script>


<?php
include '../_foot.php';