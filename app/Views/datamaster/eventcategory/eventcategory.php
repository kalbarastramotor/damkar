<style>
    #detail-role-table {
        width: 100% !important
    }

    .dataTables_filter {
        text-align: left !important;
    }

    .dataTables_length {
        text-align: right !important;

    }
</style>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header"> <?= $title ?> </div>
                        <div class="card-body">
                            <table id="eventcategory-table" class="table table-striped mb-0"></table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->


    <div id="myModal_add" class="modal fade" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Add Category Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation" novalidate>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="validationCustom02">Event Name</label>
                                    <input type="text" class="form-control" id="eventcategory-name-add" placeholder="Please input Event Name" onkeyup="validateEventcategoryNameAdd(this.id)" required />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="validationCustom02">Event Code</label>
                                    <input type="text" class="form-control" id="eventcategory-code-add" placeholder="Please input Event Code" onkeyup="validateEventcategoryCodeAdd(this.id)" required />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="button" id="button-add-eventcategory" class="btn btn-primary waves-effect waves-light">
                        Save
                    </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div id="myModal_edit" class="modal fade" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Edit Menu Kategoru</h5>
                    <button type="button" class="btn-close close-form-edit" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation" novalidate>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="validationCustom02">Name Menu Kategory</label>
                                    <input type="text" class="form-control" id="eventcategory-name-edit" onkeyup="validateEventcategoryNameEdit(this.id)" required />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="validationCustom02">Kategory Code</label>
                                    <input type="text" class="form-control" id="eventcategory-code-edit" onkeyup="validateEventcategoryNameEdit(this.id)" required />
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="button" id="button-edit-eventcategory" class="btn btn-primary waves-effect waves-light">
                        Update
                    </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>