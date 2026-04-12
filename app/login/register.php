<?php
include '../_base.php';
$_title = 'Register';
include '../_head.php';

// ----------------------------------------------------------------------------

if (is_post()) {
    $name     = req('username');
    $phone    = req('phone');
    $email    = req('email');
    $password = req('password');
    $confirm  = req('confirm');
    $f = get_file('photo');

    // Validate: email
    if (!$email) {
        $_err['email'] = 'Required';
    }
    else if (strlen($email) > 100) {
        $_err['email'] = 'Maximum 100 characters';
    }
    else if (!is_email($email)) {
        $_err['email'] = 'Invalid email';
    }
    else if (!is_unique($email, 'member', 'email')) {
        $_err['email'] = 'Duplicated';
    }

    // Validate: password
    if (!$password) {
        $_err['password'] = 'Required';
    }
    else if (strlen($password) < 5 || strlen($password) > 100) {
        $_err['password'] = 'Between 5-100 characters';
    }

    // Validate: confirm
    if (!$confirm) {
        $_err['confirm'] = 'Required';
    }
    else if (strlen($confirm) < 5 || strlen($confirm) > 100) {
        $_err['confirm'] = 'Between 5-100 characters';
    }
    else if ($confirm != $password) {
        $_err['confirm'] = 'Not matched';
    }

    // Validate: name
    if (!$name) {
        $_err['name'] = 'Required';
    }
    else if (strlen($name) > 100) {
        $_err['name'] = 'Maximum 100 characters';
    }

    // Validate: phone
    if (!$phone) {
        $_err['phone'] = 'Required';
    }
    else if (strlen($phone) > 11) {
        $_err['phone'] = 'Maximum 11 characters';
    }

    // Validate: photo (file)
    if (!$f) {
        $_err['photo'] = 'Required';
    }
    else if (!str_starts_with($f->type, 'image/')) {
        $_err['photo'] = 'Must be image';
    }
    else if ($f->size > 1 * 1024 * 1024) {
        $_err['photo'] = 'Maximum 1MB';
    }
    $_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // DB operation
    try{
    if (!$_err) {
        // (1) Save photo
        $photo = save_photo($f, '/images/user');
        
        // (2) Insert user (member)
        $stm = $_db->prepare('
            INSERT INTO member (name, email, password, phone_number, image_url)
            VALUES (?, ?, SHA1(?), ?, ?)
        ');
        $stm->execute([$name, $email, $password, $phone, $photo]);

        temp('info', 'Record inserted');
        redirect('/login/login.php');
    }
    }catch(PDOException $e){
        die($e->getMessage());
    }
}

// ----------------------------------------------------------------------------
?>

<style>
    .form{
        background: white;
        padding: 40px;
        border-radius: 8px;
        box-shadow: 0 4px 12px #ff8da1  ;
        width: 380px;

        margin-left: auto;
        margin-right: auto;
        margin-top: 60px; 
        margin-bottom: 60px;

        display: block;
        text-align: center;
    }

    .form input {
        text-align: center;
        width: 100%;
        box-sizing: border-box;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ff8da1;
        border-radius: 4px;
        display: block;
    }

    .form label {
        display: block;
        color : #000000;
        background-color: transparent;
        font-weight: bold;
        margin-top: 10px;
        margin-bottom: 5px;
        text-align: center;
    }

    .form input:focus {
    border: 2px solid #ffb6c1 !important;
    outline: none !important;
    box-shadow: 0 0 8px rgba(255, 182, 193, 0.5);
    }

    .form input[type="file"] {
        display: none !important;
    }

    .form .upload {
        display: inline-block;
        margin: 10px auto;
        cursor: pointer;
    }

    .form .upload img {
        width: 120px;
        height: 120px;
        border-radius: 4px !important;
        object-fit: cover;
        border: 2px solid #ffb6c1;
        display: block;
    }

    .form section {
        display: flex;
        width: 100%;
        gap: 10px;
        margin-top: 20px;
    }

    .form button {
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

    .form button:hover {
        background-color: #ff8da1;
    }

    .err { 
        color: red; 
        font-size: 12px; 
        display: block; 
        text-align: center; 
        width: 100%;
        margin-bottom: 5px;
    }

</style>

<form method="post" class="form" enctype="multipart/form-data">
    <label for="username">Name</label>
    <?= html_text('username', '', 'maxlength="100"') ?>
    <?= err('name') ?>

    <label for="phone">Phone</label>
    <?= html_text('phone', '', 'maxlength="11"') ?>
    <?= err('phone') ?>

    <label for="email">Email</label>
    <?= html_text('email',"", 'maxlength="254"') ?>
    <?= err('email') ?>

    <label for="password">Password</label>
    <?= html_password('password', '') ?>
    <?= err('password') ?>

    <label for="confirm">Confirm</label>
    <?= html_password('confirm', '') ?>
    <?= err('confirm') ?>

    <label for="photo">Profile Picture</label>
    <label class="upload" tabindex="0">
        <?= html_file('photo', 'image/*', 'hidden') ?>
        <img src="/images/photo.jpg">
    </label>
    <?= err('photo') ?>

    <section>
        <button>Submit</button>
        <button type="reset">Reset</button>
    </section>
</form>





<?php 
?>
