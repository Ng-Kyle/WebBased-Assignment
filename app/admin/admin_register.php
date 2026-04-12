<?php
include '../_base.php';
$_title = 'Admin Register';
auth();
include '../_head.php';

// ----------------------------------------------------------------------------


if (is_post()) {
    $name     = req('username');
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

   
    $_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // DB operation
    try{
    if (!$_err) {

        // (1) Insert user (admin)
        $stm = $_db->prepare('
            INSERT INTO admin (name, email, password)
            VALUES (?, ?, SHA1(?))
        ');
        $stm->execute([$name, $email, $password]);

        temp('info', 'Record inserted');
        redirect('/admin/admin.php');
    }
    }catch(PDOException $e){
        die($e->getMessage());
    }
}

?>


<form method="post" class="form" enctype="multipart/form-data">
    <label for="username">Name</label>
    <?= html_text('username', '', 'maxlength="100"') ?>
    <?= err('name') ?>

     <label for="email">Email</label>
    <?= html_text('email',"", 'maxlength="254"') ?>
    <?= err('email') ?>

    <label for="password">Password</label>
    <?= html_password('password', '') ?>
    <?= err('password') ?>

   
    <label for="confirm">Confirm</label>
    <?= html_password('confirm', '') ?>
    <?= err('confirm') ?>

    <section>
        <button>Submit</button>
        <button type="reset">Reset</button>
    </section>
</form>





<?php
?>