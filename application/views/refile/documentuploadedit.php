<?php $this->load->view("admin/header"); ?>
<?php $this->load->view("admin/sidebar"); ?>

    <script src="<?= base_url('asset/admin_js_final/customs.js') ?>"></script>
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

        .row.rdoc div {
            /* padding: 12px 8px;
            border: 1px solid #ababab;
            border-radius: 4px; */
        }

        .form-check-input {
            position: inherit;
            display: inline-block;
        }

        .content {
            padding: 0;
        }
    </style>
<?php $this->load->view("admin/stepsrefile"); ?>
    <div id="progreess" style="display:none;"><img src="<?php echo base_url(); ?>asset/images/preview.gif"
                                                   style=" width: 160px; height: 160px;"></div>

    <div class="content" style="padding-top:0px;">
        <div class="row">
            <div class="card checklistSec" style="">
                <div class="content clearfix">
                    <?php
                    echo form_open(false, ['class' => 'wizard-form steps-basic wizard clearfix', 'id' => 'documentUpload', 'name' => 'documentUpload', 'autocomplete' => 'off']) .
                        form_fieldset('Document Upload') .
                        '';
                    $userdata = $this->session->userdata('login_success');
                    $user_id = $userdata[0]->id;
                    $salt = $this->session->userdata('refiling_no');
                    $token = $this->efiling_model->getToken();
                    $st = $this->efiling_model->data_list_where('aptel_case_detail', 'salt', $salt);
                    $ia = $st[0]->no_of_ia;
                    $advytpe = $st[0]->advType;
                    $is_undertaking = $st[0]->is_undertaking;
                    $checked = '';
                    if ($is_undertaking == 1) {
                        $checked = 'checked';
                    }
                    ?>
                    <input type="hidden" id="saltNo" name="saltNo" value="<?php echo $salt; ?>">
                    <input type="hidden" name="token" value="<?php echo $token; ?>" id="token">
                    <input type="hidden" id="tabno" name="tabno" value="7">
                    <input type="hidden" id="type" name="type" value="7">
                    <input type="hidden" id="submittype" name="submittype" value="APP">

                    <div class="row">
                        <div class="col-md-12 mb-3">

                            <h3 class="text-info">All Files should be pdf format only<sup class="text-danger">*</sup>
                            </h3>
                            <span class="text-danger">Note :- Documents shall be uploaded after bookmarking only</span>
                        </div>

                        <div class="col-md-12">
                            <div class="row rdoc">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Submitted By <sup class="text-danger">*</sup></label>
                                        <select id="party_type" class="form-control">
                                            <option value="">Document filed by</option>
                                            <option value="appellants" selected>Appellant/ Counsel for Appellant(s)
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Document Type <sup class="text-danger">*</sup></label>

                                        <?php
                                        $st = $this->efiling_model->data_list_where('efile_documents_upload', 'filing_no', $salt);
                                        $doccount = count($st);
                                        $doc = $this->efiling_model->data_list_where('master_document_efile', 'doctype', 'app');
                                        $isrequest = '';
                                        $defective = $this->efiling_model->defectivelistdfr($salt);
                                        if (!empty($defective) && is_array($defective)) {
                                            if ($defective[0]->defects == 'Y') {
                                                $date1 = date('d-m-Y', strtotime($defective[0]->notification_date));
                                                $date2 = strtotime($date1);
                                                $duedateaa = strtotime("+28 day", $date2);
                                                $duwdateval = date('Y-m-d', $duedateaa);
                                                $currentdate = date('Y-m-d');
                                                if ($duwdateval < $currentdate) {
                                                    $isrequest = 'no';
                                                } else {
                                                    $isrequest = 'yes';
                                                }
                                            }
                                        }


                                        ?>
                                        <input type="hidden" id="countdoc" name="countdoc"
                                               value="<?php echo $doccount; ?>">


                                        <select id="req_dtype" class="form-control" onClick="openmatter(this.value);">
                                            <option value="">Select Document Type</option>
                                            <?php foreach ($doc as $row) {
                                                $disabl = '';
                                                if ($row->docname == 'Vakalatnama' && $advytpe == '2') {
                                                    $disabl = "disabled";
                                                }
                                                ?>
                                                <option
                                                    value="<?php echo $row->id; ?>" <?php echo $disabl; ?>><?php echo $row->docname; ?> </option>
                                                <?php
                                            }
                                            if ($isrequest == 'yes') {
                                                ?>
                                                <option value="03">Request letter for Condonation of Dealy in Refiling
                                                </option>
                                            <?php } ?>
                                            <option value="01">Challan Receipt</option>
                                            <option value="0">Any other Documents</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4" id="matter" style="display:none">
                                    <div class="form-group">
                                        <label>Documents Name<sup class="text-danger">*</sup></label>
                                        <?= form_input(['id' => 'matterc', 'name' => 'matterc', 'class' => 'form-control', 'min' => 0, 'max' => 400, 'title' => 'Enter min 1 & max 400 pages', 'style' => 'width:360px']) ?>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Select File <sup class="text-danger">*</sup></label>

                                        <?= form_upload(['id' => 'req_docs', 'title' => 'Choose file should be pdf format only', 'style' => 'padding:3px', 'class' => 'form-control', 'placeholder' => 'choose profile image', 'accept' => 'application/pdf']) ?>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="d-block">Confirmation <sup class="text-danger">*</sup></label>
                                        <input class="form-check-input" type="checkbox" value="1"
                                               id="flexCheckChecked" <?php echo $checked; ?>>
                                        I confirm that all the requisite documents are uploaded as per the CESTAT
                                        (Procedure) Rules,1982.
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 text-right">
                            <i class="icon-file-plus"
                               style="position: absolute; margin: 9px 4px; z-index: 9; color: white;"></i>'.
                            <?= form_submit(['value' => 'Save & Next', 'class' => 'btn btn-success', 'id' => 'documentSave', 'style' => 'padding-left:24px;']) ?>
                            '&nbsp;&nbsp;&nbsp;&nbsp;<i class="icon-trash-alt"
                                                        style="position: absolute; z-index: 9; margin: 10px 4px; color:white;"></i>
                            <?= form_reset(['value' => 'Reset/Clear', 'class' => 'btn btn-danger', 'style' => 'padding-left: 24px;']) ?>
                        </div>
                    </div>

                    </fieldset>
                    </form>



                    <div class="row m-0">
                        <div class="card w-100 mt-5 inner-card">
                            <fieldset>
                                <legend><b>Document Uploded List<?= $this->lang->line('document-uploded-list') ?></b></legend>

                                    <div class="row alert alert-warning" >
                                        <div class="col-md-12">
                                            <label for="org" class="form-check-label font-weight-semibold">
                                                <input type="radio" name="org" value="1" checked="checked" id="bd1"
                                                       onclick="documentView(this.value);">
                                                Uploaded Document &nbsp;&nbsp;
                                            </label>
                                            <label for="indv" class="form-check-label font-weight-semibold">
                                                <input type="radio" name="org" value="2" id="po1"
                                                       onclick="documentView(this.value);">
                                                Old Uploaded Document &nbsp;&nbsp;
                                            </label>

                                        </div>
                                    </div>

                                    <div class="mx-3" id="new">
                                        <table style="width: 100%;" class="table display" border=1>
                                            <thead>
                                            <tr class="bg-dark">
                                                <th style="width:5%">SR.No.</th>
                                                <th style="width:15%">Party Type</th>
                                                <th style="width:45%">Document Type</th>
                                                <th style="width:35%">Documents Name</th>

                                                <th style="width:15%">No of Pages</th>
                                                <th style="width:5%">Uploded Update</th>
                                                <th style="width:5%">View</th>
                                                <th style="width:5%">Delete</th>
                                            </tr>
                                            </thead>
                                            <tbody id='updData'>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="mx-3" style="display:none" id="old">

                                        <table style="width: 100%;" class="table display" border=1>
                                            <thead>
                                            <tr class="bg-dark">
                                                <th style="width:5%">SR.No.</th>
                                                <th style="width:15%">Party Type</th>
                                                <th style="width:45%">Document Type</th>
                                                <th style="width:35%">Documents Name</th>

                                                <th style="width:15%">No of Pages</th>
                                                <th style="width:5%">Uploded Update</th>
                                                <th style="width:5%">View</th>

                                            </tr>
                                            </thead>
                                            <tbody id='updDataold'>
                                            </tbody>
                                        </table>
                                    </div>
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
        <div class="modal-dialog modal-dialog-centered" style="min-width: 90%;">
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


