<script type="text/javascript" language="javascript">
function DisableBackButton()
{
window.history.forward()
}
DisableBackButton();
window.onload = DisableBackButton;
window.onpageshow = function(evt) 
{
	if (evt.persisted) DisableBackButton(); 
	}
window.onunload = function() { 
	void (0); 
	}
</script>
<?php 
header("Cache-Control: private");
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Cache-Control=proxy-revalidate");

date_default_timezone_set("Asia/Kolkata");
include("../includes/db_inc1.php");//database connection
session_start();

$_SESSION['user'];

$_SESSION['location'];
$leveladd=$_SESSION['level_level'];
$localadmin=$_SESSION['localadmin'];
$main_id=$_SESSION['main_id'];
$deptloing=$_SESSION['dept'];
$schemas=htmlspecialchars($_SESSION['schema_name']);
$userid=$_SESSION['id'];

if($_SESSION['user'] == '' and $_SESSION['location'] =='')
{
echo "Access Problem....."; 
header("Location: ../index.php");
die();
}

$_SESSION['menuaccess_codeall'];
if($_SESSION['menuaccess_codeall'] =='')
{
	echo "You Are Not Access This Page......";
	die();
}



setcookie("PHPSESSID","",time()-3600,"","",TRUE,TRUE);


$_SESSION['csrf'] = md5(uniqid(rand(), TRUE));
$key=$_SESSION['csrf'];

// At the top of the page we check to see whether the user is logged in or not
if(empty($_SESSION['user']) and $_SESSION['location']=='')
{
	die("Redirecting to login.php");
}

