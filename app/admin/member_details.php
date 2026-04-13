<?php
require '../_base.php';
//-----------------------------------------------------------------------------
auth('admin');
// TODO
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
<main class="table-main">
    <table class="table-detail">
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
            <td><img class="pic" src="<?= $member->image_url ?>" alt="Profile Photo" width="100px"> </td>
        </tr>
    </table>
</main>



<style>

.column {
    background-color: rgb(255, 178, 189);
    color: black;
}

/* Center the table properly */
.table-main {
    display: flex;
    justify-content: center;
    margin-top: 50px;
    
    
}

/* Table styling */
.table-detail {
    width: 600px;
    border-collapse: collapse;
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
   
}

/* Cells */
.table-detail th,
.table-detail td {
    border-bottom: 1px solid #ddd;
    padding: 15px; /* FIXED */
}

/* Left column */
.table-detail th {
    width: 30%;
    text-align: left;
}

/* Right column */
.table-detail td {
    width: 70%;
    text-align: center;
}

/* Remove last line */
.table-detail tr:last-child th,
.table-detail tr:last-child td {
    border-bottom: none;
}

/* Image styling */
.table-detail img {
    width: 120px;
    height: 120px;
    object-fit: cover;
    border-radius: 10px;
    display: block;
    margin: 10px auto;
}

</style>



<?php
include '../_foot.php';
