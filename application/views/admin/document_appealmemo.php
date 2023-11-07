<style>
/* .row.rdoc div {
    padding: 12px 8px;
    border: 1px solid #ababab;
    border-radius: 4px;
  } */
</style>
<div id="progreess" style="display:none;">
    <img src="<?php echo base_url(); ?>asset/images/preview.gif" style=" width: 160px; height: 160px;">
</div>
<div class="row rdoc">

    <div class="col-md-12">
        <table class="table table-bordered table-responsive">
            <?php 
				foreach($requiredDocuments as $rowResult):
				$fileUrl=$rowResult['file_url'];						
					if($fileUrl!=''){					
						$fileUrlEnc=base64_encode($fileUrl);
					}			
				
				?>
            <tr>
                <td class="h5"><b><?=$rowResult['docname']?>: </b></td>
                <td>

                    <?= form_upload(['id'=>$rowResult['docnameunder'], 'class'=>'req_docs','title'=>'Choose file should be pdf format only','accept'=>'application/pdf'])?>
                </td>
                <td id="<?=$rowResult['docnameunder']?>-2" class="<?=$requiredDocuAction?>">
                    <?php if($fileUrl!=''):?>
                    <a href="javascript:void(0)" class="ajax-with-file-dialog btn btn-primary btn-sm"
                        data-target="<?=$fileUrlEnc?>"><i class="fa fa-file-pdf"></i> VIEW
                        FILE</a>
                    <?php endif;?>

                </td>
            </tr>
            <?php endforeach;?>

        </table>
        <input type="hidden" id="saltNo" name="saltNo" value="<?php echo $salt; ?>">



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
$(document).on('click', '.ajax-with-file-dialog', function() {
    var href = base_url + 'getfiles/' + $(this).attr("data-target");
    $('#frameID').attr("src", href + "#view=VFit" + "&toolbar=0" + "&navpanes=0");
    //$("#exampleModalToggle").modal('hide');
    $("#updPdf").modal('show');

});


$('.req_docs').change(function(e) {
    e.preventDefault();
    var filename = $(this).attr('id');
    var action = $('#' + filename + '-2').attr('class');
    var bench = $('#bench').val();
    formdata = new FormData();
    //$('#progreess').show();	
    file = $(this).prop('files')[0], name = $.trim(file.name), name = name.toLowerCase();
    // $('#loading_modal').modal();
    $(this).attr('disabled', true);
    formdata.append("userfile", file);
    formdata.append("salt", $("#saltNo").val());
    formdata.append("filename", filename);
    formdata.append("bench", bench);

    $.ajax({
        type: 'post',
        url: base_url + action,
        data: formdata,
        processData: false,
        contentType: false,
        dataType: 'JSON',
        success: function(response) {

            if (response.data == 'success') {
                var flName = '';
                flName = response.file_name;
                $.alert({
                    title: '<i class="fa fa-check-circle text-success"></i>&nbsp;</b></b>',
                    content: '<p class="text-success">Document uploaded successfully.</p>',
                    animationSpeed: 2000
                });




                $('#' + filename + '-2').html(
                    '<a href="javascript:void(0)" class="ajax-with-file-dialog btn btn-primary btn-sm" data-target="' +
                    flName + '"><i class="fa fa-file-pdf"></i>VIEW FILE</a>');
                //  $('#riframDisplay').attr("src", flName );
                //$('#rDisplay').show();                                
                //$('#documentSave').removeAttr('disabled',false);
                //$('#loading_modal').hide();  

            } else if (response.error != '0') {
                $.alert(response.error);
            }
            $('#' + filename).val('');
            $('.req_docs').removeAttr('disabled', false);
            $('#documentSave').removeAttr('disabled', false);

        },
        error: function(xhr, status) {
            //$.alert('Server busy, try later');
        },
        complete: function() {

            //listUpdFiles();

        }


    });


});



function viewFile(docId) {
    event.preventDefault();
    var href = base_url + 'openfiledraft/' + docId;
    console.log(href);
    $('#frameID').attr("src", href + "#view=VFit" + "&toolbar=0" + "&navpanes=0");
    $('#updPdf').modal('show');
}
</script>