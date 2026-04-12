<?php
include '../_base.php';
$_title = 'Member List';

// retrieve all student records from db4
$arr = $_db->query('SELECT * FROM member')->fetchAll();
include '_head.php';
?>

<style>
    .popup {
        width: 100px;
        height: 100px;
    }
</style>


<p><?= count($arr) ?> record(s)</p>

<table class="table">
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th></th>
    </tr>

    <?php foreach ($arr as $p): ?>
    <tr>
        <td><?= $p->member_id ?></td>
        <td><?= $p->name ?></td>
        <td>
            <button data-get="member_details.php?id=<?= $p->member_id ?>">Details</button>
            <img src="/photos/<?= $p->image_url ?>" class="popup">
        </td>
    </tr>
    <?php endforeach ?>
</table>








<?php
include '../_foot.php';
