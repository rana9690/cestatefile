<?php $this->load->view("admin/header"); ?>
<?php $this->load->view("admin/sidebar"); ?>


<div class="content" style="padding:0px;">
    <div class="row">
        <div class="card checklistSec" style="">
        <div class="container">
            <?= form_fieldset('User Profile <div class="date-div text-success">Date & Time : &nbsp;<small>'.date('D M d, Y H:i:s').'&nbsp;IST</small></div>').
                        '<i class="icon-plus-circle2 text-danger d-none" style="position: absolute;padding: 9px 6px;"></i>';
                        ?>
            <div class="col-md-8">
                <?php //echo "<pre>";print_r($userDetail);?>
                <!-- <h4>User Profile</h4> -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <?php
                        $fname=isset($userDetail[0]->fname)?$userDetail[0]->fname:'';
                        $lname=isset($userDetail[0]->lname)?$userDetail[0]->lname:'';
                        ?>
                        <strong>Name :</strong> <?php echo ucfirst($fname.' '.$lname); ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Gender :</strong>
                        <?php echo ucfirst(isset($userDetail[0]->gender)?$userDetail[0]->gender:''); ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Address :</strong>
                        <?php echo ucfirst(isset($userDetail[0]->address)?$userDetail[0]->address:''); ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Country Name :</strong>
                        <?php echo ucfirst(isset($userDetail[0]->country)?$userDetail[0]->country:''); ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>State Name :</strong><?php echo isset($userDetail[0]->state)?$userDetail[0]->state:''; ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>District Name :</strong>
                        <?php echo isset($userDetail[0]->district)?$userDetail[0]->district:''; ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong> Pincode :</strong>
                        <?php echo isset($userDetail[0]->pincode)?$userDetail[0]->pincode:''; ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Mobile :</strong>
                        <?php echo isset($userDetail[0]->mobilenumber)?$userDetail[0]->mobilenumber:''; ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Mobile :</strong> <?php echo isset($userDetail[0]->email)?$userDetail[0]->email:''; ?>
                    </div>
                    <?php 
                        $idptype=isset($userDetail[0]->idptype)?$userDetail[0]->idptype:'';
                        $idproof_upd=isset($userDetail[0]->idproof_upd)?$userDetail[0]->idproof_upd:'';
                        $id=isset($userDetail[0]->id)?$userDetail[0]->id:'';
                        ?>

                    <div class="col-md-12">
                        <h4 class="mt-4"><span class="fa fa-clock-o ion-clock float-right"></span><b>Uploaded Document</u></h4>
                        <table class="table table-sm table-hover table-striped">
                            <tbody>
                                <tr>
                                    <td>
                                        <strong><?php  echo $idptype; ?> </strong> 
                                        <strong style="float: right;font-color:red"><a target="_blank" href="<?php echo base_url();?>userdetails/<?php echo hash('sha256','.'.$idproof_upd); ?>/<?php echo $id;?>"><i class="fa fa-download"></i> Download</a></strong>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
                <!--/row--> 


            <div class="tab-pane active" id="editprofile"></div>


        </div>
        <div class="col-md-4 text-center mb-4">
            <img src="https://www.kindpng.com/picc/m/252-2524695_dummy-profile-image-jpg-hd-png-download.png"
                class="mx-auto img-fluid d-block" alt="avatar" style="max-width: 200px; border: 1px solid #000;">
            <!-- <img src="https://www.kindpng.com/picc/m/252-2524695_dummy-profile-image-jpg-hd-png-download.png<?php echo base_url();?>userdetails/<?php echo hash('sha256','.'.$idproof_upd); ?>/<?php echo $id;?>"
                    class="mx-auto img-fluid img-circle d-block" alt="avatar"> -->
            <h6 class="mt-2">Upload a different photo</h6>
            <label class="custom-file">
                <input type="file" id="file" class="custom-file-input">
                <span class="custom-file-control btn btn-xs btn-warning pointer">Choose file</span>
            </label>
        </div>
        <?= form_fieldset_close(); ?>
    </div>
</div>
</div>
</div>


<?php $this->load->view("admin/footer"); ?>