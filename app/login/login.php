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
                temp('info', "Login successful, Welcome {$u->name}");
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
    <?= html_password('password', 'maxlength="100"') ?>
        <div style="text-align: right; margin-top: 5px;">
            <a href="javascript:void(0)" 
            id="toggleBtn" 
            onclick="toggleView()" 
            style="color: #ff8da1;
            font-size: 13px;
            text-decoration: none;
            font-weight: bold;">
            Show Password
            </a>
        </div>
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

<script>
function toggleView() {
    const input = document.getElementById('password');
    const btn = document.getElementById('toggleBtn');

    if (input.type === "password") {
        input.type = "text";
        btn.innerText = "Hide Password";
    } else {
        input.type = "password";
        btn.innerText = "Show Password";
    }
}
</script>

<?php 
    include '../_foot.php'
?>