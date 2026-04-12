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
// TODO: (1) Select user
        $stm = $_db->prepare('SELECT * FROM member WHERE email = ?');
        $stm->execute([$email]); // Passed the variable here
        $u = $stm->fetch();

        // TODO: (2) Generate token id
        $id = SHA1(uniqid() . rand());

        // TODO: (3) Delete old and insert new token
        // Step A: Delete
        $stm = $_db->prepare('DELETE FROM token WHERE member_id = ?');
        // Check your column name! If it's Member_ID in the DB, use $u->Member_ID
        $stm->execute([$u->member_id]); 

        // Step B: Insert
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

<form method="post" class="form">
    <label for="email">Email</label>
    <?= html_text('email',"",'maxlength="100"') ?>
    <?= err('email') ?>

    <section>
        <button>Submit</button>
        <button type="reset">Reset</button>
    </section>
</form>

<?php
include '../_foot.php';