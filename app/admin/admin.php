<?php
    include '../_base.php';
    $_title = 'Admin Login';
    include '_head.php';

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
                SELECT * FROM admin
                WHERE Email = ? AND Password = SHA1(?)
            ');
            $stm->execute([$email, $password]);
            $u = $stm->fetch();

            if (!$u) {
                $_err['password'] = 'Not matched';
            }
            $u->role = 'admin';
            temp('info', 'Login successfully');
            login($u,'member_list.php');
        }
    }
?>

<div class = adminPage>
    <form method="post" class="adminElement">
        <label for="email" >Email</label>
        <?= html_text('email',"", 'maxlength="100"') ?>
        <?= err('email') ?>

        <label for="password">Password</label>
        <?= html_password('password', '',) ?>
        <?= err('password') ?>

        <section method="post" class="adminButton">
            <button>Login</button>
        </section>
    </form>
</div>

<?php
    include '../_foot.php';
?>