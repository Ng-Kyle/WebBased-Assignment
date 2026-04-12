<?php
include '../_base.php';
$_title = 'User | Password';
include '../_head.php';
// ----------------------------------------------------------------------------

// Authenticated users
auth('member');

if (is_post()) {
    $password     = req('password');
    $new_password = req('new_password');
    $confirm      = req('confirm');

    // Validate: password
    if ($password == '') {
        $_err['password'] = 'Required';
    }
    else if (strlen($password) < 5 || strlen($password) > 100) {
        $_err['password'] = 'Between 5-100 characters';
    }
    else {
        $stm = $_db->prepare('
            SELECT COUNT(*) FROM member
            WHERE password = SHA1(?) AND id = ?
        ');
        $stm->execute([$password, $_user->member_id]);
        
        if ($stm->fetchColumn() == 0) {
            $_err['password'] = 'Not matched';
        }
    }

    // Validate: new_password
    if ($new_password == '') {
        $_err['new_password'] = 'Required';
    }
    else if (strlen($new_password) < 5 || strlen($new_password) > 100) {
        $_err['new_password'] = 'Between 5-100 characters';
    }

    // Validate: confirm
    if (!$confirm) {
        $_err['confirm'] = 'Required';
    }
    else if (strlen($confirm) < 5 || strlen($confirm) > 100) {
        $_err['confirm'] = 'Between 5-100 characters';
    }
    else if ($confirm != $new_password) {
        $_err['confirm'] = 'Not matched';
    }

    // DB operation
    if (!$_err) {
        // Update user (password)
        $stm = $_db->prepare('
            UPDATE member
            SET password = SHA1(?)
            WHERE id = ?
        ');
        $stm->execute([$new_password, $_user->member_id]);

        temp('info', 'Record updated');
        redirect('/');
    }
}

// ----------------------------------------------------------------------------

$_title = 'User | Password';
?>
<style>
    /* 1. Prevent scroll and set up the layout */
    html, body {
        height: 100vh;
        margin: 0;
        overflow: hidden; /* Stops scrolling */
    }

    /* 2. Style the form card */
    .form {
        background: white;
        padding: 40px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        width: 380px;

        /* Force center horizontally and vertically */
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);

        /* Stack items vertically */
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    /* 3. Fix Labels (Removes the grey blocks) */
    .form label {
        display: block;
        width: 100%;
        font-weight: bold;
        margin-top: 15px;
        margin-bottom: 5px;
        background: none !important;
        color: #333 !important;
    }

    /* 4. Fix Inputs */
    .form input {
        text-align: center;
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box; /* Stops them from shrinking/stretching weirdly */
    }

    .form input:focus {
        border: 2px solid #ffb6c1 !important;
        outline: none !important;
        box-shadow: 0 0 8px rgba(255, 182, 193, 0.5);
    }

    /* 5. Fix Buttons */
    .form section {
        display: flex;
        width: 100%;
        gap: 10px;
        margin-top: 25px;
    }

    button {
        flex: 1;
        padding: 12px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: bold;
        background-color: #ffb6c1;
        color: white;
        font-size: 16px;
    }

    button[type="reset"] {
        background-color: #ddd;
        color: #333;
    }

    /* 6. Fix Errors */
    .err {
        color: red;
        font-size: 12px;
        display: block;
        margin-top: 5px;
    }
</style>

<form method="post" class="form">
    <label for="password">Password</label>
    <?= html_password('password', 'maxlength="100"') ?>
    <?= err('password') ?>

    <label for="new_password">New Password</label>
    <?= html_password('new_password', 'maxlength="100"') ?>
    <?= err('new_password') ?>

    <label for="confirm">Confirm</label>
    <?= html_password('confirm', 'maxlength="100"') ?>
    <?= err('confirm') ?>

    <section>
        <button>Submit</button>
        <button type="reset">Reset</button>
    </section>
</form>

<?php
include '../_foot.php';