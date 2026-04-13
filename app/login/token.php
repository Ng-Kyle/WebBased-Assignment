<?php
    $title = 'Reset Password';
    include '../_base.php';
    include '../_head.php';
    // ----------------------------------------------------------------------------

    $_db->query('DELETE FROM token WHERE expire < NOW()');

    $id = req('id'); //this form url

    if (!is_exists($id, 'token', 'id')) { // check form data base
        temp('info', 'Invalid token. Try again');
        redirect('/');
    }

    if (is_post()) {
        $password = req('password');
        $confirm  = req('confirm');

        // Validate: password
        if ($password == '') {
            $_err['password'] = 'Required';
        }
        else if (strlen($password) < 5 || strlen($password) > 100) {
            $_err['password'] = 'Between 5-100 characters';
        }

        // Validate: confirm
        if ($confirm == '') {
            $_err['confirm'] = 'Required';
        }
        else if (strlen($confirm) < 5 || strlen($confirm) > 100) {
            $_err['confirm'] = 'Between 5-100 characters';
        }
        else if ($confirm != $password) {
            $_err['confirm'] = 'Not matched';
        }

        // DB operation
        if (!$_err) {
            $stm = $_db->prepare('
                UPDATE member
                SET password = SHA1(?)
                WHERE member_ID = (SELECT member_id FROM token WHERE id = ?);

                DELETE FROM token WHERE id = ?;
            ');
            $stm->execute([$password, $id, $id]);

            temp('info', 'Record updated');
            redirect('/login/login.php');
        }
    }
?>


<form method="post" class="tokenForm">
    <label for="password">Password</label>
    <?= html_password('password', 'maxlength="100"') ?>
    <?= err('password') ?>

    <label for="confirm">Confirm</label>
    <?= html_password('confirm', 'maxlength="100"') ?>
    <?= err('confirm') ?>

    <section>
        <button>Submit</button>
        <button type="reset">Reset</button>
    </section>
</form>

<?php
include '../_foot.php';