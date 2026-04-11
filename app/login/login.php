<?php
include '../_base.php';
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
            WHERE Email = ? AND Password = SHA1(?)
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

$_title = 'Login';
?>

<form method="post" class="element">
    <label for="email">Email</label>
    <?= html_text('email',"", 'maxlength="100"') ?>
    <?= err('email') ?>

    <label for="password">Password</label>
    <?= html_password('password', '',) ?>
    <?= err('password') ?>

    <section method="post" class="button">
        <button>Login</button>
        <button type="reset">Reset</button>
    </section>

    <section>
        <a href="register.php">Don't have an account?</a>
    </section>

    <section>
        <a href="reset.php">Forgot your password?</a>
    </section>


</form>

<style>
        /* Login */
    .element{
        display: grid;
        justify-content: center;
        align-items: center;
    }
    #email{
        border-radius: 12px;
        padding:5px;
    }
    #password{
        border-radius: 12px;
        padding:5px

    }
    .sumbit{
        border-radius: 12px;
        padding:5px
    }

    <!--Register-->
    #email{
        border-radius: 12px;
        padding: 5px;
        gap: 10px;
    }

    #f_password{
        border-radius: 12px;
        padding: 5px;
        gap: 10px;
    }

    #d_password{
        border-radius: 12px;
        padding: 5px;


    }
    .button{
        background-color: #ffffff;
        color: black;
        padding: 10px 20px;
        border-radius: 12px;
    }
    .sumbit{
        border-radius: 12px;
        padding:5px
    }
    .password_element{
        display: grid;
        justify-content: center;
        align-items: center;
    }

    .register_element{
        display: grid;
        justify-content: center;
        align-items: center;
    }
    #fc_password{
        border-radius: 12px;
        padding:5px;
    }
    .err{
        color: red;
    }
    #info {
        position: fixed;
        color: #fff;
        background: #666;
        border: 1px solid #333;
        border-radius: 5px;
        padding: 10px 20px;
        left: 50%;
        translate: -50% 0;
        z-index: 999;

        top: -100px;
        opacity: 0;
    }

    #info:not(:empty) {
        animation: fade 5s;
    }
</style>
<?php
