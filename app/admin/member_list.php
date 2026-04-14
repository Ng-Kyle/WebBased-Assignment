<?php
    include '../_base.php';
    $_title = 'Member List';
    auth('admin');
   $name = req('member'); 

    // Fetch only specific columns: member_id and name
    $stm = $_db->prepare('
        SELECT member_id, name, image_url 
        FROM member 
        WHERE name LIKE ? 
        OR member_id LIKE ?
    ');
    
    // Note: We still need image_url for your <img> tag to work!
    $stm->execute(["%$name%", "%$name%"]);
    $arr = $stm->fetchAll();
    include '_head.php';
?>


<div class="adminMemberListSearchbar">
    <form action="" method="get">
        <?= html_search('member', 'placeholder="Search members by name or ID..."') ?>
    </form>
</div>

<table class="adminmemberListTable">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
        </tr>
    </thead>    
    <tbody>
        <?php if ($arr): ?>
            <?php foreach ($arr as $p): ?>
                <tr>
                    <td><?= $p->member_id ?></td>
                    <td><?= $p->name ?></td>
                    <td class="adminmemberListDetailsBtn">
                        <button class="adminmemberListDetails" data-get="member_details.php?id=<?= $p->member_id ?>">Details</button>
                        <img class="popup" src="<?= $p->image_url ?>" >
                    </td>
                </tr>
            <?php endforeach ?>
        <?php else: ?>
            <tr class="adminMemberListNone">
                <td>No member ID found matching your search.</td>
                <td>No name found matching your search.</td>
                <td> <a href="?" class="adminMemberListreset-link">View All Members</a></td>
            </tr>
           
        <?php endif ?>
    </tbody>  
</table>







<?php
include '../_foot.php';
?>