<?php
include '../_base.php';
include '../_head.php';

// ----------------------------------------------------------------------------

if (is_post()) {
    $email = req('email');

    // Validate: email
    if ($email == '') {
        $_err['email'] = 'Required';
    }
    else if (!is_email($email)) {
        $_err['email'] = 'Invalid email';
    }
    else if (!is_exists($email, 'member', 'email')) {
        $_err['email'] = 'Not exists';
    }

    // Send reset token (if valid)
    if (!$_err) {
        // TODO: (1) Select user
        $stm = $_db->prepare('SELECT * FROM member WHERE email = ?');
        $stm->execute([$email]); 
        $u = $stm->fetch();

        $id = SHA1(uniqid() . rand());

        $stm = $_db->prepare('DELETE FROM token WHERE member_id = ?');
        $stm->execute([$u->member_id]); 

        $stm = $_db->prepare('
            INSERT INTO token (id, expire, member_id)
            VALUES (?, ADDTIME(NOW(), "00:05"), ?)
        ');
        $stm->execute([$id, $u->member_id]);

        // TODO: (4) Generate token url
        $url = base("login/token.php?id=$id");

        // TODO: (5) Send email
        $m = get_mail(); //base.php
        $m->addAddress($u ->email, $u->name);
        $m->addEmbeddedImage("../$u->image_url", 'photo');
        $m->isHTML(true);
        $m->Subject = 'Reset Password';
        $m->Body = "
            <img src='cid:photo'
                 style='width: 200px; height: 200px;
                        border: 1px solid #333'>
            <p>Dear $u->name,<p>
            <h1 style='color: red'>Reset Password</h1>
            <p>
                Please click <a href='$url'>here</a>
                to reset your password.
            </p>
            <p>From, 😺 Admin</p>
        ";
        $m->send();
        temp('info', 'Email sent');
        redirect('/login/login.php');
    }
}

// ----------------------------------------------------------------------------

$_title = 'User | Reset Password';
?>
    
<style>
    /* 1. Prevent scroll and lock layout */
    html, body {
        height: 100vh;
        margin: 0;
        overflow: hidden; 
    }

    /* 2. The Reset Card */
    .form {
        background: white;
        padding: 40px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        width: 380px;

        /* Perfect Center */
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);

        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    /* 3. Clean Labels */
    .form label {
        display: block;
        width: 100%;
        font-weight: bold;
        margin-top: 10px;
        margin-bottom: 5px;
        background: none !important;
        color: #333 !important;
    }

    /* 4. Input Styling */
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

    /* 5. Buttons */
    .form section {
        display: flex;
        width: 100%;
        gap: 10px;
        margin-top: 20px;
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

    button:hover {
        background-color: #ff8da1;
    }

    .err { color: red; font-size: 12px; margin-top: 5px; }
</style>

<form method="post" class="form">
    <label for="email">Email</label>
    <?= html_text('email',"",'maxlength="100"') ?>
    <?= err('email') ?>

    <section>
        <button>Submit</button>
    </section>
</form>

<?php
include '../_foot.php';