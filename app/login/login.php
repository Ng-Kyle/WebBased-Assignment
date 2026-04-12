<?php
include '../_base.php';
$_title = 'Login';
include '../_head.php';


if (is_post()) {
    $email = req('email');
    $password = req('password');

    // Validate: email
    if ($email == '') {
        $_err['email'] = 'Required';
    }
    else if (!is_email($email)) {
        $_err['email'] = 'Invalid email';
    }

    // Validate: password
    if ($password == '') {
        $_err['password'] = 'Required';
    }

    // Login user
    if (!$_err) {
        $stm = $_db->prepare('
            SELECT * FROM member
            WHERE email = ? AND password = SHA1(?)
        ');
        $stm->execute([$email, $password]);
        $u = $stm->fetch();

        if ($u) {
            temp('info', 'Login successfully');
            login($u);
        }
        else {
            $_err['password'] = 'Not matched';
        }
    }
}
?>


<style>
    .element {
        background: white;
        padding: 40px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        width: 350px;

        margin-left: auto;
        margin-right: auto;
        margin-top: 80px; 
        margin-bottom: 80px;

        display: block;
        text-align: center;
    }

    .element input {
        text-align: center;
        width: 100%;
        box-sizing: border-box;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
        display: block;
    }

    .element label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
        text-align: center;
    }

    .button {
        display: block;
        width: 100%;
        margin-bottom: 15px;
    }

    .element button {
        width: 100%;
        padding: 12px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: bold;
        background-color: #ffb6c1;
        color: white;
        font-size: 16px;
    }

    .element button:hover {
        background-color: #ff8da1;
    }

    /* 5. Center links */
    .element section a {
        display: block;
        text-align: center;
        font-size: 14px;
        color: #FF5E7E;
        text-decoration: none;
        margin-top: 8px;
    }

    .err { color: red; font-size: 12px; display: block; text-align: center; }
</style>


<form method="post" class="element">
    <label for="email" >Email</label>
    <?= html_text('email',"", 'maxlength="100"') ?>
    <?= err('email') ?>

    <label for="password">Password</label>
    <?= html_password('password', '',) ?>
    <?= err('password') ?>

    <section method="post" class="button">
        <button>Login</button>

    </section>

    <section style="text-align: center;">
        Don't have an account? 
        <a href="register.php" style="display: inline; margin-left: 5px;">Register here</a>
    </section>

    <section>
        <a href="reset.php">Forgot your password?</a>
    </section>


</form>



<?php 
?>