<div id="data-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
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

                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="dd_no" class="col-form-label"> Tr. No.: <span class="text-danger">*</span> </label>
                                <input type="text" id="dd_no" name="dd_no" class="form-control" placeholder="Tr. No."  maxlength="30" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="dd_date" class="col-form-label"> Tr. Date: <span class="text-danger">*</span> </label>
                                <input type="date" id="dd_date" name="dd_date" class="form-control" dateISO="true" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="amount" class="col-form-label"> Amount: <span class="text-danger">*</span> </label>
                                <input type="text" id="amount" name="amount" class="form-control" placeholder="Amount" maxlength="65" required>
                            </div>
                        </div>

                    </div>


                    <div class="form-group text-center">
                        <div class="btn-group">
                            <button type="submit" class="btn btn-success mr-2" id="form-btn">Save</button>
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