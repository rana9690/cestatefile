<ul class="nav nav-sidebar" data-nav-type="accordion">
    <li class="nav-item"><a href="<?php echo base_url(); ?>dashboard"  class="nav-link active"><i class="icon-home4"></i><span>Dashboard</span></a></li>
	 <?php  
	 
	 
	 if($this->session->userdata('login_success')[0]->role==1):?>
	  <li class="nav-item">
        <a href="<?php echo base_url(); ?>audittrail" class="nav-link"><i class="icon-copy"></i> <span>Audit Trail</span></a>
    </li>
       
    <?php endif;?>
	
    <?php  if($this->config->item('caviat_privilege')==true):?>
        <li class="nav-item nav-item-submenu">
            <a href="#" class="nav-link"><i class="icon-copy"></i> <span>Caveat</span></a>
            <ul class="nav nav-group-sub left-bar-links" data-submenu-title="Layouts">
                <li class="nav-item"><a href="<?php echo base_url();?>cav_basicdetail"  data-value="caveat" class="nav-link active" id="caveat">Caveat Filing</a></li>
                <li class="nav-item"><a href="<?php echo base_url();?>caveate_list" data-value="ia_list" class="nav-link" id="ia_list">Caveate List</a></li>
            </ul>
        </li>
    <?php endif;?>



    <?php
    $sessionuser_id=   $this->session->userdata('user_id');
    $maimenu="SELECT id,name,parent_id,display_name FROM efile_permissions WHERE status = TRUE and parent_id is null	and id in (select permission_id from efile_permission_roles where role_id in (select role_id from efile_roles_users where user_id=$sessionuser_id))
ORDER BY priority ASC";
    $maimenuquery =$this->db->query("$maimenu");
    if($maimenuquery->num_rows()>0){
    $menu_data = $maimenuquery->result_array();
    foreach($menu_data as $key=>$value) {
    $parent_id=$value['id'];
    $submenu="SELECT id,name,parent_id,display_name FROM efile_permissions WHERE	status = TRUE and parent_id =$parent_id and id in (select permission_id from efile_permission_roles where role_id in (select role_id from efile_roles_users where user_id=$sessionuser_id))
ORDER BY priority ASC";
    $submenuquery =$this->db->query("$submenu");

    if($submenuquery->num_rows()==0){?>
    <li class="nav-item">
        <a href="<?php echo  base_url(); ?><?php echo $value['name']; ?>" class="nav-link"><i class="icon-copy"></i> <span><?php echo $value['display_name']; ?> </span></a>
        <?php }
        ?>

        <?php
        if($submenuquery->num_rows()>0){
        ?>
    <li class="nav-item nav-item-submenu">
        <a  class="nav-link"><i class="icon-copy"></i> <span><?php echo $value['display_name']; ?> </span></a>
        <ul class="nav nav-group-sub" data-submenu-title="Layouts">
            <?php
            $sub_menu_data = $submenuquery->result_array();
            foreach($sub_menu_data as $sub_menu) {
            $menu = $sub_menu['name'];
            ?>
            <a href="<?php echo  base_url(); ?><?php echo $menu; ?>" class="nav-link"><i class="icon-copy"></i> <span><?php echo $sub_menu['display_name']; ?> </span></a></li>
    <?php } ?>
</ul>
<?php }?>
</li>
<?php }
} ?>


<?php 

if($this->session->userdata('login_success')[0]->role==1){?>
    <li class="nav-item">
        <a href="<?php echo base_url(); ?>master_dash" class="nav-link"><i class="icon-copy"></i> <span>Master</span></a>

    </li>
<?php }?>



<?php if($this->session->userdata('login_success')[0]->role==2):?>
<li class="nav-item">
        <a href="<?php echo base_url(); ?>euser_list" class="nav-link"><i class="fa fa-user"></i> <span>Users</span></a>
    </li>
<?php endif;?>
    <li class="nav-item">
        <a href="<?php echo base_url(); ?>logout" class="nav-link"><i class="icon-exit"></i> <span>Logout</span></a>
    </li>
</ul>