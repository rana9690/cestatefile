<!-- <a href="javascript:void(0);" data-toggle="modal" data-target=".modal_1">open modal</a> -->
 <?php error_reporting(); ?>
<div class="modal fade modal_1" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">  
    <div class="modal-dialog modal-lg" style="min-width: 80%;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="mheading"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div> 
            <div class="modal-body">
                <div class="body-message">
                
                    <table id="modal_dataTable" class="display nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sr.No</th>
                                    <th>Reference No</th>
                                    <th>Party</th>
                                    <th>bench</th>
                                    <th>Sub bench</th>
                                    <th>Year</th>
                                    <th>Last Update</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="data-body">
                            </tbody>
                        </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>    
        </div>    
    </div>  
</div>
<script>

    $('#infobox li a').click(function(){
        var heading='', hcount='', final_heading='', flag_name='', table_name='', db_table='', ctype='';
        hcount=$(this).text();
        db_table=$(this).attr('db-table');
        ctype=$(this).attr('ctype');
        //alert(db_table+"\n"+ctype);

        heading=$(this).closest('li').text();
        final_heading=heading.replace(hcount,''); 

        $.ajax({
                type: 'post',
                url: '<?= base_url()?>get_count',
                data: {'db_table':db_table, 'ctype': ctype,'<?=$this->security->get_csrf_token_name()?>':'<?=$this->security->get_csrf_hash();?>'},
                dataType: 'json',
                beforeSend: function(){
                    $('#modal_dataTable').dataTable().fnClearTable();
                    $('#modal_dataTable').dataTable().fnDraw();
                    $('#modal_dataTable').dataTable().fnDestroy();
                },
                success: function(res){
                    if(res.error=='0'){
                        $('#mheading').text(final_heading);       
                        $('.modal_1').modal();
                        $('#data-body').empty();
                        var data='', count=0;
                        $.each(res.data,function(key,val){
                            count=key+1;
                            data='<tr>'+
                                    '<td>'+count+'</td>'+
                                    '<td>R-'+val.salt+'</td>'+
                                    '<td>'+val.pet_name+'</td>'+
                                    '<td>'+val.name+'</td>'+
                                    '<td>'+val.state_name+'</td>'+
                                    '<td><?= date("Y") ?></td>'+
                                    '<td>'+val.update_on+'</td>'+
                                    '<td><a href=\'<?= base_url();?>draftrefiling/'+val.salt+'/'+val.tab_no+'\'>Edit-Final</a></td>'+
                                '</tr>';
                            $('#data-body').append(data);
                        });
                    }
                    else {
                        $.alert(res.error);
                    }
                },
                error: function(){
                    $.alert('Server busy, try later!'); 
                },
                complete: function(){                    
                    $('#modal_dataTable').dataTable();
                }

        });
    });
</script>
<style>
table.dataTable.nowrap td {
    white-space: normal;
}
</style>