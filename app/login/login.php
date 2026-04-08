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
            SELECT * FROM user
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

$_title = 'Login';
?>

<form method="post" class="form">
    <label for="email">Email</label>
    <?= html_text('email', '') ?>
    <?= err('email') ?>

    <label for="password">Password</label>
    <?= html_password('password', '') ?>
    <?= err('password') ?>

    <section>
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

<?php
