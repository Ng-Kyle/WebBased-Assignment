<?php
    include '../_base.php';
    $_title = 'Login';
    include '../_head.php';
    if ($_user){
        temp('info', "You're already logged in!");
        redirect('/');
    }

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
                $u->role = 'member';
                temp('info', "Login successfully, Welcome {$u->name}");
                login($u);
            }
            else {
                $_err['password'] = 'Not matched';
            }
        }
    }
?>


<form method="post" class="memberLogin">
    <label for="email" >Email</label>
    <?= html_text('email',"", 'maxlength="100"') ?>
    <?= err('email') ?>

    <label for="password">Password</label>
    <?= html_password('password', '',) ?>
    <?= err('password') ?>

    <section method="post" class="memberLoginButton">
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
    include '../_foot.php'
?>