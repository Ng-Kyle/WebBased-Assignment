<?php
require '../_base.php';
//-----------------------------------------------------------------------------

// TODO
 $member_id = req('id');
 

    $stm = $_db->prepare('SELECT *  FROM member WHERE member_id = ?');
    $stm->execute([$member_id]);
    $member = $stm->fetch();
    if(!$member){
        redirect('/');

    }
var_dump($member->image_url);
// ----------------------------------------------------------------------------
$_title = 'Member Details';
include '../_head.php';
?>

<table class="table detail">
    <tr>
        <th class="column">Id</th>
        <td><?= $member->member_id ?></td>
    </tr>
    <tr>
        <th class="column">Name</th>
        <td><?= $member->name ?></td>
    </tr>
    <tr>
        <th class="column">Email</th>
        <td><?= $member->email ?></td>
    </tr>
    <tr>
        <th class="column">Phone Number</th>
        <td><?= $member->phone_number ?></td>
    </tr>
    <tr>
        <th class="column">Profile Photo</th>
        <td><img src="<?= $member->image_url ?>" alt="Profile Photo" width="100px"> </td>
    </tr>
</table>




<style>

th.column{
    background-color:rgb(255, 178, 189);
    color: black;
}

</style>



<?php
include '../_foot.php';
