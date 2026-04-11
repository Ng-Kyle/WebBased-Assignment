<?php
include '../_base.php';
include '../_head.php';

// ----------------------------------------------------------------------------

// Authenticated users
auth();

if (is_get()) {
    $stm = $_db->prepare('SELECT * FROM member WHERE Member_ID = ?');
    $stm->execute([$_user->Member_ID]);
    $u = $stm->fetch();

    if (!$u) {
        redirect('/');
    }

    extract((array)$u);
    $_SESSION['Image_URL'] = $u->Image_URL;
}

if (is_post()) {
    $email = req('email');
    $name  = req('name');
    $photo = $_SESSION['Image_URL'];
    $f = get_file('photo');

    // Validate: email
    if ($email == '') {
        $_err['email'] = 'Required';
    }
    else if (strlen($email) > 100) {
        $_err['email'] = 'Maximum 100 characters';
    }
    else if (!is_email($email)) {
        $_err['email'] = 'Invalid email';
    }
    else {
        $stm = $_db->prepare('
            SELECT COUNT(*) FROM member
            WHERE Email = ? AND Member_ID != ?
        ');
        $stm->execute([$email, $_user->Member_ID]);

        if ($stm->fetchColumn() > 0) {
            $_err['email'] = 'Duplicated';
        }
    }

    // Validate: name
    if ($name == '') {
        $_err['name'] = 'Required';
    }
    else if (strlen($name) > 100) {
        $_err['name'] = 'Maximum 100 characters';
    }

    // Validate: photo (file) --> optional
    if ($f) {
        if (!str_starts_with($f->type, 'image/')) {
            $_err['photo'] = 'Must be image';
        }
        else if ($f->size > 1 * 720 * 720) {
            $_err['photo'] = 'Maximum 1MB';
        }
    }

    // DB operation
    if (!$_err) {
        // (1) Delete and save photo --> optional
        if ($f) {
            unlink("../images/$photo");
            $photo = save_photo($f, '../images');
        }
        
        // (2) Update user (email, name, photo)
        $stm = $_db->prepare('
            UPDATE member
            SET Email = ?, Name = ?, Image_URL = ?
            WHERE Member_ID = ?
        ');
        $stm->execute([$email, $name, $photo, $_user->Member_ID]);

        // (3) Update global user object
        $_user->Email = $email;
        $_user->Name  = $name;
        $_user->Image_URL = $photo;

        temp('info', 'Record updated');
        redirect('/');
    }
}

// ----------------------------------------------------------------------------

$_title = 'User | Profile';
?>

<form method="post" class="form" enctype="multipart/form-data">
    <label for="email">Email</label>
    <?= html_text('email', $_user->Email, 'maxlength="100"') ?>
    <?= err('email') ?>

    <label for="name">Name</label>
    <?= html_text('name', $_user->Name, 'maxlength="100"') ?>
    <?= err('name') ?>

    <label for="photo">Photo</label>
    <label class="upload" tabindex="0">
        <?= html_file('photo', 'image/*', 'hidden') ?>
        <img src="../<?= $_user->Image_URL ?> ">
    </label>
    <?= err('photo') ?>

    <section>
        <button>Submit</button>
        <button type="reset">Reset</button>
    </section>
</form>

<?php
include '../_foot.php';