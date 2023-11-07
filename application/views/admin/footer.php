<div class="text-center inner-ftr w-100">Copyright © 2023 CESTAT. All rights reserved.</div>
</div> <!-- content-wrapper -->

</div> <!-- page-content -->

<!---- Loading Modal ------------->
<div class="modal fade bd-example-modal-lg" data-backdrop="static" data-keyboard="false" tabindex="-1"
    id="loading_modal">
    <div class="modal-dialog modal-sm" style="margin: 25% 50%; text-align: center;">
        <div class="modal-content" style="width: 90px; height: 90px; padding: 15px 25px;">
            <span class="fa fa-spinner fa-spin fa-3x"></span>
            <p class="text-danger" style="margin: 12px -12px;">Loading.....</p>
        </div>
    </div>
</div>
</body>

</html>

<script src="<?= base_url('asset/admin_js_final/jquery.dataTables.min.js'); ?>"></script>
<script src="<?= base_url('asset/admin_js_final/dataTables.bootstrap4.min.js'); ?>"></script>
<!-- <script src="<?=base_url('asset/admin_js_final/bootstrap.bundle.min.js')?>"></script> -->
<script src="<?=base_url('asset/admin_js_final/bootstrap.min.js')?>"></script>
<script src="<?=base_url('asset/admin_js_final/blockui.min.js')?>"></script>
<script src="<?=base_url('asset/admin_js_final/d3.min.js')?>"></script>
<script src="<?=base_url('asset/admin_js_final/d3_tooltip.js')?>"></script>
<script src="<?=base_url('asset/admin_js_final/switchery.min.js')?>"></script>
<script src="<?=base_url('asset/admin_js_final/bootstrap_multiselect.js')?>"></script>
<script src="<?=base_url('asset/admin_js_final/moment.min.js')?>"></script>
<script src="<?=base_url('asset/admin_js_final/daterangepicker.js')?>"></script>
<script src="<?=base_url('asset/admin_js_final/app.js')?>"></script>
<script src="<?=base_url('asset/admin_js_final/dashboard.js')?>"></script>
<script src="<?=base_url('asset/admin_js_final/jquery-ui.js')?>"></script>
<script src="<?=base_url('asset/admin_js_final/crypto-js.js')?>"></script>
<script src="<?=base_url('asset/admin_js_final/customs.js')?>"></script>
<script src="<?= base_url('asset/APTEL_files/jquery-confirm.js');?>"></script>
<script src="<?=base_url('asset/admin_js_final/efiling.js')?>"></script>
<script src="<?=base_url('asset/admin_js_final/appcore.js')?>"></script>
<script src="<?= base_url('asset/APTEL_files/hash.js'); ?>"></script>
<script src="<?= base_url('asset/admin_js_final/popper.min.js'); ?>"
    integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous">
</script>
<script type="text/javascript">
var base_url = '',
    salt = '',
    _CSRF_NAME_ = '';
base_url = '<?php echo base_url(); ?>';
_CSRF_NAME_ = '<?=$this->security->get_csrf_token_name()?>';
salt = '<?php echo hash("sha512",strtotime(date("d-m-Y i:H:s"))); ?>';
$('.datepicker').datepicker({
    dateFormat: 'dd-mm-yy',
    changeYear: true
});
</script>
<script src="<?=base_url('asset/admin_js_final/jquery.redirect.js')?>"> </script>