<?php
    require '../_base.php';
//-----------------------------------------------------------------------------
    auth('admin');
    $member_id = req('id');

    $stm = $_db->prepare('SELECT *  FROM member WHERE member_id = ?');
    $stm->execute([$member_id]);
    $member = $stm->fetch();

    if(!$member){
        redirect('/');
    }
// ----------------------------------------------------------------------------
    $_title = 'Member Details';
    include '_head.php';
?>
<div class="memberDetailTableMain">
    <table class="memberDetailTableDetail">
        <tr>
            <th class="memberDetailColumn">Id</th>
            <td><?= $member->member_id ?></td>
        </tr>
        <tr>
            <th class="memberDetailColumn">Name</th>
            <td><?= $member->name ?></td>
        </tr>
        <tr>
            <th class="memberDetailColumn">Email</th>
            <td><?= $member->email ?></td>
        </tr>
        <tr>
            <th class="memberDetailColumn">Phone Number</th>
            <td><?= $member->phone_number ?></td>
        </tr>
        <tr>
            <th class="memberDetailColumn">Profile Photo</th>
            <td><img class="pic" src="<?= $member->image_url ?>" alt="Profile Photo" width="100px"> </td>
        </tr>
    </table>
</div>

<?php
include '../_foot.php';
?>