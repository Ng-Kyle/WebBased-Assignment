<?php
$title = 'Reset Password';
include '../_base.php';
include '../_head.php';
// ----------------------------------------------------------------------------

// TODO: (1) Delete expired tokens
$_db->query('DELETE FROM token WHERE expire < NOW()');

$id = req('id'); //this form url

// TODO: (2) Is token id valid?
if (!is_exists($id, 'token', 'id')) { // check form data base
    temp('info', 'Invalid token. Try again');
    redirect('/');
}

if (is_post()) {
    $password = req('password');
    $confirm  = req('confirm');

    // Validate: password
    if ($password == '') {
        $_err['password'] = 'Required';
    }
    else if (strlen($password) < 5 || strlen($password) > 100) {
        $_err['password'] = 'Between 5-100 characters';
    }

    // Validate: confirm
    if ($confirm == '') {
        $_err['confirm'] = 'Required';
    }
    else if (strlen($confirm) < 5 || strlen($confirm) > 100) {
        $_err['confirm'] = 'Between 5-100 characters';
    }
    else if ($confirm != $password) {
        $_err['confirm'] = 'Not matched';
    }

    // DB operation
    if (!$_err) {
        // TODO: Update user (password) based on token id + delete token
        $stm = $_db->prepare('
            UPDATE member
            SET password = SHA1(?)
            WHERE member_ID = (SELECT member_id FROM token WHERE id = ?);

            DELETE FROM token WHERE id = ?;
        ');
        $stm->execute([$password, $id, $id]);

        temp('info', 'Record updated');
        redirect('/login/login.php');
    }
}

// ----------------------------------------------------------------------------


?>

<style>
    html, body {
        height: 100vh;
        margin: 0;
        overflow: hidden; 
    }

    .form {
        background: white;
        padding: 40px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        width: 380px;

        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);

        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .form label {
        display: block;
        width: 100%;
        font-weight: bold;
        margin-top: 15px;
        margin-bottom: 5px;
        background: none !important;
        color: #333 !important;
    }

    .form input {
        text-align: center;
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .form input:focus {
        border: 2px solid #ffb6c1 !important;
        outline: none !important;
        box-shadow: 0 0 8px rgba(255, 182, 193, 0.5);
    }

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
        color: b;
        font-size: 16px;
    }

    button:hover {
        background-color: #ff8da1;
    }

    .err { color: red; font-size: 12px; margin-top: 5px; }
</style>

<form method="post" class="form">
    <label for="password">Password</label>
    <?= html_password('password', 'maxlength="100"') ?>
    <?= err('password') ?>

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