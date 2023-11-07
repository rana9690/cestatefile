<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view("admin/header");
$this->load->view("admin/sidebar");
$this->load->view("admin/stepsdoc");
$salt=$this->session->userdata('docsalt');
$token= $this->efiling_model->getToken();

$tab_no='';
$type='';
$filing_no='';
$partyType='';
$selected_radio1='';
if($salt!=''){
    $basicia= $this->efiling_model->data_list_where('temp_docdetail','salt',$salt);
    if(!empty($basicia)){
        $type=isset($basicia[0]->type)?$basicia[0]->type:'';
        $filing_no=isset($basicia[0]->filing_no)?$basicia[0]->filing_no:'';
        $doctype=isset($basicia[0]->doctype)?$basicia[0]->doctype:'';
        $partyType=isset($basicia[0]->partyType)?$basicia[0]->partyType:'';
        $did=isset($basicia[0]->docids)?$basicia[0]->docids:'';
    }
}

?>
<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script src="<?=base_url('asset/admin_js_final/customs.js')?>"></script>
<style>
.srchWrap {
    margin-left: 194px;
    position: relative;
    float: right;
    width: 100%;
    margin-right: 10px;
}

.srchWrap input {
    padding-left: 35px;
    font-size: 16px;
}

.srchWrap input:focus {
    border: 1px solid #2196f3 !important;
}

