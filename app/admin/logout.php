<?php
include '../_base.php';
include '_head.php';

    auth('admin');
    // ----------------------------------------------------------------------------

    temp('info', 'Logout successfully');
    logout('/admin/admin.php');

// ----------------------------------------------------------------------------
