<?php
include '../_base.php';
$_title = 'Member List';
auth('admin');
// retrieve all student records from db4
$arr = $_db->query('SELECT * FROM member')->fetchAll();
include '_head.php';
?>

<style>
    
.table1 {
    width: 70%;
    margin: 40px auto; 
    border-collapse: collapse;
    overflow: visible;
    }

.table1 th, .table1 td {
    border: 2px solid rgb(255, 110, 110);
    padding: 12px; 
    text-align: center;
}

.table1 th {
    color: #000;
    background: #ffd4d4;
    font-weight: 600;
}

.table1 tr:hover td {
    background-color: #ffecec;
}

.details {
    background-color: white;
    border: 2px solid rgb(255, 109, 109);
    padding: 5px 10px;
    border-radius: 6px;
    cursor: pointer;
    transition: 0.2s;
}

.details:hover {
    background-color: rgb(255, 110, 110);
    color: white;
}

.details-but {
    width: 20%;
    position: relative;
}

.table1 .popup {
    width: 120px;
    height: 120px;
    object-fit: cover;
    position: absolute;
    top: 50%;
    left: 100%;
    transform: translate(10px, -50%);
    z-index: 999;
    border: 5px solid rgb(255, 126, 126);
    border-radius: 8px;
    background: white;
    display: none;
    
}

.details-but:hover .popup {
    display: block;
}

</style>


<p><?= count($arr) ?> record(s)</p>

<table class="table1">
    <tr class="table-title">
        <th>Id</th>
        <th>Name</th>
        
    
    </tr>

    <?php foreach ($arr as $p): ?>
    <tr class="table-row">
        <td><?= $p->member_id ?></td>
        <td><?= $p->name ?></td>
        <td class="details-but">
            <button class="details" data-get="member_details.php?id=<?= $p->member_id ?>">Details</button>
            <img class="popup" src="<?= $p->image_url ?>" >
        </td>
    </tr>
    <?php endforeach ?>
</table>








<?php
include '../_foot.php';