.srchWrap i {
    position: absolute;
    left: 12px;
    top: 14px;
}
</style>
<div id="rightbar">

    <?php defined('BASEPATH') OR exit('No direct script access allowed'); error_reporting(0); ?>

    <div class="content" style="padding:0px;">
        <div class="row">
            <div class="card checklistSec" style="">

                <?php 
            echo form_open(false,['class'=>'wizard-form steps-basic wizard clearfix','id'=>'documentUpload','name'=>'documentUpload','autocomplete'=>'off']).
            form_fieldset('Document Upload').
              '<i class="icon-plus-circle2 text-danger d-none" style="position: absolute;padding: 9px 6px;top: 38px;"></i>'.
              '<div class="date-div text-success"></div>';
                ?>
                <input type="hidden" id="saltNo" name="saltNo" value="<?php echo $salt; ?>">
                <input type="hidden" name="token" value="<?php echo $token; ?>" id="token">
                <input type="hidden" id="tabno" name="tabno" value="3">
                <input type="hidden" id="type" name="type" value="<?php echo $type; ?>">
                <input type="hidden" id="valtype" name="valtype" value="<?php echo $type; ?>">

                <div class="row">
                    <div class="col-md-12">
                        <h5 class="text-danger">Documents shall be uploaded after bookmarking only.</h5>
                        <h5 class="text-info">All Files should be in pdf format only. <sup class="text-danger">*</sup>
                        </h5>
                    </div>


                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Document Filed By <sup class="text-danger">*</sup></label>
                            <select id="party_type" class="form-control">
                                <!--option value="">Document filed by</option-->
                                <?php if($partyType==1){?>
                                <option value="appellants" selected>Appellant</option>
                                <?php  } if($partyType==2){?>
                                <option value="respondent" selected>Respondent</option>
                                <?php  } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Document Type <sup class="text-danger">*</sup> </label>
                            <?php 
                                                    $st=$this->efiling_model->data_list_where('temp_documents_upload','salt', $salt);
                                                    $stva=$st[0]->document_type;
                                                    $filingval='';
                                                    $vaba='';
                                                    if($stva=='Vakalatnama'){
                                                        $filingval='va';
                                                        $vaba='1';
                                                    }

                                                    if($did==''){
                                                        echo "<span style='color:red'>Please Select Document from party detail *</span>";die;
                                                    }
                                                    
                                                    $doc=$this->efiling_model->data_list_where('master_document','did', $did);

                                                    ?>
                            <select id="req_dtype" class="form-control" onClick="openmatter(this.value);">
                                <!--option value="">Select Document Type</option-->
                                <?php foreach($doc as $row){ ?>
                                <option value="<?php echo $row->pay . " " . $row->did; ?>">
                                    <?php echo $row->d_name; ?>
                                </option>
                                <?php   } /*
                         if($doctype!='va'){ ?>
                                <option value="02">Proof of Service</option>
                                <?php   } ?>

                                <option value="01">Challan Receipt</option>
                                <?php  if($doctype=='va'){ ?>
                                <option value="03">Board Regulation/ Power of Attorney</option>
                                <option value="04">No Objection Certificate</option>
                                <?php  } */ ?>
                                <!--option value="0">Any other Documents</option-->
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2" id="matter" style="display:none">
                        <div class="form-group">
                            <label>Matter<sup class="text-danger">*</sup></label>
                            <?= form_input(['id'=>'matterc','name'=>'matterc','class'=>'form-control','min'=>0,'max'=>400,'title'=>'Enter min 1 & max 400 pages','style'=>'width:360px'])?>
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Select File <sup class="text-danger">*</sup></label>
                            <?= form_upload(['id'=>'req_docs','title'=>'Choose file should be pdf format only','style'=>'padding:3px','class'=>'form-control','placeholder'=>'choose profile image','accept'=>'application/pdf'])?>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="d-block">Undertaking <sup class="text-danger">*</sup></label>
                            <input class="form-check-input" type="checkbox" value="1" id="flexCheckChecked"
                                <?php echo $checked; ?>>&nbsp;&nbsp;&nbsp;&nbsp;
                                   An undertaking shall be given by the counsel to file
                            the original paper book or IAs complete in all
                            respects including the requisite documents,
                            affidavit and duly signed Vakalatnama/ power of
                            Attorney etc. in original within 3 days from the date of filing.
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-12 text-right">
                        <i class="icon-file-plus"
                            style="position: absolute; margin: 9px 4px; z-index: 9; color: white;"></i>
                        <?= form_submit(['value'=>'Save & Next','class'=>'btn btn-success','id'=>'documentSave','style'=>'padding-left:24px;']) ?>
                        <i class="icon-trash-alt"
                            style="position: absolute; z-index: 9; margin: 10px 4px; color:white;"></i>
                        <?= form_reset(['value'=>'Reset/Clear','class'=>'btn btn-warning','style'=>'padding-left: 24px;'])?>
                    </div>
                </div>
                <?php  form_fieldset_close();
                form_close();
      ?>

                <div class="row m-0">
                    <div class="card w-100 mt-5 inner-card">
                        <fieldset>
                            <legend>Uploaded Documents Details :</legend>

                            <table class="table" style="width: 100%;" border=1>
                                <thead>
                                    <tr class="bg-dark">
                                        <th>SR.No.</th>
                                        <th>Party Type</th>
                                        <th>Document Type</th>
                                        <th>Documents Name</th>
                                        <th>No of Pages</th>
                                        <th>Last Update </th>
                                        <th>View</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody id='updData'>
                                </tbody>
                            </table>
                        </fieldset>

                    </div>
                </div>

                <!--- DISPLAY UPLOADED ID PROOF ------>
                <div class="row" style="padding: 12px;min-height:600px;display:none;" id="rDisplay">
                    <iframe src="" frameborder="0" style="height:580px;width:100%" id="riframDisplay"></iframe>
                </div>
            </div>
        </div>
    </div>



    <!-- Display Uploaded file PDF -->
    <div class="modal fade" id="updPdf" role="dialog">
        <div class="modal-dialog modal-dialog-centered" style="min-width: 90%; margin-top: 190px;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="frame">
                    <iframe style="width: 100%; height: 560px" id="frameID" src=""></iframe>
                </div>
            </div>
        </div>
    </div>

    <script>
    function openmatter(val) {
        var paper = document.getElementById("req_dtype").value;
        var ar = paper.split(" ");
        if (ar[0] == 'ma') {
            $("#matter").hide();
        } else {
            $("#matter").hide();
        }
    }



    $(document).ready(function() {
        listUpdFiles();
    });


    $('#req_docs').change(function(e) {
        e.preventDefault();
        var paper = document.getElementById("req_dtype").value;
        var ar = paper.split(" ");
        var party_type = $('#party_type').find("option:selected").val(),
            req_dtype = $('#req_dtype').find("option:selected").text(),
            req_dtype_val = $('#req_dtype').find("option:selected").val(),
            token = Math.random().toString(36).slice(2),
            docvalid = ar[1],

            token_hash = HASH(token + 'upddoc');
        var salt = $("#saltNo").val();
        var type = $('#type').val();
        var submittype = $('#valtype').val();
        if (ar[0] == 'ma') {
            var matter = $("#matterc").val();
        }

        if (docvalid == undefined) {
            docvalid = document.getElementById("req_dtype").value;
        }

        if (party_type != '' && req_dtype_val != '') {
            formdata = new FormData();
            if ($(this).prop('files').length > 0) {
                $('#progreess').show();
                file = $(this).prop('files')[0], name = $.trim(file.name), name = name.toLowerCase(), size =
                    file.size, type = $.trim(file.type), type = type.toLowerCase();
                var dots = name.match(/\./g).length,
                    extarray = name.split('.'),
                    ext = extarray[1].toLowerCase(),
                    validImageTypes = ["image/gif", "image/jpeg", "image/png"];
                // $('#loading_modal').modal();
                if (file != undefined && type == "application/pdf") {
                    if (dots > 1) {
                        $.alert('More than one dot (.) not allowed in uploding file!');
                        $('#req_doc').val('');
                        return false;
                    } else {
                        $(this).attr('disabled', true);
                        formdata.append("userfile", file),
                            formdata.append("party_type", party_type),
                            formdata.append("req_dtype", req_dtype),
                            formdata.append("token", token),
                            formdata.append("salt", salt);
                        formdata.append("matter", matter);
                        formdata.append("type", type);
                        formdata.append("submittype", submittype);
                        formdata.append("docvalid", docvalid);
                        debugger;
                        $.ajax({
                            type: 'post',
                            url: base_url + 'required_docfil/' + token_hash,
                            data: formdata,
                            processData: false,
                            contentType: false,
                            dataType: 'JSON',
                            success: function(response) {

                                if (response.data == 'success') {
                                    var flName = '';
                                    flName = base_url + response.file_name;
                                    $.alert({
                                        title: '<i class="fa fa-check-circle text-success"></i>&nbsp;</b>Success</b>',
                                        content: '<p class="text-success">Choose document uploaded successfully.</p>',
                                        animationSpeed: 2000
                                    });

                                    $('#req_docs').removeAttr('disabled', false);
                                    $('#riframDisplay').attr("src", flName);
                                    $('#rDisplay').show();

                                    $('#req_dtype').find("option:selected").css('color', 'red')
                                        .attr('disabled', true);
                                    $('#pages').val("");
                                    $('#documentSave').removeAttr('disabled', false);
                                    $('#loading_modal').hide();
                                } else if (response.error != '0') {
                                    $.alert(response.error);
                                }
                            },
                            error: function(xhr, status) {
                                // $.alert('Server busy, try later');
                            },
                            complete: function() {
                                listUpdFiles();
                                setTimeout(function() {
                                    window.location.reload(true);
                                    $('#rightbar').empty().load(base_url +
                                        '/loadpage/doc_upload_doc');
                                }, 500);
                            }
                        });
                    }
                } else {
                    $.alert("Please Choose Valid Document");
                    $('#idproof').val('');
                    return false;
                }
            }
        } else {
            $.alert("Please select all mandatory fields!");
            $('#req_docs').val('');
            return false;
        }
    });

    $('#party_type').change(function() {
        $('#req_dtype').find('option').removeAttr('style', false).removeAttr('disabled', false);
    });

    /****** Form Submit ****** */
    $('#documentUpload').submit(function(e) {
        e.preventDefault();
        //$('#loading_modal').fadeIn(200);
        var salt = $("#saltNo").val();
        var token = '<?php echo  $token; ?>';
        var tabno = $("#tabno").val();
        var ut = document.getElementById("flexCheckChecked").checked;
        var untak = '';
        if (ut == false) {
            var untak = '0';
        }
        if (ut == true) {
            var untak = '1';
        }

        var doctype = '<?php echo $doctype; ?>';
        var filingval = '<?php echo $filingval; ?>';
        var vaba = '<?php echo $vaba; ?>';
        if (doctype == 'va') {
            if (vaba != 1) {
                alert("Please upload vakalatnama!");
                return false;
            }
        }

        $.ajax({
            type: "POST",
            url: base_url + "doc_save_nextDoc",
            data: {
                salt: salt,
                token: token,
                tabno: tabno,
                untak: untak
            },
            dataType: 'json',
            success: function(resp) {
                if (resp.data == 'success') {
                    setTimeout(function() {
                        window.location.href = base_url + 'doc_councel';
                    }, 250);
                } else if (resp.error != '0') {
                    $.alert({
                        title: '<i class="fa fa-check-circle text-warning"></i>&nbsp;</b>Error!</b>',
                        content: '<p class="text-danger">' + resp.error + '</p>',
                        animationSpeed: 2000
                    });
                }
            },
            error: function(request, error) {
                $('#loading_modal').fadeOut(200);
            }
        });
    });

    function listUpdFiles() {
        debugger;
        var saltId = $('#saltNo').val();
        var type = $('#valtype').val();
        $.ajax({
            type: 'post',
            url: base_url + 'viewUpdList',
            data: {
                'saltId': saltId,
                'type': type
            },
            dataType: 'json',
            success: function(rtn) {
                debugger;
                if (rtn.error == '0') {
                    var itemData = '',
                        count = 0;
                    $.each(rtn.data, function(i, item) {
                        count++;
                        var document_filed_by = item.document_filed_by;
                        var document_type = item.document_type;
                        var no_of_pages = item.no_of_pages;
                        var doc_name = item.doc_name;
                        var file_id = item.id;
                        var matter = '';
                        if (item.matter != 'undefined') {
                            var matter = item.matter;
                        }
                        var valumeno = item.valumeno;
                        valumenovc = '';
                        if (valumeno != '') {
                            var valumenovc = '<span style="color:red">Vol-' + item.valumeno +
                                '</span>';
                        }
                        var update_on = item.update_on;
                        update_on = moment(update_on, 'YYYY-MM-DD HH:mm:ss').format(
                            "DD-MM-YYYY HH:mm:ss");
                        itemData += '<tr id="val' + file_id + '"><td>' + count + '</td><td>' +
                            document_filed_by + '</td><td>' + document_type + ' ' + valumenovc +
                            '</td><td>' + doc_name + '</td><td>' + matter + '</td><td>' +
                            no_of_pages + '</td><td>' + update_on +
                            '</td><td id="updDocId"><a href="javascript:void();" onclick=viewFile("' +
                            file_id +
                            '");><i class="fa fa-eye"></i></a></td><td id="updDocId"><a href="javascript:void();" onclick=docDelete("' +
                            file_id +
                            '");><i class="fa fa-trash" aria-hidden="true"></i></a></td></tr>';
                    });
                    $('#updData').html(itemData);
                } else {
                    //$.alert(rtn.data);
                }
            },
            error: function() {
                $.alert("Server busy, try later");
            }
        });
    }

    /*function viewFile(docId){
        event.preventDefault();
        var updId='', href='';
        updId=docId;
        $.ajax({
            type: 'post',
            url: base_url+'uploaded_docs_display',
            data: {docId: updId},
            dataType: 'json',
            success: function(rtn){
                if(rtn.error == '0'){
                    href=base_url+rtn.data;   
                    $('#frameID').attr("src", href + "#view=VFit" + "&toolbar=0" + "&navpanes=0");
                }
                else $.alert(rtn.error);
            },
            error:function(){
              $.alert('Server busy, Try later');
            }
        });
        $('#updPdf').modal('show');
    }*/
    function viewFile(docId) {
        event.preventDefault();
        var href = base_url + 'openfiledraft/' + docId;
        console.log(href);
        $('#frameID').attr("src", href + "#view=VFit" + "&toolbar=0" + "&navpanes=0");
        $('#updPdf').modal('show');
    }


    function docDelete(docId) {
        event.preventDefault();
        var updId = '',
            href = '';
        updId = docId;
        $.ajax({
            type: 'post',
            url: base_url + 'uploaded_docs_delete',
            data: {
                docId: updId
            },
            dataType: 'json',
            success: function(rtn) {
                if (rtn.error == '0') {
                    $.alert({
                        title: '<i class="fa fa-check-circle text-success"></i>&nbsp;</b>Done</b>',
                        content: '<p class="text-success">' + rtn.msg + '</p>',
                        animationSpeed: 2000
                    });
                    setTimeout(function() {
                        window.location.reload(1);
                    }, 1000);
                }
                if (rtn.error == '0') {
                    $("#val" + docId).hide();
                    $('#rDisplay').hide();
                } else $.alert(rtn.error);
            },
            error: function() {
                $.alert('Server busy, Try later');
            }
        });
    }
    </script>
    <?php $this->load->view("admin/footer"); ?>