if($_SESSION['user'] !='' and $_SESSION['location'] !='')
{
	
	
	
// This code not use next time .......	Schema session create Hear....
	
$payid=$_REQUEST['payid'];
	if($payid!=''){
		$paydelete="delete from aptel_temp_payment where id ='$payid'";
		$payiddelete = $db->prepare($paydelete);
		$payiddelete->execute();
	}

	$sessionUserType=htmlspecialchars($_SESSION['id']);
	$stlu = $db->prepare("select location from users where id= ? ");
	$stlu->bindParam(1, $sessionUserType, PDO::PARAM_STR);

	$stlu->execute();
	while ($row = $stlu->fetch(PDO::FETCH_ASSOC,PDO::FETCH_ORI_NEXT))
	{
		$locationq=$row['location'];
	}
	if($_SESSION['location'] != $locationq)
	{
		session_unset();     // unset $_SESSION variable for the run-time
		session_destroy();
		echo "You are not Valied User..... please login again";
		header("Location: ../login.php");
		die();
	}
	if($locationq =='')
	{
		session_unset();     // unset $_SESSION variable for the run-time
		session_destroy();
		echo "You are not Valied User..... please login again";
		header("Location: ../login.php");
		die();
	}
	 $salt=htmlspecialchars($_REQUEST['salt']);
	if(!preg_match('/^[0-9]*$/',$salt))
	{
		echo "<font color='red' size='4'>Error: You did not enter numbers only. Please enter only numbers.</font></center>";
		//header("scrutiny.php?msg=$valid");
		die();
	}

	//echo $filing=$_REQUEST['filing'];

else {
	$dbankname=htmlspecialchars($_REQUEST['dbankname']);
	if(strlen($dbankname)>200)
	{
		echo "<font color='red' size='4'>Error: Bank Name is too long/ Correct Bank Name.</font></center>";
		//header("auditaptel/filing/filing.php");
		die();
	}




	$amountRs=htmlspecialchars($_REQUEST['amountRs']);
	/*if(!preg_match('/^[0-9]*$/',$amountRs))
	{
		echo "<font color='red' size='4'>Error: You did not enter numbers only. Please enter only numbers.</font></center>";
		//header("scrutiny.php?msg=$valid");
		die();
	}*/
	if(strlen($amountRs)>15)
	{
		echo "<font color='red' size='4'>Error: Please enter only 15 Digit Rs .</font></center>";
		//header("auditaptel/filing/filing.php");
		die();
	}
	$bd=$_REQUEST['bd'];
	$ddno=htmlspecialchars($_REQUEST['ddno']);
if($ddno!="" and $bd=='1')
{
	if(!preg_match('/^[0-9]*$/',$ddno))
	{
		echo "<font color='red' size='4'>Error: You did not enter numbers only. Please enter only numbers.</font></center>";
		//header("scrutiny.php?msg=$valid");
		die();
	}

	if(strlen($ddno)>7)
	{
		echo "<font color='red' size='4'>Error: Please enter only 7 Digit DD No .</font></center>";
		//header("auditaptel/filing/filing.php");
		die();
	}
}
	$ddate=htmlspecialchars($_REQUEST['dddate']);


	$regexDate = '#\d\d\-\d\d\-\d\d\d\d#' ;
	$dateIn = str_replace('/', '-', $ddate) ;

	if (preg_match($regexDate, $ddate)) {
		list($dd, $mm, $yy) =split("-",$ddate);
	$ddate=$yy.'-'.$mm.'-'.$dd;
	}




	$bd=htmlspecialchars($_REQUEST['bd']);
	if(!preg_match('/^[0-9]*$/',$bd))
	{
		echo "<font color='red' size='4'>Error: You did not enter numbers only. Please enter only numbers.</font></center>";
		//header("scrutiny.php?msg=$valid");
		die();
	}
	if(strlen($bd)>2)
	{
		echo "<font color='red' size='4'> Please enter only 2 Digit numbers.</font></center>";
		//header("auditaptel/filing/filing.php");
		die();
	}
if($bd==3){
	$ddno=htmlspecialchars($_REQUEST['ddno']);
}
	if($payid =='') {

	 $sql="insert into aptel_temp_payment(salt,payment_mode,branch_name,dd_no,dd_date,amount)
	 values(:salt,:bd,:dbankname,:ddno,:ddate,:amountRs)";
 
	 $query_params=array(
	 :saltalt'=>$salt,
	 :bdode'=>$bd,
	 :dbanknameame'=>$dbankname,
	 :ddno_no'=>$ddno,
	 :ddateate'=>$ddate,
	 :amountRsunt'=>$amoun
tRs
	

	 try
	 {

	 	$stmt = $db->prepare($sql);
	 	$result = $stmt->execute($query_params);
	 }
	 catch(PDOException $ex)
	 {

	 	die("Failed to run query case detail table Applicant: " . $ex->getMessage());
	 }
	 }
	}
	/* 		values('$salt','$bd','$dbankname','$ddno','$ddate','$amountRs')"; */

arams);
	$bd=$_REQUEST
['bd'];
	if(
	$bd==2){
		$bankname="Post Office Details";
		$date="DD Date";
		$amount="Aomunt in Rs.";
		$dd="DD N
	o";
	}if(
	$bd==1){
		$bankname="Bank Name";
		$dd="DD No";
		$date="DD Date";
		$amount="Aomunt in Rs
	.";
	}if(
	$bd==3){
		$bankname="Name";
		$dd="challan/Ref. No";
		$date="Date of Transction";
		$amount="Aomunt in Rs.";
	
<style type="text/css">
    .Table
    {
        display: table;
         width: 100%;
    }
    .Title
    {
        display: table-caption;
        text-align: center;
        font-weight: bold;
        font-size: larger;
      
    }
    .Heading
    {
        display: table-row;
        font-weight: bold;
        text-align: center;
        font-size:20px;
        
    }
    .Row
    {
        display: table-row;
       
    }
    .Cell
    {
    	
        display: table-cell;
        border: solid;
        border-width: thin;
        padding-left: 5px;
        padding-right: 5px;
     
    }
   
</style>}     	<div class="col-sm-12 div-padd">
	nt>div<classblTableex
   a
  <div class="Row">
    <div class="Cell">
      mpl  e<p> <font color="#510812" size="3"><?php echo 'Bank Branch / Post Office / Online Name';?></font></p>">        </div>
    <div class="Cell">?></th>
     <p> <font color="#510812" size="3">   <th><?php echo htmlspecialchars(</font></p>?></th>
 </div>
      
        <div class="Cell">
            <p><font color="#510812" size="3">   <th><?php echo htmlspecialchars($d</font></p>?></th>
 </div>
        
        <div class="Cell">
            <p><font color="#510812" size="3">   <th><?php echo htmlspecialchars($amo</font></p>?></th>  </div>
        
        <div class="Cell">
            <p><font color="#510812" size="3">   <th><?php echo "Del</font></p>
        </div>
        </div></tr>  
        <?php 
		
        $aDetail=$db -> prepare("select * from aptel_temp_payment where salt=?");
        
        $aDetail->bindParam(1,$salt, PDO::PARAM_STR);
        $aDetail -> execute();$s        while ($row =$aDetail->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT))
        { $row){
        	$['=$']row			$sum=$sum+$row['+$row-']amount;
        ?    <div class="Row">
        <div class="Cell">          <p class="custom"><?php echo htmlspecialchars($row['($row->bran']ch_n</p>
        </div>
        <div class="Cell">?>            <p class="custom"><?php if($row['dd_no'] != 'undefined') { echo htmlspecialchars($row['($row']->dd_no</p>
        </div>
        <div class="Cell">?>            <p class="custom"><?php echo htmlspecialchars($row['($row->']dd_d</p>
    ?>< </div>
        <div class="Cell">/td>   
     <p class="custom">   <td><?php echo htmlspecialrow['$$row-']>amo</p>
        </div>
        <div class="Cell">
            <p class="custom">
 ?></td>
                <td><input type="button" name="nextsubmit" id="nextsubmit" value="Delete"  class="btn1" onclick="deletePay('<?php echo $id;

            
            </p>
        </div>
       
        </div>/></td>
        <?
		<div class="Row">able>  
		<div class="Cell">
            <p><font color="#510812" size="3"><?php echo "Total Rs";?></font></p>
       
		<div class="Cell">
            <p class="custom"></p>
        </div>
		<div class="Cell">
            <p class="custom"></p>
        </div>
		<div class="Cell">
            <p class="custom"><font color="#510812" size="3"><?php echo htmlspecialchars($sum);?></font></p>
        </div>
		<div class="Cell">
            <p class="custom"></p>
        </div>
		</div>
        </div>

</div> <<?php }

echo "sdafsad";die;?>/div>
