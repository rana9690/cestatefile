<?php $this->load->view("admin/header"); ?>
<?php $this->load->view("admin/sidebar"); ?>


<div class="content" style="padding:0px;">
    <div class="row">
        <div class="card checklistSec" style="">
            <div class="container">

                <?= form_fieldset('Edit Profile <div class="date-div text-success">Date & Time : &nbsp;<small>'.date('D M d, Y H:i:s').'&nbsp;IST</small></div>').
'<i class="icon-plus-circle2 text-danger d-none" style="position: absolute;padding: 9px 6px;"></i>';
?>

                <?= form_open(false,['class'=>'wizard-form steps-basic wizard clearfix','id'=>'edituser','autocomplete'=>'off']) ?>

                <?php 
                                                    $msg=isset($msg)?$msg:'';
                                                    $errors=isset($errors)?$errors:'';
                                                    if($msg!=''){ ?>
                <center>
                    <div class="alert alert-success" role="alert">
                        <?php  echo $msg;  ?>
                        <?php echo validation_errors(); ?>
                    </div>
                </center>
                <?php }if($errors!=''){ ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $errors; ?>
                </div>
                <?php } ?>
                <div class="row">
                    <div class="col-md-6 border-right">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="labels">User type</label>
                                <input type="text" name="user_type" id="user_type" class="form-control"
                                    placeholder="first name"
                                    value="<?php echo isset($users[0]->user_type)?$users[0]->user_type:'';?>" readonly>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="labels">loginid</label>
                                <input type="text" name="loginid" id="loginid" class="form-control"
                                    value="<?php echo isset($users[0]->loginid)?$users[0]->loginid:'';?>"
                                    placeholder="surname" readonly>
                            </div>

                            <div class="col-md-6 form-group">
                                <label class="labels">Name</label>
                                <input type="text" class="form-control" name="fname" id="fname" placeholder="first name"
                                    value="<?php echo isset($users[0]->fname)?$users[0]->fname:'';?>">
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="labels">Surname</label>
                                <input type="text" class="form-control" name="lname" id="lname"
                                    value="<?php echo isset($users[0]->lname)?$users[0]->lname:'';?>"
                                    placeholder="surname">
                            </div>

                            <div class="col-md-12 form-group">
                                <label class="labels">PhoneNumber</label>
                                <input type="text" class="form-control" placeholder="enter phone number"
                                    name="mobilenumber" id="mobilenumber"
                                    value="<?php echo isset($users[0]->mobilenumber)?$users[0]->mobilenumber:'';?>">
                            </div>
                            <div class="col-md-12 form-group">
                                <label class="labels">Address</label>
                                <input type="text" class="form-control" placeholder="enter address" name="address"
                                    id="address" value="<?php echo isset($users[0]->address)?$users[0]->address:'';?>">
                            </div>
                            <div class="col-md-12 form-group">
                                <label class="labels">Email</label>
                                <input type="text" class="form-control" placeholder="education" name="email" id="email"
                                    value="<?php echo isset($users[0]->email)?$users[0]->email:'';?>">
                            </div>
                            <div class="col-md-12 form-group">
                                <label class="labels">Pin Code</label>
                                <input type="text" name="pincode" class="form-control" name="pincode" id="pincode"
                                    placeholder="enter pincode"
                                    value="<?php echo isset($users[0]->pincode)?$users[0]->pincode:'';?>">
                            </div>

                            <div class="col-md-6 form-group">
                                <label class="labels">Country</label>
                                <select class="form-control" name="country" id="country">
                                    <option value="india">India</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="labels">State/Region</label>
                                <select class="form-control" name="statename" id="statename">
                                    <option selected>Open this select menu</option>
                                    <?php foreach($states as $valstate){?>
                                    <option value="<?php echo $valstate->state_code;?>"
                                        <?php if($valstate->state_code==$users[0]->state){ echo "selected";} ?>>
                                        <?php echo isset($valstate->state_name)?$valstate->state_name:'';?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="labels">District</label>
                                <?php
                                                                    $district=$this->admin_model->getDistrictsall();
                                                                    ?>
                                <select class="form-control" name="district" id="district">
                                    <option selected>Open this select menu</option>
                                    <?php foreach($district as $dist){ ?>
                                    <option value="<?php echo $dist->district_code;?>"
                                        <?php if($users[0]->district==$dist->district_code){ echo "selected";}?>>
                                        <?php echo $dist->district_name;?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label class="labels">Created Date</label>
                                <input type="text" class="form-control" placeholder="insert_date"
                                    value="<?php echo isset($users[0]->dinsert_date)?$users[0]->dinsert_date:''; ?>"
                                    readonly>
                            </div>

                            <div class="col-md-6 form-group">
                                <label class="labels">Status</label>
                                <input type="text" class="form-control" placeholder="Status"
                                    value="<?php echo isset($users[0]->verified)?$users[0]->verified:'';?>" readonly>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="labels">Last Update Date</label>
                                <input type="text" class="form-control"
                                    value="<?php echo isset($users[0]->dupdate_date)?$users[0]->dupdate_date:''; ?>"
                                    readonly>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="labels">Doc Type</label>
                                <select class="form-control" name="idtype" id="idtype">
                                    <option selected>Open this select menu</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                            <div class="col-md-12 form-group">
                                <label class="labels">Uploaded Doc</label>
                                <input type="text" name="doctype" class="form-control" placeholder="Doc Type"
                                    value="<?php echo isset($users[0]->idproof_upd)?$users[0]->idproof_upd:'';?>">
                            </div>
                            <div class="col-md-12">
                                <div class="mt-5 text-center"><button class="btn btn-primary profile-button"
                                        type="submit" name="editprofile" value="editprofile">Save Profile</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?= form_close();?>
                <?= form_fieldset_close(); ?>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view("admin/footer"); ?>