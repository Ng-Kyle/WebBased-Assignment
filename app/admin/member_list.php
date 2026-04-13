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

<style>
    .search-bar{
            text-align: center;
            margin: 20px;
        }
        .search-bar input{
            width: 50%;
            padding: 10px;
            border-radius: 20px;
            border: 2px solid #FF5E7E;
        }
        .search-bar input:focus{
            border-color:#ff1f4b;
            outline: none;
            box-shadow: 0 0 8px rgba(255, 94, 126, 0.3);
        }
        .memberListTable{
           margin-left: 20%;
        }
        .reset-link td{
            font-size: 20px;
            border: hidden;
        }
</style>


<div class="search-bar">
    <form action="" method="get">
        <?= html_search('member', 'placeholder="Search members by name or ID..."') ?>
    </form>
</div>

<table class="memberListTable">
    <thead>
        <tr class="table-title">
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
                    <td class="memberListDetailsBtn">
                        <button class="memberListDetails" data-get="member_details.php?id=<?= $p->member_id ?>">Details</button>
                        <img class="popup" src="<?= $p->image_url ?>" >
                    </td>
                </tr>
            <?php endforeach ?>
        <?php else: ?>
            <tr class="none">
                <td>No member ID found matching your search.</td>
                <td>No name found matching your search.</td>
                <td> <a href="?" class="reset-link">View All Members</a></td>
            </tr>
           
        <?php endif ?>
    </tbody>  
</table>







<?php
include '../_foot.php';
?>