<?php

$refiling = $this->session->userdata('refiling_no');
$rowd = $this->efiling_model->data_list_where('table_defecttabopen', 'filing_no', $refiling);
if (!empty($rowd) && is_array($rowd)) {
    $numbers = explode(',', $rowd[0]->tabvals);
    $numbers = array_diff($numbers, [0]);
    //$numbers=json_decode($rowd[0]->tabvals);
    sort($numbers);
    $arrlength = count($numbers);
    $vals = array();
    for ($x = 0; $x < $arrlength; $x++) {
        $vals[] = $numbers[$x];
    }

    $num = '7';
    $i = 1;
    $valrr = '';
    foreach ($vals as $key => $val) {
        if ($val > $num) {
            if ($valrr == '') {
                $valrr = $val;
            }
        }
        $i++;
    }

    if ($valrr == 1) {
        $urlv = "applicant-mod";
    }
    if ($valrr == 2) {
        $urlv = "respondentRefile";
    }
    if ($valrr == 3) {
        $urlv = "counselrefile";
    }
    if ($valrr == 4) {
        $urlv = "basicdetails-mod";
    }
    if ($valrr == 5) {
        $urlv = "ia_detailrefile";
    }

    if ($valrr == 6) {
        $urlv = "editother_fee";
    }
    if ($valrr == 7) {
        $urlv = "documentuploadedit";
    }
    if ($valrr == 8) {
        $urlv = "paymentmodeedit";
    }
}
?>


    <script>
        function openmatter(val) {
            if (val == 0) {
                $("#matter").show();
            } else {
                $("#matter").hide();
            }
        }


        $(document).ready(function () {
            listUpdFiles();
        });

        $('#req_docs').change(function (e) {
            e.preventDefault();
            var party_type = $('#party_type').find("option:selected").val(),
                req_dtype = $('#req_dtype').find("option:selected").text(),
                req_dtype_val = $('#req_dtype').find("option:selected").val(),
                docvalid = $('#req_dtype').val(),
                token = Math.random().toString(36).slice(2),
                token_hash = HASH(token + 'upddoc');
            var salt = $("#saltNo").val();
            var submit_type = $('#submittype').val();
            if (req_dtype == 'Any other Document') {
                var matter = $("#matterc").val();
            }
            var type = $('#type').val();
            if (party_type != '' && req_dtype_val != '') {
                formdata = new FormData();
                if ($(this).prop('files').length > 0) {
                    $('#progreess').show();
                    file = $(this).prop('files')[0], name = $.trim(file.name), name = name.toLowerCase(), size = file.size, type = $.trim(file.type), type = type.toLowerCase();
                    var dots = name.match(/\./g).length, extarray = name.split('.'), ext = extarray[1].toLowerCase(), validImageTypes = ["image/gif", "image/jpeg", "image/png"];
                    // $('#loading_modal').modal();
                    if (file != undefined && type == "application/pdf") {

                        if (dots > 1) {
                            $.alert('More than one dot (.) not allowed in uploding file!');
                            $('#req_doc').val('');
                            return false;
                        }
                        else if (size > 1999990) {
                            $.alert('Please select file size less than 2000 KB.');
                            $('#req_doc').val('');
                            return false;
                        }
                        else {
                            $(this).attr('disabled', true);
                            formdata.append("userfile", file),
                                formdata.append("party_type", party_type),
                                formdata.append("req_dtype", req_dtype),
                                formdata.append("token", token),
                                formdata.append("salt", salt);
                            formdata.append("matter", matter);
                            formdata.append("type", type);
                            formdata.append("submittype", submit_type);
                            formdata.append("docvalid", docvalid);
                            $.ajax({
                                type: 'post',
                                url: base_url + 'required_docsedit/' + token_hash,
                                data: formdata,
                                processData: false,
                                contentType: false,
                                dataType: 'JSON',
                                success: function (response) {
                                    if (response.data == 'success') {
                                        var flName = '';
                                        flName = base_url + response.file_name;
                                        $.alert({
                                            title: '<i class="fa fa-check-circle text-success"></i>&nbsp;</b>Congrates</b>',
                                            content: '<p class="text-success">Choose document uploaded successfully.</p>',
                                            animationSpeed: 2000
                                        });

                                        $('#req_docs').removeAttr('disabled', false);
                                        $('#riframDisplay').attr("src", flName);
                                        $('#rDisplay').show();

                                        $('#req_dtype').find("option:selected").css('color', 'red').attr('disabled', true);
                                        $('#pages').val("");
                                        $('#documentSave').removeAttr('disabled', false);
                                        $('#loading_modal').hide();
                                    } else if (response.error != '0') {
                                        $.alert(response.error);
                                    }
                                },
                                error: function (xhr, status) {
                                    $.alert('Server busy, try later');
                                },
                                complete: function () {
                                    listUpdFiles();
                                    setTimeout(function () {
                                        window.location.reload(true);
                                        //$('#rightbar').empty().load(base_url+'/loadpage/document_upload');
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

        $('#party_type').change(function () {
            $('#req_dtype').find('option').removeAttr('style', false).removeAttr('disabled', false);
        });

        /****** Form Submit ****** */
        $('#documentUpload').submit(function (e) {
            e.preventDefault();
            //$('#loading_modal').fadeIn(200);
            var salt = $("#saltNo").val();
            var token = $("#token").val();
            var tabno = $("#tabno").val();
            var docvalid = $('#req_dtype').val();
            var countdoc = $("#countdoc").val();
            if (countdoc == 0) {
                $.alert({
                    title: '<i class="fa fa-check-circle text-warning"></i>&nbsp;</b>Error!</b>',
                    content: '<p class="text-danger">Please Choose Valid Document</p>',
                    animationSpeed: 2000
                });
                return false;
            }

            var ut = document.getElementById("flexCheckChecked").checked;
            var untak = '';
            if (ut == false) {
                var untak = '0';
            }
            if (ut == true) {
                var untak = '1';
            }

            $.ajax({
                type: "POST",
                url: base_url + "doc_save_nextedit",
                data: {salt: salt, token: token, tabno: tabno, untak: untak, docvalid: docvalid},
                dataType: 'json',
                success: function (resp) {
                    if (resp.data == 'success') {
                        setTimeout(function () {
                            window.location.href = base_url + '<?php echo $urlv; ?>';
                        }, 250);
                    }
                    else if (resp.error != '0') {
                        $.alert({
                            title: '<i class="fa fa-check-circle text-warning"></i>&nbsp;</b>Error!</b>',
                            content: '<p class="text-danger">' + resp.data + '</p>',
                            animationSpeed: 2000
                        });

                    }
                },
                error: function (request, error) {
                    $('#loading_modal').fadeOut(200);
                }
            });
        });

        function listUpdFiles() {
            var saltId = $('#saltNo').val();
            $.ajax({
                type: 'post',
                url: base_url + 'viewUpdListEdit',
                data: {'saltId': saltId, 'type': 'APP'},
                dataType: 'json',
                success: function (rtn) {
                    if (rtn.error == '0') {
                        var itemData = '', count = 0;
                        $.each(rtn.data, function (i, item) {
                            count++;
                            var document_filed_by = item.document_filed_by;
                            var document_type = item.document_type;
                            var no_of_pages = item.no_of_pages;
                            var file_id = item.id;
                            var valumeno = item.valumeno;
                            valumenovc = '';
                            if (valumeno != '') {
                                var valumenovc = '<span style="color:red">Vol-' + item.valumeno + '</span>';
                            }
                            var doc_name = item.doc_name;
                            var matter = '';
                            if (item.matter != 'undefined') {
                                var matter = item.matter;
                            }
                            var update_on = item.update_on;
                            update_on = moment(update_on, 'YYYY-MM-DD HH:mm:ss').format("DD-MM-YYYY HH:mm:ss");
                            itemData += '<tr id="val' + file_id + '"><td>' + count + '</td><td>' + document_filed_by + '</td><td>' + document_type + ' ' + valumenovc + '</td><td>' + doc_name + '</td><td>' + no_of_pages + '</td><td>' + update_on + '</td><td id="updDocId"><a href="javascript:void();" onclick=viewFile("' + file_id + '");><i class="fa fa-eye"></i></a></td><td id="updDocId"><a href="javascript:void();" onclick=docDelete("' + file_id + '");><i class="fa fa-trash" aria-hidden="true"></i></a></td></tr>';
                        });
                        $('#updData').html(itemData);

                    }
                    else {
                        //$.alert(rtn.data);
                    }
                },
                error: function () {
                    $.alert("Server busy, try later");
                }
            });
        }


        function listUpdFilesold() {
            var saltId = $('#saltNo').val();
            $.ajax({
                type: 'post',
                url: base_url + 'viewUpdListEditOld',
                data: {'saltId': saltId, 'type': 'APP'},
                dataType: 'json',
                success: function (rtn) {
                    if (rtn.error == '0') {
                        var itemData = '', count = 0;
                        $.each(rtn.data, function (i, item) {
                            count++;
                            var document_filed_by = item.document_filed_by;
                            var document_type = item.document_type;
                            var no_of_pages = item.no_of_pages;
                            var file_id = item.id;
                            var valumeno = item.valumeno;
                            valumenovc = '';
                            if (valumeno != '') {
                                var valumenovc = '<span style="color:red">Vol-' + item.valumeno + '</span>';
                            }
                            var doc_name = item.doc_name;
                            var matter = '';
                            if (item.matter != 'undefined') {
                                var matter = item.matter;
                            }
                            var update_on = item.update_on;
                            update_on = moment(update_on, 'YYYY-MM-DD HH:mm:ss').format("DD-MM-YYYY HH:mm:ss");
                            itemData += '<tr id="val' + file_id + '"><td>' + count + '</td><td>' + document_filed_by + '</td><td>' + document_type + ' ' + valumenovc + '</td><td>' + doc_name + '</td><td>' + no_of_pages + '</td><td>' + update_on + '</td><td id="updDocId"><a href="javascript:void();" onclick=viewFileold("' + file_id + '");><i class="fa fa-eye"></i></a></td><td id="updDocId"></td></tr>';
                        });
                        $('#updDataold').html(itemData);
                    }
                    else {
                        //$.alert(rtn.data);
                    }
                },
                error: function () {
                    $.alert("File not found!");
                }
            });
        }

        function viewFile(docId) {
            event.preventDefault();
            var href = base_url + 'uploaded_docs_displayEdit/' + docId;
            console.log(href);
            $('#frameID').attr("src", href + "#view=VFit" + "&toolbar=0" + "&navpanes=0");
            $('#updPdf').modal('show');
        }


        function docDelete(docId) {
            event.preventDefault();
            var updId = '', href = '';
            updId = docId;
            $.ajax({
                type: 'post',
                url: base_url + 'uploaded_docs_deleteEdit',
                data: {docId: updId},
                dataType: 'json',
                success: function (rtn) {
                    if (rtn.error == '0') {
                        $.alert({
                            title: '<i class="fa fa-check-circle text-success"></i>&nbsp;</b>Done</b>',
                            content: '<p class="text-success">' + rtn.msg + '</p>',
                            animationSpeed: 2000
                        });
                        setTimeout(function () {
                            window.location.reload(1);
                        }, 1000);
                    }
                    if (rtn.error == '0') {
                        $("#val" + docId).hide();
                        $('#rDisplay').hide();
                    }
                    else $.alert(rtn.error);
                },
                error: function () {
                    $.alert('Server busy, Try later');
                }
            });
        }


        function documentView() {
            var checkboxes = document.getElementsByName('org');
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked) {
                    idorg = checkboxes[i].value;
                }
            }
            if (idorg == 1) {
                listUpdFiles();
                document.getElementById("new").style.display = "block";
                document.getElementById("old").style.display = "none";
            }
            if (idorg == 2) {
                listUpdFilesold();
                document.getElementById("old").style.display = "block";
                document.getElementById("new").style.display = "none";
            }
        }


        function viewFileold(docId) {
            event.preventDefault();
            var href = base_url + 'uploaded_docs_displayEditold/' + docId;
            console.log(href);
            $('#frameID').attr("src", href + "#view=VFit" + "&toolbar=0" + "&navpanes=0");
            $('#updPdf').modal('show');
        }
    </script>


<?php $this->load->view("admin/footer"); ?>