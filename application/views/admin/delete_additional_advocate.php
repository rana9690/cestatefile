<?php

$id=$_REQUEST['id'];
$party=$_REQUEST['party'];
$salt=$_REQUEST['salt'];
$bd = $_REQUEST['ptype'];
if ($bd == 1)
    $pflag = 'P';
if ($bd == 2)
    $pflag = 'R';
    $query =$this->efiling_model->delete_event('additional_advocate','id',$_REQUEST['payid']);
?>
    <style>
        .btn-info {
            margin: 5px 0;
        }
        #advdetails_dfgdgdf td, #advdetails_dfgdgdf th {
            padding: 0px 8px;
        }
        #advdetails_dfgdgdf th {
            background: #171717;
            color: #fff;
            padding: 5px 8px;
        }
    </style>
<?php
$pflag =$pflag;
$salt = $_REQUEST['salt'];
include_once ('add_advocate_table.php'); ?>