<div id="data-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="text-center bg-info p-3" id="model-header">
                <h4 class="modal-title text-white" id="info-header-modalLabel"></h4>
            </div>
            <div class="modal-body">
                <form id="data-form" class="pl-3 pr-3">
                    <input type="hidden" id="csrf_token" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash();?>" />
                    <div class="row">
                        <input type="hidden" id="filing_no" name="filing_no" class="form-control" placeholder="Filing no" minlength="16" maxlength="16">
                        <input type="hidden" id="appfiling_no" name="appfiling_no" class="form-control" minlength="16" maxlength="16">
                        <input type="hidden" id="type" name="type" class="form-control" minlength="3" maxlength="4" required>
                    </div>
                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="securitycode" class="col-form-label"> Security Code. : <span class="text-danger">*</span> </label>
                                <input type="text" id="securitycode" name="securitycode" class="form-control" placeholder="Security Code"  maxlength="6" required>
                            </div>
                        </div>

                    </div>


                    <div class="form-group text-center">
                        <div class="btn-group">
                            <button type="submit" class="btn btn-2 mr-2 " id="form-btn">Save</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table" id="feeDetail">

                            </table>
                        </div>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>