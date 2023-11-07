<?php $this->load->view("admin/header"); ?>
<?php $this->load->view("admin/sidebar"); ?>
<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!--Angualrjs -->
<div class="content" style="" ng-controller="users" data-ng-init="usersInformation()"
    ng-app="my_app">

    <div class="row">
        <div class="card checklistSec"
            style=""> 
                <h3 class="">Audit Trail</h3>
                <table id="example" class="table trial-table display nowrap border" style="width:100%">

                    <tbody> 
                        <?php

                        $txt_file = file_get_contents(FCPATH."/logfile/log.txt"); //Get the file

                        $rows = explode("\n", $txt_file); //Split the file by each line

        $ii=1;
                        foreach ($rows as $row) {
                            $users = explode("|", $row); //Split the line by a space, which is the seperator between username and password

                            echo "<tr>";
                            echo "<td>$ii</td>";
                            foreach($users as $rr){
                                echo "<td>$rr</td>";
                            }


                        echo "</tr>";
                            $ii++;
                        }
                        ?>

                    </tbody>
                </table> 
        </div>
    </div>
</div> 







<?php $this->load->view("admin/footer"); ?>


<script>
$(document).ready(function() {
    $('#example').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
});
</script>