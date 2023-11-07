
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$pcodeAll = $_REQUEST['pcode'];
$cadd = htmlspecialchars($_REQUEST['cadd']);
$cpin = htmlspecialchars($_REQUEST['cpin']);
$cmob = htmlspecialchars($_REQUEST['cmob']);
$cemail = htmlspecialchars($_REQUEST['cemail']);
$cfax = htmlspecialchars($_REQUEST['cfax']);
$salt = htmlspecialchars($_REQUEST['salt']);
$counselpho = htmlspecialchars($_REQUEST['counselpho']);
$state = htmlspecialchars($_REQUEST['st']);
$dist = htmlspecialchars($_REQUEST['dist']);
$councilCode = htmlspecialchars($_REQUEST['councilCode']);

$userdata=$this->session->userdata('login_success');
$userid=$userdata[0]->id;

$bd = $_REQUEST['bd'];
if ($bd == 1)
    $pflag = 'P';
if ($bd == 2)
    $pflag = 'R';
$pcode = $_REQUEST['pcode'];
if ($pcode == 'Select Party Name') {
    $pcode = 1;
}
if ($councilCode != "" and $salt != "") {
    $count = count($pcodeAll);
    for ($i = 0; $i < $count; $i++) {
        $query_params = array(
            'filing_no' => $salt,
            'party_flag' => $pflag,
            'adv_code' => $councilCode,
            'adv_mob_no' => $cmob,
            'adv_phone_no' => $counselpho,
            'adv_fax_no' => $cfax,
            'adv_email' => $cemail,
            'adv_address' => $cadd,
            'user_id' => $userid,
            'pin_code' => $cpin,
            'party_code' => $pcodeAll[$i],
            'state' => $state,
            'district' => $dist
        );      
        $st=$this->efiling_model->insert_query('additional_advocate',$query_params);
    }
}
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

<?php include_once ('add_advocate_table.php'); ?>
