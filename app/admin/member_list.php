<?php
    include '../_base.php';
    $_title = 'Member List';
    auth('admin');

    $arr = $_db->query('SELECT * FROM member')->fetchAll();
    include '_head.php';
?>

<table class="memberListTable">
    <tr class="table-title">
        <th>Id</th>
        <th>Name</th>
    </tr>
    <?php foreach ($arr as $p): ?>
        <tr>
            <td><?= $p->member_id ?></td>
            <td><?= $p->name ?></td>
            <td class="memberListDetailsBtn">
                <button class="memberListDetails" data-get="member_details.php?id=<?= $p->member_id ?>">Details</button>
                <img class="popup" src="<?= $p->image_url ?>" >
            </td>
        </tr>
    <?php endforeach ?>
</table>








<?php
include '../_foot.php';
?>